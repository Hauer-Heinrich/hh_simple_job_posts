<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\Controller;

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Log\Logger;
use \TYPO3\CMS\Core\Log\LogLevel;
use \TYPO3\CMS\Core\Messaging\AbstractMessage;
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
     * @param \TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view
     * @return void
     */
    public function initializeView(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view): void {
        $this->settings['loaded']['hh_seo'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('hh_seo');

        $this->view->assignMultiple([
            'settings' => $this->settings,
            'data' => $this->configurationManager->getContentObject()->data
        ]);
    }

    /**
     * switchAction
     *
     * @param \HauerHeinrich\HhSimpleJobPosts\Domain\Model\Jobpost $jobpost
     * @return void
     */
    public function switchAction(\HauerHeinrich\HhSimpleJobPosts\Domain\Model\Jobpost $jobpost = null) {
        // $showDetailView = intval($this->settings['showDetailView']);

        if (empty($jobpost)) {
            $this->forward('list');
            // TYPO3 >= 11 return new ForwardResponse('list');
        }

        // $this->addFlashMessage(
        //     'No detail view selected! Check plugin settings.',
        //     'Error',
        //     AbstractMessage::ERROR
        // );

        $this->forward('show');
        // TYPO3 >= 11 return new ForwardResponse('show');
    }

    /**
     * action list
     *
     * @param HauerHeinrich\HhSimpleJobPosts\Domain\Model\Jobpost
     * @return void
     */
    public function listAction(): void {
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

                return;
            }

            $cacheUtility = GeneralUtility::makeInstance(\HauerHeinrich\HhSimpleJobPosts\Utility\CacheUtility::class);
            $cacheIdentifier = sha1("externalData-".$this->settings['useExternalApi']."-".$this->settings['jobsStorage']);
            $cacheEntry = $cacheUtility->getCachedValue($cacheIdentifier);

            $assignedValues = [];
            $assignedValues['jobsStorage'] = \intval($this->settings['jobsStorage']);
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
                                    AbstractMessage::ERROR,
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
                                AbstractMessage::ERROR,
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
                        $oldEntries = $this->jobpostRepository->findAllByPid($assignedValues['jobsStorage']);
                        foreach ($oldEntries as $key => $oldEntry) {
                            $this->jobpostRepository->deleteReally($oldEntry['uid']);
                        }

                        // Save new entries to database
                        foreach ($jobposts as $key => $job) {
                            $this->jobpostRepository->add($job);
                        }
                        $persistenceManager->persistAll();

                        // write to cache
                        $cacheUtility->setCacheValue(
                            $cacheIdentifier,
                            [$this->settings['useExternalApi']],
                            [ $this->settings['useExternalApi'], 'pid' => $assignedValues['jobsStorage'] ],
                            \intval($assignedValues['apiCacheDuration'])
                        );

                        $jobposts = $this->jobpostRepository->findAll();

                        $this->view->assignMultiple([
                            'jobposts' => $jobposts
                        ]);

                        return;
                    }

                    $this->addFlashMessage(
                        '$assignedValues["jobposts"] is not an array!',
                        'ERROR',
                        AbstractMessage::ERROR,
                        false
                    );

                    return;
                }
            }

            // for example if JobpostsListEvent returns error then look if old jobposts are available
            $jobposts = $this->jobpostRepository->findByPid(intval($assignedValues['jobsStorage']));

            $this->view->assignMultiple([
                'jobposts' => $jobposts
            ]);

            return;
        }

        return;
    }

    /**
     * action show
     *
     * @param HauerHeinrich\HhSimpleJobPosts\Domain\Model\Jobpost
     * @return void
     */
    public function showAction(\HauerHeinrich\HhSimpleJobPosts\Domain\Model\Jobpost $jobpost = null): void {
        if(!empty($jobpost)) {
            $typoLinkCodec = GeneralUtility::makeInstance(\TYPO3\CMS\Frontend\Service\TypoLinkCodecService::class);

            if(empty($jobpost->getContactPointAddress())) {
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

            $this->view->assignMultiple([
                'view' => 'detail',
                'jobpost' => $jobpost,
                'contactPoint' => [
                    'contactPointEmail' => $contactPointEmail,
                    'contactPointTelephone' => $contactPointTelephone
                ]
            ]);
        }
    }
}
