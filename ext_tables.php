<?php
defined('TYPO3_MODE') || die();

call_user_func(static function() {

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'HhSimpleJobPosts',
        'Jobslist',
        'Jobs List'
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'HhSimpleJobPosts',
        'Jobsdetail',
        'Jobs Detail'
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('hh_simple_job_posts', 'Configuration/TypoScript', 'Job posts - simple');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hhsimplejobposts_domain_model_jobpost', 'EXT:hh_simple_job_posts/Resources/Private/Language/locallang_csh_tx_hhsimplejobposts_domain_model_jobpost.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hhsimplejobposts_domain_model_jobpost');

});
