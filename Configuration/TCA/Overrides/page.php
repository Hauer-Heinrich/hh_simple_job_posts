<?php
defined('TYPO3') || die();

call_user_func(function() {
    $extensionKey = 'hh_simple_job_posts';

    // make PageTsConfig selectable
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
        $extensionKey,
        'Configuration/TsConfig/AllPage.typoscript',
        'Simple Job Posts Page TS'
    );
});
