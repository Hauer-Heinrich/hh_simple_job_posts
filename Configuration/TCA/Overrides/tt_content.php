<?php
defined('TYPO3') || die();

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(function(string $extensionKey) {
    $GLOBALS['TCA']['tt_content']['columns']['CType']['config']['itemGroups']['jobs'] = 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_mod.xlf:contentelement.wizard.title';

    $plugins = [
        'jobslist',
        'jobsdetail'
    ];

    foreach ($plugins as $plugin) {
        $pluginSignature = ExtensionUtility::registerPlugin(
            $extensionKey,
            GeneralUtility::underscoredToUpperCamelCase($plugin),
            'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_mod.xlf:contentelement.'.$plugin.'.title',
            'hh_simple_job_posts-plugin-' . str_replace('_', '-', $plugin),
            'jobs',
        );

        ExtensionManagementUtility::addPiFlexFormValue(
            '*',
            'FILE:EXT:' . $extensionKey . '/Configuration/FlexForms/' . $pluginSignature . '.xml',
            $pluginSignature
        );

        $GLOBALS['TCA']['tt_content']['types'][$pluginSignature]['showitem'] = '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                --palette--;;general,
                --palette--;;headers,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin,
                pi_flexform,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                --palette--;;frames,
                --palette--;;appearanceLinks,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                --palette--;;language,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                --palette--;;hidden,
                --palette--;;access,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
                categories,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
                rowDescription,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
        ';
    }


    // Adds the content element to the "Type" dropdown
    // ExtensionManagementUtility::addTcaSelectItem(
    //     'tt_content',
    //     'CType',
    //     [
    //         'label' => 'LLL:EXT:'.$extensionKey.'/Resources/Private/Language/locallang_db.xlf:extbase_title',
    //         'value' => $pluginSignature,
    //         'icon' => '',
    //         'group' => 'ext-quotes',
    //         'description' => ''
    //     ],
    //     'textmedia',
    //     'after'
    // );
}, 'hh_simple_job_posts');
