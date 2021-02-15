<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\UserFunc;

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Database\ConnectionPool;

class TcaJobpostProcFunc {

    /**
     * companyAddressItems
     *
     * @param array $config
     * @return array
     */
    public function companyAddressItems(array $config): array {
        $itemList = [];
        $rows = $this->getCompanies(134);
        foreach ($rows as $row) {
            $itemList[] = [$row['company'].' ('.$row['city'].')', $row['uid']];
        }
        $config['items'] = $itemList;

        return $config;
    }

    /**
     * getCompanies
     * Gets addresses from tt_address - if pid = 0 then all Address are returned
     *
     * @param integer $pid
     * @return array
     */
    public function getCompanies(int $pid = 0): array {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_address');

        $whereExpressions = [];

        if ($pid > 0) {
            $whereExpressions[] = $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($pid));
         }

        $results = $queryBuilder
            ->select('uid', 'company', 'city')
            ->from('tt_address')
            ->where(...$whereExpressions)
            ->execute()
            ->fetchAll();

        return $results;
    }
}
