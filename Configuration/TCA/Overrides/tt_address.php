<?php
defined('TYPO3_MODE') || die();

$generalLanguageFilePrefix = 'LLL:EXT:core/Resources/Private/Language/';

if (!isset($GLOBALS['TCA']['tt_address']['ctrl']['type'])) {
    // no type field defined, so we define it here. This will only happen the first time the extension is installed!!
    $GLOBALS['TCA']['tt_address']['ctrl']['type'] = 'tx_extbase_type';
    $tempColumns_tt_address = [];
    $tempColumns_tt_address[$GLOBALS['TCA']['tt_address']['ctrl']['type']] = [
        'exclude' => true,
        'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhextjobsdahoam.tx_extbase_type',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['default','ttAddress_default'],
                ['location','ttAddress_location']
            ],
            'default' => 'ttAddress_default',
            'size' => 1,
            'maxitems' => 1,
        ]
    ];
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_address', $tempColumns_tt_address);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tt_address',
    $GLOBALS['TCA']['tt_address']['ctrl']['type'],
    '',
    'after:' . $GLOBALS['TCA']['tt_address']['ctrl']['label']
);

/* inherit and extend the show items from the parent class */
if (isset($GLOBALS['TCA']['tt_address']['types']['0']['showitem'])) {
    // $GLOBALS['TCA']['tt_address']['ctrl']['label_userFunc'] = 'HauerHeinrich\\HhExtJobsdahoam\\Userfuncs\\TcaTtAddress->companyTitle';
    $GLOBALS['TCA']['tt_address']['types']['ttAddress_location']['showitem'] = $GLOBALS['TCA']['tt_address']['types']['0']['showitem'];
} elseif(is_array($GLOBALS['TCA']['tt_address']['types'])) {
    // use first entry in types array
    $tt_address_type_definition = reset($GLOBALS['TCA']['tt_address']['types']);
    // $GLOBALS['TCA']['tt_address']['types']['ttAddress_location']['showitem'] = $tt_address_type_definition['showitem'];
} else {
    $GLOBALS['TCA']['tt_address']['types']['ttAddress_location']['showitem'] = '';
}

$GLOBALS['TCA']['tt_address']['ctrl']['label_alt'] = 'company';
$GLOBALS['TCA']['tt_address']['types']['ttAddress_location']['showitem'] = '
    --palette--;LLL:EXT:tt_address/Resources/Private/Language/locallang_db.xlf:tt_address_palette.organization;organization,
    image, description,

    --div--;LLL:EXT:tt_address/Resources/Private/Language/locallang_db.xlf:tt_address_tab.address,
        --palette--;LLL:EXT:tt_address/Resources/Private/Language/locallang_db.xlf:tt_address_palette.address;address,
        --palette--;LLL:EXT:tt_address/Resources/Private/Language/locallang_db.xlf:tt_address_palette.coordinates;coordinates,

    --div--;LLL:EXT:tt_address/Resources/Private/Language/locallang_db.xlf:tt_address_tab.contact,
        --palette--;LLL:EXT:tt_address/Resources/Private/Language/locallang_db.xlf:tt_address_palette.contact;contact,
        --palette--;LLL:EXT:tt_address/Resources/Private/Language/locallang_db.xlf:tt_address_palette.building;building,
        --palette--;LLL:EXT:tt_address/Resources/Private/Language/locallang_db.xlf:tt_address_palette.social;social,

    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
        --palette--;;language,

    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
        --palette--;;paletteHidden,
        --palette--;;paletteAccess,

    --div--;' . $generalLanguageFilePrefix . 'locallang_tca.xlf:sys_category.tabs.category, categories
';
