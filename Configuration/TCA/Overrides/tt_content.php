<?php
defined('TYPO3_MODE') || die();

$extensionKey = 'hh_simple_job_posts';
$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extensionKey);
$extensionNameLower = strtolower($extensionName);

// List
$pluginName = 'jobslist';
$pluginSignature = $extensionNameLower . '_' . strtolower($pluginName);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $extensionKey,
    $pluginName,
    'Jobs'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'select_key,recursive,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:' . $extensionKey . '/Configuration/FlexForms/' . $pluginSignature . '.xml'
);
// ---------------
