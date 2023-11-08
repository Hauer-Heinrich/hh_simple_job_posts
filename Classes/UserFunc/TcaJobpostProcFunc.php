<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\UserFunc;

/**
 * This file is part of the "hh_simple_job_posts" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Christian Hackl <chackl@hauer-heinrich.de>, www.Hauer-Heinrich.de
 */

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Database\ConnectionPool;
use \TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

class TcaJobpostProcFunc {

    /**
     * pluginConfiguration
     * TypoScript plugin configuration
     *
     * @var array
     */
    protected array $pluginConfiguration = [];

    public function __construct(protected readonly ConfigurationManager $configurationManager) {
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $this->pluginConfiguration = isset($extbaseFrameworkConfiguration['plugin.']['tx_hhsimplejobposts.']) ? $extbaseFrameworkConfiguration['plugin.']['tx_hhsimplejobposts.'] : [];
    }

    /**
     * contactAddressItems
     *
     * @param array $config
     * @return array
     */
    public function contactAddressItems(array $config): array {
        $storagePidContactPointAddresses = isset($this->pluginConfiguration['persistence.']['storagePidContactPointAddresses']) ? intval($this->pluginConfiguration['persistence.']['storagePidContactPointAddresses']) : 0;
        $itemList = [];
        $rows = $this->getContactPoints($storagePidContactPointAddresses);

        foreach ($rows as $row) {
            if($row['tx_extbase_type'] === 'place') {
                $itemList[] = [$row['company'].' ('.$row['city'] . ' - id: ' . $row['uid'].')', $row['uid']];
                continue;
            }

            if(!empty($row['name'])) {
                $name = $row['name'];
            } else {
                $name = $row['first_name'] . ' ' . $row['last_name'];
            }

            $itemList[] = [$name.' ('.$row['uid'].')', $row['uid']];
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
        $storagePidOrganizations = isset($this->pluginConfiguration['persistence.']['storagePidOrganizations']) ? intval($this->pluginConfiguration['persistence.']['storagePidOrganizations']) : 0;
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
     * getJobLocationsTcaItems
     *
     * @param array $configuration Current field configuration
     * @throws \UnexpectedValueException
     * @internal
     */
    public function getJobLocationsTcaItems(array &$configuration): void {
        $storagePidOrganizations = isset($this->pluginConfiguration['persistence.']['storagePidOrganizations']) ? intval($this->pluginConfiguration['persistence.']['storagePidOrganizations']) : 0;
        $locations = $this->getContactPoints($storagePidOrganizations);

        if(!empty($locations)) {
            foreach ($locations as $key => $location) {
                if($location['tx_extbase_type'] === 'place') {
                    $itemLabel = $location['company'] . " (" . $location['city'] . " Uid: " . \strval($location['uid']) . ")";
                    $configuration['items'][] = [$itemLabel, $location['uid']];
                }
            }
        }
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
            ->select('uid', 'name', 'first_name', 'last_name', 'email', 'company', 'city', 'tx_extbase_type')
            ->from('tt_address');
        if(!empty($whereExpressions)) {
            $queryBuilder->where(...$whereExpressions);
        }
        $results = $queryBuilder->executeQuery()->fetchAllAssociative();

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
        $results = $queryBuilder->executeQuery()->fetchAllAssociative();

        return $results;
    }

    /**
     * getJobLocationsTcaItems
     *
     * @param array $configuration Current field configuration
     * @throws \UnexpectedValueException
     * @internal
     */
    public function getContactPointAddressesTcaItems(array &$configuration): void {
        $storagePidContactPointAddresses = isset($this->pluginConfiguration['persistence.']['storagePidContactPointAddresses']) ? intval($this->pluginConfiguration['persistence.']['storagePidContactPointAddresses']) : 0;
        $contactPointAddresses = $this->getContactPoints($storagePidContactPointAddresses);

        if(!empty($contactPointAddresses)) {
            foreach ($contactPointAddresses as $address) {
                if($address['tx_extbase_type'] !== 'place') {
                    $itemLabel = $address['first_name'] . " " . $address['last_name'] . " (" . $address['email'] . ")";
                    $configuration['items'][] = [$itemLabel, $address['uid']];
                }
            }
        }
    }
}
