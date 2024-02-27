<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\Domain\Repository;

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * This file is part of the "hh_simple_job_posts" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Christian Hackl <chackl@hauer-heinrich.de>, www.Hauer-Heinrich.de
 */
final class CategoryRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

    /**
     * @var array
     */
    protected $defaultOrderings = [
        'sorting' => QueryInterface::ORDER_ASCENDING
    ];
}
