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
        ]
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
        ]
    );

    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'hh_simple_job_posts-plugin-jobslist',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:hh_simple_job_posts/Resources/Public/Icons/user_plugin_jobslist.svg']
    );

    $iconRegistry->registerIcon(
        'hh_simple_job_posts-plugin-jobsdetail',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:hh_simple_job_posts/Resources/Public/Icons/user_plugin_jobsdetail.svg']
    );

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['hhsimplejobposts_jobsfromapi'] ??= [];
});
