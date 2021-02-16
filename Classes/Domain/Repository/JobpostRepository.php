<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\Domain\Repository;

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser;

/**
 *
 * This file is part of the "Job posts - simple" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Christian Hackl <chackl@hauer-heinrich.de>, www.Hauer-Heinrich.de
 */

/**
 * This file is part of the "Job posts - simple" Extension for TYPO3 CMS.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 * (c) 2021 Christian Hackl <chackl@hauer-heinrich.de>, www.Hauer-Heinrich.de
 * This file is part of the "Job offers - simple" Extension for TYPO3 CMS.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 * (c) 2021 Christian Hackl <chackl@hauer-heinrich.de>, www.Hauer-Heinrich.de
 * The repository for Jobposts
 */
class JobpostRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    protected $query;
    protected $queryParser;
    protected $queryConstraint;

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
        // Initialize QueryParser (Typo3DbQueryParser)
        $this->queryParser = $this->objectManager->get(Typo3DbQueryParser::class);

        /** @var \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings $querySettings */
        $querySettings = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(FALSE);
        $querySettings->setRespectSysLanguage(TRUE);
        $this->setDefaultQuerySettings($querySettings);

        // Initialize Query
        $this->query = $this->createQuery();
    }

    public function getAllJobsWithCompanys(int $jobStorage)
    {
        # code...
    }

    public function getJobWithCompany(int $jobUid)
    {
        # code...
    }

    public function getCompany(int $companyUid) {
        return $this->addressRepository->findByUid($companyUid);
    }
}
