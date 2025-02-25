<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\Domain\Repository;

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Database\ConnectionPool;
use \TYPO3\CMS\Extbase\Persistence\QueryInterface;
use \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;

/**
 * This file is part of the "hh_simple_job_posts" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Christian Hackl <chackl@hauer-heinrich.de>, www.Hauer-Heinrich.de
 */
final class JobpostRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

    /**
     * addressRepository
     *
     * @var \FriendsOfTYPO3\TtAddress\Domain\Repository\AddressRepository
     */
    protected $addressRepository = null;

    /**
     * categoryRepository
     *
     * @var \HauerHeinrich\HhSimpleJobPosts\Domain\Repository\CategoryRepository
     */
    protected $categoryRepository = null;

    /**
     * @var array
     */
    protected $defaultOrderings = [
        'sorting' => QueryInterface::ORDER_ASCENDING
    ];

    /**
     * injectAddressRepository
     *
     * @param \FriendsOfTYPO3\TtAddress\Domain\Repository\AddressRepository $addressRepository
     */
    public function injectAddressRepository(\FriendsOfTYPO3\TtAddress\Domain\Repository\AddressRepository $addressRepository): void {
        $this->addressRepository = $addressRepository;
    }

    /**
     * injectCategoryRepository
     *
     * @param \HauerHeinrich\HhSimpleJobPosts\Domain\Repository\CategoryRepository $categoryRepository
     */
    public function injectCategoryRepository(\HauerHeinrich\HhSimpleJobPosts\Domain\Repository\CategoryRepository $categoryRepository): void {
        $this->categoryRepository = $categoryRepository;
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

    public function findAllByPid(int $pid): array {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_hhsimplejobposts_domain_model_jobpost')->createQueryBuilder();
        $queryBuilder
            ->select('*')
            ->from('tx_hhsimplejobposts_domain_model_jobpost')
            ->where(
                $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($pid, \PDO::PARAM_INT))
            );

        return $queryBuilder->executeQuery()->fetchAllAssociative();
    }

    public function findAllByPids(array $pids): QueryResult {
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

    public function findAllByUids(array $singleJobsUidsArray, string $sortBy = 'uid', string $sortOrder = 'ASC'): array {
        $query = $this->createQuery();
        if(!empty($singleJobsUidsArray) && $sortBy === 'singleSelection') {
            $result = [];
            foreach ($singleJobsUidsArray as $uid) {
                $item = $this->findByIdentifier($uid);
                if ($item) {
                    $result[] = $item;
                }
            }

            // $queryParser = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser::class);
            // DebuggerUtility::var_dump($queryParser->convertQueryToDoctrineQueryBuilder($query)->getSQL());

            return $result;
        }

        $query->matching(
            $query->in('uid', $singleJobsUidsArray)
        );

        if($sortOrder === 'ASC') {
            $query->setOrderings([$sortBy => QueryInterface::ORDER_ASCENDING]);
        }
        if($sortOrder === 'DESC') {
            $query->setOrderings([$sortBy => QueryInterface::ORDER_DESCENDING]);
        }

        return $query->execute()->toArray();
    }

    public function findByCategories(array $categories, string $categoryCombination = 'AND', string $sortBy = 'uid', string $sortOrder = 'ASC'): array {
        $result = [];
        $constraints = [];
        $query = $this->createQuery();

        if(!empty($categories)) {
            switch ($categoryCombination) {
                case 'OR':
                    foreach ($categories as $categoryUid) {
                        $query->matching(
                            $query->contains('categories', $categoryUid)
                        );

                        if($sortOrder === 'ASC') {
                            $query->setOrderings([$sortBy => QueryInterface::ORDER_ASCENDING]);
                        }
                        if($sortOrder === 'DESC') {
                            $query->setOrderings([$sortBy => QueryInterface::ORDER_DESCENDING]);
                        }

                        if($sortBy === 'categories') {
                            $category = $this->categoryRepository->findByUid($categoryUid);
                            $category->setRecords($query->execute()->toArray());
                            $sortedByCategory[$categoryUid] = $category;
                        } else {
                            $jobsFromCategory = $query->execute()->toArray();
                            foreach ($jobsFromCategory as $value) {
                                $jobsByCategory[] = $value;
                            }
                        }
                    }

                    // summarized by category
                    // returns e.g. [categoryUid => [category..., records => [job1, job2, ...] ], ...]
                    if($sortBy === 'categories') {
                        return $sortedByCategory;
                    }

                    // not summarized by category
                    // returns e.g. [0 => job1, 1 => job2 ...]
                    $sortByMethod = 'get'.ucfirst($sortBy);
                    if($sortOrder === 'ASC') {
                        usort($jobsByCategory, fn($a, $b) => $a->{$sortByMethod}() <=> $b->{$sortByMethod}());
                    }
                    if($sortOrder === 'DESC') {
                        usort($jobsByCategory, fn($a, $b) => $b->{$sortByMethod}() <=> $a->{$sortByMethod}());
                    }

                    return $jobsByCategory;
                    break;

                case 'NOTOR':
                    foreach ($categories as $categoryUid) {
                        $query->matching(
                            $query->logicalNot(
                                $query->contains('categories', $categoryUid)
                            )
                        );

                        if($sortOrder === 'ASC') {
                            $query->setOrderings([$sortBy => QueryInterface::ORDER_ASCENDING]);
                        }
                        if($sortOrder === 'DESC') {
                            $query->setOrderings([$sortBy => QueryInterface::ORDER_DESCENDING]);
                        }

                        if($sortBy === 'categories') {
                            $category = $this->categoryRepository->findByUid($categoryUid);
                            $category->setRecords($query->execute()->toArray());
                            $sortedByCategory[$categoryUid] = $category;
                        } else {
                            $jobsFromCategory = $query->execute()->toArray();
                            foreach ($jobsFromCategory as $value) {
                                $jobsByCategory[] = $value;
                            }
                        }
                    }

                    // summarized by category
                    // returns e.g. [categoryUid => [category..., records => [job1, job2, ...] ], ...]
                    if($sortBy === 'categories') {
                        return $sortedByCategory;
                    }

                    // not summarized by category
                    // returns e.g. [0 => job1, 1 => job2 ...]
                    $sortByMethod = 'get'.ucfirst($sortBy);
                    if($sortOrder === 'ASC') {
                        usort($jobsByCategory, fn($a, $b) => $a->{$sortByMethod}() <=> $b->{$sortByMethod}());
                    }
                    if($sortOrder === 'DESC') {
                        usort($jobsByCategory, fn($a, $b) => $b->{$sortByMethod}() <=> $a->{$sortByMethod}());
                    }

                    return $jobsByCategory;
                    break;

                case 'NOTAND':
                    foreach ($categories as $categoryUid) {
                        $constraints[] = $query->contains('categories', $categoryUid);
                    }
                    $query->matching(
                        $query->logicalNot(...$constraints)
                    );

                    if($sortOrder === 'ASC') {
                        $query->setOrderings([$sortBy => QueryInterface::ORDER_ASCENDING]);
                    }
                    if($sortOrder === 'DESC') {
                        $query->setOrderings([$sortBy => QueryInterface::ORDER_DESCENDING]);
                    }

                    $result = $query->execute()->toArray();
                    break;

                default:
                    foreach ($categories as $categoryUid) {
                        $constraints[] = $query->contains('categories', $categoryUid);
                    }
                    $query->matching(
                        $query->logicalAnd(...$constraints)
                    );

                    if($sortOrder === 'ASC') {
                        $query->setOrderings([$sortBy => QueryInterface::ORDER_ASCENDING]);
                    }
                    if($sortOrder === 'DESC') {
                        $query->setOrderings([$sortBy => QueryInterface::ORDER_DESCENDING]);
                    }

                    $result = $query->execute()->toArray();
                    break;
            }
        }

        return $result;
    }

    public function deleteReally(int $uid) {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_hhsimplejobposts_domain_model_jobpost');
        $queryBuilder
            ->delete('tx_hhsimplejobposts_domain_model_jobpost')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT))
            );

        return $queryBuilder->executeStatement();
    }

    public function getJobArray(int $jobUid): array {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_hhsimplejobposts_domain_model_jobpost');
        $queryBuilder
            ->select('*')
            ->from('tx_hhsimplejobposts_domain_model_jobpost')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($jobUid, \PDO::PARAM_INT))
            );

        $result = $queryBuilder->executeQuery()->fetchAssociative();
        if(is_array($result)) {
            return $result;
        }

        return [];
    }

    public function getJobLocationsArray(string $jobLocationsUidList): array {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_hhsimplejobposts_domain_model_jobpost');
        $queryBuilder
            ->select('*')
            ->from('tt_address')
            ->where(
                $queryBuilder->expr()->in('uid', $jobLocationsUidList)
            );

        return $queryBuilder->executeQuery()->fetchAllAssociative();
    }

    public function getContactPointAddress(int $addressUid): array {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_hhsimplejobposts_domain_model_jobpost');
        $queryBuilder
            ->select('*')
            ->from('tt_address')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($addressUid, \PDO::PARAM_INT))
            );

        $result = $queryBuilder->executeQuery()->fetchAssociative();
        if(is_array($result)) {
            return $result;
        }

        return [];
    }
}
