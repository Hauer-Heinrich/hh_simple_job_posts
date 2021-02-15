<?php
$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
$configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
$extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
$storagePidOrganizations = $extbaseFrameworkConfiguration['plugin.']['tx_hhsimplejobposts_jobslist.']['persistence.']['storagePidOrganizations'];

return [
    'ctrl' => [
        'title' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'sortby' => 'sorting',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'title,description,maintasks,profile,weprovide,others',
        'iconfile' => 'EXT:hh_simple_job_posts/Resources/Public/Icons/tx_hhsimplejobposts_domain_model_jobpost.gif'
    ],
    'palettes' => [
        'salary' => [
            'showitem' => 'base_salary_currency, base_salary_value',
        ],
    ],
    'interface' => [
        'showRecordFieldList' => '
            sys_language_uid,
            l10n_parent,
            l10n_diffsource,
            hidden,
            title,
            description,
            maintasks,
            profile,
            weprovide,
            others,
            employment_type,
            work_hours,
            hiring_organization,
            slug
        ',
    ],
    'types' => [
        '1' => [
            'showitem' => '
                sys_language_uid,
                l10n_parent,
                l10n_diffsource,
                hidden,
                title,
                description,
                maintasks,
                profile,
                weprovide,
                others,
                employment_type,
                work_hours,
                hiring_organization,
                slug,
                --div--;LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.div.salary,
                    --palette--;;salary,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
                    starttime,
                    endtime
            '
        ],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_hhsimplejobposts_domain_model_jobpost',
                'foreign_table_where' => 'AND {#tx_hhsimplejobposts_domain_model_jobpost}.{#pid}=###CURRENT_PID### AND {#tx_hhsimplejobposts_domain_model_jobpost}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'crdate' => [
            'exclude' => true,
            'config' => [
                'type' => 'select',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'tstamp' => [
            'exclude' => true,
            'config' => [
                'type' => 'select',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int,required',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'slug' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:pages.slug',
            'displayCond' => 'VERSION:IS:false',
            'config' => [
                'type' => 'slug',
                'size' => 50,
                'generatorOptions' => [
                    'fields' => ['title'],
                    'fieldSeparator' => '-',
                    'replacements' => [
                        '/' => '-'
                    ],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'unique',
                'default' => ''
            ]
        ],

        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ],
                ],
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],

        ],
        'maintasks' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.maintasks',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ],
                ],
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],

        ],
        'profile' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.profile',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ],
                ],
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],

        ],
        'weprovide' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.weprovide',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ],
                ],
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],

        ],
        'others' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.others',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ],
                ],
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],

        ],
        'employment_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.employment_type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['full-time', 'full-time'],
                    ['part-time', 'part-time'],
                    ['contract', 'contract'],
                    ['temporary', 'temporary'],
                    ['seasonal', 'seasonal'],
                    ['internship', 'internship'],
                ],
                'size' => 1,
                'maxitems' => 1,
                'eval' => '',
                'default' => 'full-time',
            ],
        ],
        'work_hours' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.work_hours',
            'description' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.work_hours.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'hiring_organization' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.hiring_organization',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    '0' => [
                        '0' => 'not selected',
                        '1' => 0,
                    ],
                ],
                // 'foreign_table' => 'tt_address',
                // 'foreign_table_where' => 'AND tt_address.pid = '.intval($storagePidOrganizations),
                'itemsProcFunc' => 'HauerHeinrich\\HhSimpleJobPosts\\UserFunc\\TcaJobpostProcFunc->companyAddressItems',
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'base_salary_currency' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.base_salary_currency',
            'description' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.base_salary_currency.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => 'EUR',
            ],
        ],
        'base_salary_value' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.base_salary_value',
            'description' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.base_salary_value.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,int',
            ],
        ],
    ],
];
