<?php
defined('TYPO3') || die();

call_user_func(function() {

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'HhSimpleJobPosts',
        'Jobslist',
        [
            \HauerHeinrich\HhSimpleJobPosts\Controller\JobpostController::class => 'list, show, switch'
        ],
        // non-cacheable actions
        [
            \HauerHeinrich\HhSimpleJobPosts\Controller\JobpostController::class => ''
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'HhSimpleJobPosts',
        'Jobsdetail',
        [
            \HauerHeinrich\HhSimpleJobPosts\Controller\JobpostController::class => 'switch, show'
        ],
        // non-cacheable actions
        [
            \HauerHeinrich\HhSimpleJobPosts\Controller\JobpostController::class => ''
        ]
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    jobslist {
                        iconIdentifier = hh_simple_job_posts-plugin-jobslist
                        title = LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hh_simple_job_posts_jobslist.name
                        description = LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hh_simple_job_posts_jobslist.description
                        tt_content_defValues {
                            CType = list
                            list_type = hhsimplejobposts_jobslist
                        }
                    }
                    jobsdetail {
                        iconIdentifier = hh_simple_job_posts-plugin-jobsdetail
                        title = LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hh_simple_job_posts_jobsdetail.name
                        description = LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hh_simple_job_posts_jobsdetail.description
                        tt_content_defValues {
                            CType = list
                            list_type = hhsimplejobposts_jobsdetail
                        }
                    }
                }
                show = *
            }
        }'
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

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['hhsimplejobposts_jobsFromApi'] ??= [];
});
