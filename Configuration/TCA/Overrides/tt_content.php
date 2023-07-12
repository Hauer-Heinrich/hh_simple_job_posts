<?php
defined('TYPO3') || die();

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$extensionKey = 'hh_simple_job_posts';
$extensionName = GeneralUtility::underscoredToUpperCamelCase($extensionKey);
$extensionNameLower = strtolower($extensionName);

// List
$pluginName = 'jobslist';
$pluginSignature = $extensionNameLower . '_' . strtolower($pluginName);

ExtensionUtility::registerPlugin(
    $extensionKey,
    $pluginName,
    'Jobs'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'select_key,recursive,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:' . $extensionKey . '/Configuration/FlexForms/' . $pluginSignature . '.xml'
);
// ---------------
