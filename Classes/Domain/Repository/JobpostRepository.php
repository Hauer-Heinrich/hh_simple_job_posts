<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\Domain\Repository;

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * This file is part of the "hh_simple_job_posts" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Christian Hackl <chackl@hauer-heinrich.de>, www.Hauer-Heinrich.de
 */
class JobpostRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

    /**
     * addressRepository
     *
     * @var \FriendsOfTYPO3\TtAddress\Domain\Repository\AddressRepository
     */
    protected $addressRepository = null;

    /**
     * @var array
     */
    protected $defaultOrderings = [
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    ];

    /**
     * injectAddressRepository
     *
     * @param \FriendsOfTYPO3\TtAddress\Domain\Repository\AddressRepository $addressRepository
     */
    public function injectAddressRepository(\FriendsOfTYPO3\TtAddress\Domain\Repository\AddressRepository $addressRepository): void {
        $this->addressRepository = $addressRepository;
    }

    // Class Initialization (after all dependencies have been injected) (similar to __construct)
    public function initializeObject(): void {

        /** @var \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings $querySettings */
        $querySettings = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(FALSE);
        $querySettings->setRespectSysLanguage(TRUE);
        $this->setDefaultQuerySettings($querySettings);
    }

    public function getAllJobsWithCompanys(int $jobStorage) {
        # TODO:
    }

    public function getJobWithCompany(int $jobUid) {
        # TODO:
    }

    public function getCompany(int $companyUid) {
        return $this->addressRepository->findByUid($companyUid);
    }

    public function findAllByPid(int $pid) {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_hhsimplejobposts_domain_model_jobpost')->createQueryBuilder();
        $queryBuilder
            ->select('*')
            ->from('tx_hhsimplejobposts_domain_model_jobpost')
            ->where(
                $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($pid, \PDO::PARAM_INT))
            );

        return $queryBuilder->execute()->fetchAll();
    }

    public function findAllByPids(array $pids) {
        // TODO: better implode - intExplode stuff
        // $pidList = implode(', ', $pids);
        // $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_hhsimplejobposts_domain_model_jobpost')->createQueryBuilder();
        // $queryBuilder
        //     ->select('*')
        //     ->from('tx_hhsimplejobposts_domain_model_jobpost')
        //     ->where(
        //         $queryBuilder->expr()->in('pid', $queryBuilder->createNamedParameter(
        //             GeneralUtility::intExplode(',', $pidList, true),
        //             \TYPO3\CMS\Core\Database\Connection::PARAM_INT_ARRAY
        //         ))
        //     );

        // return $queryBuilder->execute()->fetchAll();

        $query = $this->createQuery();
        $query->matching(
            $query->in('pid', $pids)
        );

        return $query->execute();
    }

    public function deleteReally(int $uid) {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_hhsimplejobposts_domain_model_jobpost');
        $queryBuilder
            ->delete('tx_hhsimplejobposts_domain_model_jobpost')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT))
            );

        return $queryBuilder->executeQuery()->fetchAllAssociative();;
    }

    function getJobArray(int $jobUid) {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_hhsimplejobposts_domain_model_jobpost');
        $queryBuilder
            ->select('*')
            ->from('tx_hhsimplejobposts_domain_model_jobpost')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($jobUid, \PDO::PARAM_INT))
            );

        return $queryBuilder->executeQuery()->fetchAssociative();
    }

    function getJobLocationsArray(string $jobLocationsUidList) {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_hhsimplejobposts_domain_model_jobpost');
        $queryBuilder
            ->select('*')
            ->from('tt_address')
            ->where(
                $queryBuilder->expr()->in('uid', $jobLocationsUidList)
            );

        return $queryBuilder->executeQuery()->fetchAllAssociative();
    }

    function getContactPointAddress(int $addressUid) {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_hhsimplejobposts_domain_model_jobpost');
        $queryBuilder
            ->select('*')
            ->from('tt_address')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($addressUid, \PDO::PARAM_INT))
            );

        return $queryBuilder->executeQuery()->fetchAssociative();
    }
}
