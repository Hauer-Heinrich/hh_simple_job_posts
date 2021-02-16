<?php
$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
$configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
$extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
$storagePidOrganizations = $extbaseFrameworkConfiguration['plugin.']['tx_hhsimplejobposts_jobslist.']['persistence.']['storagePidOrganizations'];
$storagePidContactPointAddresses = $extbaseFrameworkConfiguration['plugin.']['tx_hhsimplejobposts_jobslist.']['persistence.']['storagePidContactPointAddresses'];

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
            'showitem' => 'base_salary_currency, base_salary_value, base_salary_value_max, base_salary_unit_text'
        ],
        'contactPoint' => [
            'showitem' => 'contact_point_email, contact_point_telephone'
        ],
        'opengraph' => [
            'label' => 'LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.palettes.opengraph',
            'showitem' => 'og_title, --linebreak--, og_description, --linebreak--, og_image',
        ],
        'twittercards' => [
            'label' => 'LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.palettes.twittercards',
            'showitem' => 'twitter_title, --linebreak--, twitter_description, --linebreak--, twitter_image, --linebreak--, twitter_card',
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
            education_requirements,
            experience_requirements,
            skills,
            weprovide,
            others,
            employment_type,
            work_hours,
            hiring_organization,
            job_location,
            base_salary_currency,
            base_salary_value,
            base_salary_value_max,
            base_salary_unit_text,
            contact_point_email,
            contact_point_telephone,
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
                education_requirements,
                experience_requirements,
                skills,
                weprovide,
                others,
                employment_type,
                work_hours,
                hiring_organization,
                job_location,
                slug,
                --div--;LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.div.salary,
                    --palette--;;salary,
                --div--;LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.div.contact_point,
                    contact_point_address,
                    --palette--;Used if no "Contact Address" is given;contactPoint,
                --div--;Media,
                    images,
                --div--;SEO,
                    --palette--;;opengraph,
                    --palette--;;twittercards,
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
            'description' => 'also used for validThrough date',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
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
        'education_requirements' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.education_requirements',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
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
        'experience_requirements' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.experience_requirements',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
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
        'skills' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.skills',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
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
                'renderType' => 'selectCheckBox',
                'items' => [
                    '0' => [
                        '0' => 'FULL_TIME',
                        '1' => 'FULL_TIME',
                    ],
                    '1' => [
                        '0' => 'PART_TIME',
                        '1' => 'PART_TIME',
                    ],
                    '2' => [
                        '0' => 'CONTRACTOR',
                        '1' => 'CONTRACTOR',
                    ],
                    '3' => [
                        '0' => 'TEMPORARY',
                        '1' => 'TEMPORARY',
                    ],
                    '4' => [
                        '0' => 'INTERN',
                        '1' => 'INTERN',
                    ],
                    '5' => [
                        '0' => 'VOLUNTEER',
                        '1' => 'VOLUNTEER',
                    ],
                    '6' => [
                        '0' => 'PER_DIEM',
                        '1' => 'PER_DIEM',
                    ],
                    '7' => [
                        '0' => 'OTHER',
                        '1' => 'OTHER',
                    ],
                ],
                'size' => 1,
                'eval' => '',
                'default' => 'FULL_TIME',
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
                // 'foreign_table' => 'tt_address',
                // 'foreign_table_where' => 'AND tt_address.pid = '.intval($storagePidOrganizations),
                'itemsProcFunc' => 'HauerHeinrich\\HhSimpleJobPosts\\UserFunc\\TcaJobpostProcFunc->companyAddressItems',
                'parameters' => [
                    'storagePidOrganizations' => $storagePidOrganizations
                ],
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'job_location' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.job_location',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'itemsProcFunc' => 'HauerHeinrich\\HhSimpleJobPosts\\UserFunc\\TcaJobpostProcFunc->companyAddressItems',
                'parameters' => [
                    'storagePidOrganizations' => $storagePidOrganizations
                ],
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
                'eval' => 'double2,trim',
            ],
        ],
        'base_salary_value_max' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.base_salary_value_max',
            'description' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.base_salary_value_max.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2,trim',
            ],
        ],
        'base_salary_unit_text' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.base_salary_unit_text',
            'description' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.base_salary_unit_text.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['HOUR', 'HOUR'],
                    ['DAY', 'DAY'],
                    ['WEEK', 'WEEK'],
                    ['MONTH', 'MONTH'],
                    ['YEAR', 'YEAR'],
                ],
                'size' => 1,
                'maxitems' => 1,
                'eval' => 'trim',
                'default' => 'MONTH',
            ],
        ],

        'contact_point_email' => [
            'displayCond' => 'FIELD:contact_point_address:=:0',
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.contact_point_email',
            'description' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.contact_point_email.description',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
                'size' => 30,
                'eval' => 'trim',
                'fieldControl' => [
                    'linkPopup' => [
                        'options' => [
                            'blindLinkOptions' => 'file, folder, page, spec, telephone, url'
                        ]
                    ]
                ]
            ],
        ],
        'contact_point_telephone' => [
            'displayCond' => 'FIELD:contact_point_address:=:0',
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.contact_point_telephone',
            'description' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.contact_point_telephone.description',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
                'size' => 30,
                'eval' => 'trim',
                'default' => 'EUR',
                'fieldControl' => [
                    'linkPopup' => [
                        'options' => [
                            'blindLinkOptions' => 'file, folder, mail, page, spec, url'
                        ]
                    ]
                ]
            ],
        ],
        'contact_point_address' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.contact_point_address',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'itemsProcFunc' => 'HauerHeinrich\\HhSimpleJobPosts\\UserFunc\\TcaJobpostProcFunc->contactAddressItems',
                'parameters' => [
                    'storagePidContactPointAddresses' => $storagePidContactPointAddresses
                ],
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],

        'images' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.images',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'fal_media',
                [
                    'behaviour' => [
                        'allowLanguageSynchronization' => true,
                    ],
                    'appearance' => [
                        'showPossibleLocalizationRecords' => true,
                        'showRemovedLocalizationRecords' => true,
                        'showAllLocalizationLink' => true,
                        'showSynchronizationLink' => true
                    ],
                    // 'foreign_match_fields' => [
                    //     'fieldname' => 'fal_media',
                    //     'tablenames' => 'tx_news_domain_model_news',
                    //     'table_local' => 'sys_file',
                    // ],
                ],
                // $GLOBALS['TYPO3_CONF_VARS']['SYS']['mediafile_ext']
                'jpeg,jpg,png,gif,svg'
            )
        ],


        'og_title' => [
            'exclude' => true,
            'l10n_mode' => 'prefixLangTitle',
            'label' => 'LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.og_title',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'max' => 255,
                'eval' => 'trim'
            ]
        ],
        'og_description' => [
            'exclude' => true,
            'l10n_mode' => 'prefixLangTitle',
            'label' => 'LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.og_description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 3
            ]
        ],
        'og_image' => [
            'exclude' => true,
            'label' => 'LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.og_image',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'og_image',
                [
                    // Use the imageoverlayPalette instead of the basicoverlayPalette
                    'overrideChildTca' => [
                        'types' => [
                            '0' => [
                                'showitem' => '
                                    --palette--;;imageoverlayPalette,
                                    --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                                    --palette--;;imageoverlayPalette,
                                    --palette--;;filePalette'
                            ]
                        ],
                        'columns' => [
                            'crop' => $openGraphCropConfiguration
                        ]
                    ],
                    'behaviour' => [
                        'allowLanguageSynchronization' => true
                    ]
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            )
        ],
        'twitter_title' => [
            'exclude' => true,
            'l10n_mode' => 'prefixLangTitle',
            'label' => 'LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.twitter_title',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'max' => 255,
                'eval' => 'trim'
            ]
        ],
        'twitter_description' => [
            'exclude' => true,
            'l10n_mode' => 'prefixLangTitle',
            'label' => 'LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.twitter_description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 3
            ]
        ],
        'twitter_image' => [
            'exclude' => true,
            'label' => 'LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.twitter_image',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'twitter_image',
                [
                    // Use the imageoverlayPalette instead of the basicoverlayPalette
                    'overrideChildTca' => [
                        'types' => [
                            '0' => [
                                'showitem' => '
                                    --palette--;;imageoverlayPalette,
                                    --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                                    --palette--;;imageoverlayPalette,
                                    --palette--;;filePalette'
                            ]
                        ],
                        'columns' => [
                            'crop' => $openGraphCropConfiguration
                        ]
                    ],
                    'behaviour' => [
                        'allowLanguageSynchronization' => true
                    ]
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            )
        ],
        'twitter_card' => [
            'exclude' => true,
            'label' => 'LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.twitter_card',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 'summary',
                'items' => [
                    ['LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.twitter_card.summary', 'summary'],
                    ['LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.twitter_card.summary_large_image', 'summary_large_image'],
                ]
            ]
        ],
    ],
];
