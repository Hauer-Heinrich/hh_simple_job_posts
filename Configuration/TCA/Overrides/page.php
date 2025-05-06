<?php
defined('TYPO3') || die();

use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(function(string $extensionKey) {
    // make PageTsConfig selectable
    ExtensionManagementUtility::registerPageTSConfigFile(
        $extensionKey,
        'Configuration/TsConfig/AllPage.tsconfig',
        'Simple Job Posts Page TS'
    );

    // additional / extra config for: jobposts
    ExtensionManagementUtility::registerPageTSConfigFile(
        $extensionKey,
        'Configuration/TsConfig/jobpost-only.tsconfig',
        'Additional / extra config for: jobposts'
    );

    ExtensionManagementUtility::registerPageTSConfigFile(
        $extensionKey,
        'Configuration/TsConfig/jobpost-googlejobs.tsconfig',
        'Additional / extra config for: jobposts google jobs'
    );
}, 'hh_simple_job_posts');
