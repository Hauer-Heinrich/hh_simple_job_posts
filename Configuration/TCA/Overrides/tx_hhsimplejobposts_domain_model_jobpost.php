<?php
defined('TYPO3_MODE') || die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
    'hh_simple_job_posts',
    'tx_hhsimplejobposts_domain_model_jobpost'
);
