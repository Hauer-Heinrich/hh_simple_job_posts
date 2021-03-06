<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\UserFunc;

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Database\ConnectionPool;

class TcaJobpostProcFunc {

    /**
     * contactAddressItems
     *
     * @param array $config
     * @return array
     */
    public function contactAddressItems(array $config): array {
        $storagePidContactPointAddresses = intval($config['config']['parameters']['storagePidContactPointAddresses']);
        $itemList = [];
        $rows = $this->getContactPoints($storagePidContactPointAddresses);
        foreach ($rows as $row) {
            if($row['tx_extbase_type'] === 'ttAddress_location') {
                $itemList[] = [$row['company'].' ('.$row['city'] . ' - id: ' . $row['uid'].')', $row['uid']];
                continue;
            }

            $itemList[] = [$row['name'].' ('.$row['uid'].')', $row['uid']];
        }
        $itemList[] = ['not selected', 0];
        $config['items'] = $itemList;

        return $config;
    }

    /**
     * companyAddressItems
     *
     * @param array $config
     * @return array
     */
    public function companyAddressItems(array $config): array {
        $storagePidOrganizations = intval($config['config']['parameters']['storagePidOrganizations']);
        $itemList = [];
        $rows = $this->getCompanies($storagePidOrganizations);
        foreach ($rows as $row) {
            $itemList[] = [$row['company'].' ('.$row['city'].')', $row['uid']];
        }
        $itemList[] = ['not selected', 0];
        $config['items'] = $itemList;

        return $config;
    }

    /**
     * getContactPoints
     * Gets addresses from tt_address - if pid = 0 then all Address are returned
     *
     * @param integer $pid
     * @return array
     */
    public function getContactPoints(int $pid = 0): array {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_address');
        $whereExpressions = [];

        if ($pid > 0) {
            $whereExpressions[] = $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($pid));
        }

        $queryBuilder
            ->select('uid', 'name', 'company', 'city', 'tx_extbase_type')
            ->from('tt_address');
        if(!empty($whereExpressions)) {
            $queryBuilder->where(...$whereExpressions);
        }
        $results = $queryBuilder->execute()
            ->fetchAll();

        return $results;
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
            ->from('tt_address');
        if(!empty($whereExpressions)) {
            $queryBuilder->where(...$whereExpressions);
        }
        $results = $queryBuilder->execute()
            ->fetchAll();

        return $results;
    }
}
