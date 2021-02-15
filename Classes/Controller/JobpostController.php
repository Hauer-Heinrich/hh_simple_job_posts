<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\Controller;

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 *
 * This file is part of the "Job posts - simple" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Christian Hackl <chackl@hauer-heinrich.de>, www.Hauer-Heinrich.de
 */

/**
 * This file is part of the "Job posts - simple" Extension for TYPO3 CMS.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 * (c) 2021 Christian Hackl <chackl@hauer-heinrich.de>, www.Hauer-Heinrich.de
 * This file is part of the "Job offers - simple" Extension for TYPO3 CMS.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 * (c) 2021 Christian Hackl <chackl@hauer-heinrich.de>, www.Hauer-Heinrich.de
 * JobpostController
 */
class JobpostController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * @var array
     */
    protected $settings = [];

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * jobpostRepository
     *
     * @var \HauerHeinrich\HhSimpleJobPosts\Domain\Repository\JobpostRepository
     */
    protected $jobpostRepository = null;

    /**
     * injectConfigurationManager
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
     * @return void
     */
    public function injectConfigurationManager(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager): void {
        $this->configurationManager = $configurationManager;
    }

    /**
     * @param \HauerHeinrich\HhSimpleJobPosts\Domain\Repository\JobpostRepository $JobpostRepository
     */
    public function injectJobpostRepository(\HauerHeinrich\HhSimpleJobPosts\Domain\Repository\JobpostRepository $jobpostRepository) {
        $this->jobpostRepository = $jobpostRepository;
    }

    /**
     * Settings aus dem ConfigurationManager ziehen und zuweisen
     * @param \TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view
     * @return void
     */
    public function initializeView(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view): void {
        $settings = $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS
        );

        $this->settings = $settings;

        $this->view->assignMultiple([
            'settings' => $this->settings,
            'data' => $this->configurationManager->getContentObject()->data
        ]);
    }

    /**
     * action list
     *
     * @param HauerHeinrich\HhSimpleJobPosts\Domain\Model\Jobpost
     * @return void
     */
    public function listAction(): void {
        $jobposts = $this->jobpostRepository->findAll();
        $this->view->assign('jobposts', $jobposts);
    }

    /**
     * action show
     *
     * @param HauerHeinrich\HhSimpleJobPosts\Domain\Model\Jobpost
     * @return void
     */
    public function showAction(\HauerHeinrich\HhSimpleJobPosts\Domain\Model\Jobpost $jobpost): void {
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
            'jobpost' => $jobpost,
            'contactPoint' => [
                'contactPointEmail' => $contactPointEmail,
                'contactPointTelephone' => $contactPointTelephone
            ]
        ]);
    }
}
