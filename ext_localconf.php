<?php
defined('TYPO3') || die();

use \TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use \HauerHeinrich\HhSimpleJobPosts\Controller\JobpostController;

call_user_func(function() {

    ExtensionUtility::configurePlugin(
        'HhSimpleJobPosts',
        'Jobslist',
        [
            JobpostController::class => 'list, show, switch'
        ],
        // non-cacheable actions
        [
            JobpostController::class => ''
        ],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );

    ExtensionUtility::configurePlugin(
        'HhSimpleJobPosts',
        'Jobsdetail',
        [
            JobpostController::class => 'switch, show'
        ],
        // non-cacheable actions
        [
            JobpostController::class => ''
        ],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['hhsimplejobposts_jobsfromapi'] ??= [];
});
