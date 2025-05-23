<?php

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
        'iconfile' => 'EXT:hh_simple_job_posts/Resources/Public/Icons/tx_hhsimplejobposts_domain_model_jobpost.gif',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'palettes' => [
        'language' => ['showitem' => 'sys_language_uid, l10n_parent'],
        'visibility' => [
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.visibility',
            'showitem' => 'hidden;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:pages.hidden_toggle_formlabel, nav_hide;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:pages.nav_hide_toggle_formlabel',
        ],
        'access' => [
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.access',
            'showitem' => 'starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.starttime_formlabel, endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.endtime_formlabel, extendToSubpages;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.extendToSubpages_formlabel, --linebreak--, fe_group;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.fe_group_formlabel, --linebreak--,editlock',
        ],
        'salary' => [
            'showitem' => 'base_salary_currency, base_salary_value, base_salary_value_max, base_salary_unit_text'
        ],
        'contactPoint' => [
            'showitem' => 'contact_point_email,contact_point_telephone'
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
    'types' => [
        '1' => [
            'showitem' => '
                title,
                short_description,
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
                job_locations,
                slug,
                --div--;LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.div.salary,
                    --palette--;;salary,
                --div--;LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.div.contact_point,
                    contact_point_address,
                    contact_point_addresses,
                    --palette--;Used if no "Contact Address" is given;contactPoint,
                --div--;Media,
                    images,
                    downloads,
                --div--;SEO,
                    --palette--;;opengraph,
                    --palette--;;twittercards,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    --palette--;;language,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.access,
                    --palette--;;visibility,
                    --palette--;;access,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
                    categories,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
                    rowDescription,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
            '
        ],
    ],
    'columns' => [
        'crdate' => [
            'exclude' => true,
            'config' => [
                'type' => 'datetime',
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
                'type' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
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
        'pid' => [
            'exclude' => 0,
            'label' => '',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'categories' => [
            'config' => [
                'type' => 'category'
            ],
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
        'short_description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.short_description',
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
                'itemsProcFunc' => 'HauerHeinrich\\HhSimpleJobPosts\\UserFunc\\TcaJobpostProcFunc->companyAddressItems',
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'job_locations' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.job_locations',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'itemsProcFunc' => 'HauerHeinrich\HhSimpleJobPosts\UserFunc\TcaJobpostProcFunc->getJobLocationsTcaItems',
                'default' => 0,
                'size' => 10,
                'autoSizeMax' => 30,
                'minitems' => 0,
                'maxitems' => 100,
                'multiple' => 0,
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => true,
                    ],
                    'addRecord' => [
                        'disabled' => true,
                    ],
                    'listModule' => [
                        'disabled' => true,
                    ],
                ],
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
                ],
            ],
        ],
        'contact_point_telephone' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.contact_point_telephone',
            'description' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.contact_point_telephone.description',
            'config' => [ // buggy like hell for phone links only
                'type' => 'link',
                'size' => 30,
                'eval' => 'trim',
                'default' => '',
                'placeholder' => '+49 851 654 754 33',
                'allowedTypes' => ['telephone']
            ],
        ],
        'contact_point_address' => [ // TODO: @deprecated - moved to contact_point_addresses below
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.contact_point_address',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'itemsProcFunc' => 'HauerHeinrich\\HhSimpleJobPosts\\UserFunc\\TcaJobpostProcFunc->contactAddressItems',
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1,
                'readOnly' => 1,
            ],
        ],

        'contact_point_addresses' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.contact_point_addresses',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'itemsProcFunc' => 'HauerHeinrich\HhSimpleJobPosts\UserFunc\TcaJobpostProcFunc->getContactPointAddressesTcaItems',
                'default' => 0,
                'size' => 10,
                'autoSizeMax' => 30,
                'minitems' => 0,
                'maxitems' => 100,
                'multiple' => 0,
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => true,
                    ],
                    'addRecord' => [
                        'disabled' => true,
                    ],
                    'listModule' => [
                        'disabled' => true,
                    ],
                ],
            ],
        ],

        'images' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.images',
            'config' => [
                'type' => 'file',
                'allowed' => ['jpeg', 'jpg', 'png', 'gif', 'svg'],
            ],
        ],
        'downloads' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hh_simple_job_posts/Resources/Private/Language/locallang_db.xlf:tx_hhsimplejobposts_domain_model_jobpost.downloads',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-media-types,'
            ],
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
            'config' => [
                'type' => 'file',
                'allowed' => ['jpeg', 'jpg', 'png', 'gif', 'svg'],
            ],
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
            'config' => [
                'type' => 'file',
                'allowed' => ['jpeg', 'jpg', 'png', 'gif', 'svg'],
            ],
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
