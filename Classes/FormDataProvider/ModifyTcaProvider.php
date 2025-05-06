<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\FormDataProvider;

use \TYPO3\CMS\Backend\Form\FormDataProviderInterface;
use \TYPO3\CMS\Core\Utility\GeneralUtility;

class ModifyTcaProvider implements FormDataProviderInterface {
    public function addData(array $result): array {
        // Prüfen ob es sich um einen neuen Datensatz handelt
        if ($result['command'] !== 'new') {
            return $result;
        }

        // Prüfen ob es sich um die richtige Tabelle handelt
        if ($result['tableName'] !== 'tx_hhsimplejobposts_domain_model_jobpost') {
            return $result;
        }

        $pageId = (int)$result['effectivePid'];

        // PageTS der aktuellen Seite laden
        $pageTsConfig = $this->getPagesTSconfig($pageId);

        if (
            isset($pageTsConfig['tx_hhsimplejobposts_domain_model_jobpost.']['settings.']['setGoogleJobsRequiredFields'])
            && $pageTsConfig['tx_hhsimplejobposts_domain_model_jobpost.']['settings.']['setGoogleJobsRequiredFields'] === '1'
        ) {
            $result['processedTca']['columns']['starttime']['config']['required'] = true;
            $result['processedTca']['columns']['endtime']['description'] = 'Required if you have a application deadline.';
            $result['processedTca']['columns']['hiring_organization']['config']['required'] = true;
            $result['processedTca']['columns']['job_locations']['config']['required'] = true;
        }

        return $result;
    }

    protected function getPagesTSconfig(int $pageId): array
    {
        return GeneralUtility::makeInstance(\TYPO3\CMS\Backend\Utility\BackendUtility::class)
            ->getPagesTSconfig($pageId);
    }
}
