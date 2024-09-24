<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "hh_simple_job_posts"
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF['hh_simple_job_posts'] = [
    'title' => 'Hauer-Heinrich - Job posts - simple',
    'description' => 'Adds plugins for list / show job postings with meta-data and schema.org stuff. Uses tt_address for job-contacts and job-location.',
    'category' => 'plugin',
    'author' => 'Christian Hackl',
    'author_email' => 'chackl@hauer-heinrich.de',
    'state' => 'beta',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '4.1.6',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.4.99',
            'fluid_styled_content' => '^12.2.0',
            'tt_address' => '^7.0.0 || ^8.0.0 || ^9.0.0',
            'hh_tt_address_places' => '^2.0.0'
        ],
        'conflicts' => [],
        'suggests' => [
            'hh_seo' => ''
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'HauerHeinrich\\HhSimpleJobPosts\\' => 'Classes'
        ],
    ],
];
