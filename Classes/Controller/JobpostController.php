<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\Controller;

use \Psr\Http\Message\ResponseInterface;
// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use \TYPO3\CMS\Extbase\Http\ForwardResponse;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use \TYPO3\CMS\Core\Log\Logger;
use \TYPO3\CMS\Core\Log\LogLevel;
use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use \HauerHeinrich\HhSimpleJobPosts\Domain\Model\Jobpost;
use \HauerHeinrich\HhSimpleJobPosts\Domain\Repository\JobpostRepository;

/**
 * This file is part of the "hh_simple_job_posts" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Christian Hackl <chackl@hauer-heinrich.de>, www.Hauer-Heinrich.de
 */

/**
 * JobpostController
 */
class JobpostController extends ActionController {

    protected Logger $logger;

    /**
     * jobpostRepository
     */
    protected JobpostRepository $jobpostRepository;

    public function __construct(\TYPO3\CMS\Core\Log\LogManager $logger, JobpostRepository $jobpostRepository) {
        $this->logger = $logger->getLogger(__CLASS__);
        $this->jobpostRepository = $jobpostRepository;
    }

    /**
     * Settings aus dem ConfigurationManager ziehen und zuweisen
     * @return void
     */
    public function initializeView(): void {
        $this->settings['loaded']['hh_seo'] = ExtensionManagementUtility::isLoaded('hh_seo');

        $this->view->assignMultiple([
            'settings' => $this->settings,
            'data' => $this->configurationManager->getContentObject()->data
        ]);
    }

    /**
     * switchAction
     *
     * @param \HauerHeinrich\HhSimpleJobPosts\Domain\Model\Jobpost $jobpost
     * @return ResponseInterface
     */
    public function switchAction(\HauerHeinrich\HhSimpleJobPosts\Domain\Model\Jobpost $jobpost = null): ResponseInterface {
        $queryParams = $this->request->getQueryParams();
        if (empty($jobpost) && empty($queryParams['tx_hhsimplejobposts_jobslist']['jobpost'])) {
            return (new ForwardResponse('list'));
        }

        // $this->addFlashMessage(
        //     'No detail view selected! Check plugin settings.',
        //     'Error',
        //     AbstractMessage::ERROR
        // );

        return (new ForwardResponse('show'));
    }

    /**
     * action list
     *
     * @param HauerHeinrich\HhSimpleJobPosts\Domain\Model\Jobpost
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface {
        $this->view->assignMultiple([
            'view' => 'list'
        ]);

        if(isset($this->settings['useExternalApi'])) {
            $jobposts = [];

            // default way - jobs created at the TYPO3 Backend - no API is used
            if($this->settings['useExternalApi'] === 'default') {
                $jobposts = $this->jobpostRepository->findByPid(intval($this->settings['jobsStorage']));

                $this->view->assignMultiple([
                    'jobposts' => $jobposts
                ]);

                return $this->htmlResponse();
            }

            $cacheUtility = GeneralUtility::makeInstance(\HauerHeinrich\HhSimpleJobPosts\Utility\CacheUtility::class);
            $cacheIdentifier = sha1("externalData-".$this->settings['useExternalApi']."-".$this->settings['jobsStorageApi']);
            $cacheEntry = $cacheUtility->getCachedValue($cacheIdentifier);

            $assignedValues = [];
            $assignedValues['jobsStorageApi'] = \intval($this->settings['jobsStorageApi']);
            $assignedValues['apiCacheDuration'] = 86400; // 1 Day
            $assignedValues['jobposts'] = [];
            $assignedValues['error'] = [
                // custom like below or GuzzleHttp\Exception\ClientException
                /* [
                    'title' => '',
                    'message' => '',
                    'code' => '',
                    'file' => '',
                    'line' => ''
                ] */
            ];

            if(empty($cacheEntry)) {
                $requestEvent = $this->eventDispatcher->dispatch(new \HauerHeinrich\HhSimpleJobPosts\Event\JobpostsListEvent($this, $this->settings, $assignedValues, $this->request));
                $assignedValues = $requestEvent->getAssignedValues();

                // Erros given, write to logger and set FlashMessages
                if(!empty($assignedValues['error'])) {
                    foreach ($assignedValues['error'] as $error) {
                        if($error instanceof \GuzzleHttp\Exception\ClientException) {
                            if($this->settings['flashMessages'] === 1) {
                                $this->addFlashMessage(
                                    $error->getMessage(),
                                    'Error',
                                    ContextualFeedbackSeverity::ERROR,
                                    false
                                );
                            }

                            $this->logger->log(
                                LogLevel::ERROR,
                                $error->getMessage(),
                                [
                                    'code' => $error->getCode(),
                                    'file' => $error->getFile(),
                                    'line' => $error->getLine()
                                ]
                            );

                            continue;
                        }

                        if($this->settings['flashMessages'] === 1) {
                            $this->addFlashMessage(
                                $error['message'],
                                'Error',
                                ContextualFeedbackSeverity::ERROR,
                                false
                            );
                        }

                        $this->logger->log(
                            LogLevel::ERROR,
                            $error['message'],
                            [
                                'code' => $error['code'],
                                'file' => $error['file'],
                                'line' => $error['line']
                            ]
                        );
                    }
                }

                $jobposts = $assignedValues['jobposts'];
                // TODO: save jobLocations to database! tt_address
                // TODO: save hiringOrganization to database! tt_address
                if(!empty($jobposts)) {
                    if(\is_array($jobposts)) {
                        /** @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager */
                        $persistenceManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);

                        // Delete old entries
                        $oldEntries = $this->jobpostRepository->findAllByPid(intval($assignedValues['jobsStorageApi']));
                        foreach ($oldEntries as $oldEntry) {
                            $this->jobpostRepository->deleteReally($oldEntry['uid']);
                        }

                        // Save new entries to database
                        foreach ($jobposts as $job) {
                            $this->jobpostRepository->add($job);
                        }
                        $persistenceManager->persistAll();

                        // write to cache
                        $cacheUtility->setCacheValue(
                            $cacheIdentifier,
                            [$this->settings['useExternalApi']],
                            [ $this->settings['useExternalApi'], 'pid' => $assignedValues['jobsStorageApi'] ],
                            \intval($assignedValues['apiCacheDuration'])
                        );
                    }

                    $this->addFlashMessage(
                        '$assignedValues["jobposts"] is not an array!',
                        'ERROR',
                        ContextualFeedbackSeverity::ERROR,
                        false
                    );
                }
            }

            $jobsPidList = [];
            // set ordering of result jobslist
            if($this->settings['orderJobsDefaultToApi']) {
                // Default jobs
                if (!empty($this->settings['jobsStorage'])) {
                    array_push($jobsPidList, intval($this->settings['jobsStorage']));
                }
                // Jobs from event / API
                if (!empty($assignedValues['jobsStorageApi'])) {
                    array_push($jobsPidList, intval($assignedValues['jobsStorageApi']));
                }
            } else {
                // Jobs from event / API
                if (!empty($assignedValues['jobsStorageApi'])) {
                    array_push($jobsPidList, intval($assignedValues['jobsStorageApi']));
                }
                // Default jobs
                if (!empty($this->settings['jobsStorage'])) {
                    array_push($jobsPidList, intval($this->settings['jobsStorage']));
                }
            }

            if(!empty($jobsPidList)) {
                $jobposts = $this->jobpostRepository->findAllByPids($jobsPidList);

                $this->view->assignMultiple([
                    'jobposts' => $jobposts
                ]);
            }
        }

        return $this->htmlResponse();
    }

    /**
     * action show
     * if domain.tld/.../my_job_detail_url/job.json is given, then returns this job as json!
     *
     * @param Jobpost
     * @return ResponseInterface
     */
    public function showAction(Jobpost $jobpost = null): ResponseInterface {
        $queryParams = $this->request->getQueryParams();
        if(empty($jobpost) && isset($queryParams['tx_hhsimplejobposts_jobslist']['jobpost']) && \is_numeric($queryParams['tx_hhsimplejobposts_jobslist']['jobpost'])) {
            $jobpost = $this->jobpostRepository->findByUid(intval($queryParams['tx_hhsimplejobposts_jobslist']['jobpost']));
        }

        if(!empty($jobpost)) {
            $contactPointEmail = null;
            $contactPointTelephone = null;

            if(empty($jobpost->getContactPointAddress())) {
                $typoLinkCodec = GeneralUtility::makeInstance(\TYPO3\CMS\Core\LinkHandling\TypoLinkCodecService::class);

                if (!empty($jobpost->getContactPointEmail())) {
                    $contactPointEmailArray = $typoLinkCodec->decode($jobpost->getContactPointEmail());
                    $emailLinkHandler = GeneralUtility::makeInstance(\TYPO3\CMS\Core\LinkHandling\EmailLinkHandler::class);
                    $contactPointEmail = $emailLinkHandler->resolveHandlerData(['email' => $contactPointEmailArray['url']])['email'];
                }

                if(!empty($jobpost->getContactPointTelephone())) {
                    $contactPointTelephoneArray = $typoLinkCodec->decode($jobpost->getContactPointTelephone());
                    $telephoneLinkHandler = GeneralUtility::makeInstance(\TYPO3\CMS\Core\LinkHandling\TelephoneLinkHandler::class);
                    $contactPointTelephone = $telephoneLinkHandler->resolveHandlerData(['telephone' => $contactPointTelephoneArray['url']])['telephone'];
                }
            } else {
                $contactPointAddress = $jobpost->getContactPointAddress();
                $contactPointEmail = $contactPointAddress->getEmail();
                $contactPointTelephone = $contactPointAddress->getPhone();
            }

            if($GLOBALS['TSFE']->type === 587951) {
                $jobPostArray = $this->formatJobToArray($jobpost);
                $jsonOutput = [
                    'view' => 'detail',
                    'jobpost' => $jobPostArray,
                    'contactPoint' => [
                        'contactPointEmail' => $contactPointEmail,
                        'contactPointTelephone' => $contactPointTelephone
                    ]
                ];

                return $this->jsonResponse(\json_encode($jsonOutput));
            }

            $this->view->assignMultiple([
                'view' => 'detail',
                'jobpost' => $jobpost,
                'contactPoint' => [
                    'contactPointEmail' => $contactPointEmail,
                    'contactPointTelephone' => $contactPointTelephone
                ]
            ]);
        }

        return $this->htmlResponse();
    }

    /**
     * formatJobToArray
     * Maps a Job object to array
     *
     * @param  Jobpost $jobpost
     * @return array
     */
    function formatJobToArray(Jobpost $jobpost): array {
        $result = [];
        $job = $this->jobpostRepository->getJobArray($jobpost->getUid());

        if(isset($job['job_locations']) && $job['job_locations'] !== '0') {
            $job['job_locations'] = $this->jobpostRepository->getJobLocationsArray($job['job_locations']);
        }

        if(isset($job['contact_point_address']) && $job['contact_point_address'] !== 0) {
            $job['contact_point_address'] = $this->jobpostRepository->getContactPointAddress($job['contact_point_address']);
        }

        if(isset($job['images']) && $job['images'] !== 0) {
            $fileRepository = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\FileRepository::class);
            $jobImages = $fileRepository->findByRelation('tx_hhsimplejobposts_domain_model_jobpost', 'images', $jobpost->getUid());

            if(!empty($jobImages)) {
                $images = [];

                foreach ($jobImages as $key => $image) {
                    $images[$key] = $image->toArray();
                }

                $job['images'] = $images;
            }
        }

        if(isset($job['downloads']) && $job['downloads'] !== 0) {
            $fileRepository = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\FileRepository::class);
            $jobDownloads = $fileRepository->findByRelation('tx_hhsimplejobposts_domain_model_jobpost', 'downloads', $jobpost->getUid());

            if(!empty($jobDownloads)) {
                $downloads = [];

                foreach ($jobDownloads as $key => $download) {
                    $downloads[$key] = $download->toArray();
                }

                $job['downloads'] = $downloads;
            }
        }

        return $job;
    }
}
