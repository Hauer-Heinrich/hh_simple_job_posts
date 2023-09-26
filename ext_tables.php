<?php
defined('TYPO3') || die();

use \TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(static function() {

    ExtensionUtility::registerPlugin(
        'HhSimpleJobPosts',
        'Jobslist',
        'Jobs List'
    );

    ExtensionUtility::registerPlugin(
        'HhSimpleJobPosts',
        'Jobsdetail',
        'Jobs Detail'
    );

    ExtensionManagementUtility::addStaticFile('hh_simple_job_posts', 'Configuration/TypoScript', 'Job posts - simple');

    ExtensionManagementUtility::addLLrefForTCAdescr('tx_hhsimplejobposts_domain_model_jobpost', 'EXT:hh_simple_job_posts/Resources/Private/Language/locallang_csh_tx_hhsimplejobposts_domain_model_jobpost.xlf');
    ExtensionManagementUtility::allowTableOnStandardPages('tx_hhsimplejobposts_domain_model_jobpost');
});
