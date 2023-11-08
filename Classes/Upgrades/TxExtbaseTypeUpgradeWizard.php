<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\Upgrades;

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Install\Attribute\UpgradeWizard;
use \TYPO3\CMS\Install\Updates\UpgradeWizardInterface;
use \TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Database\ConnectionPool;

#[UpgradeWizard('hhSimpleJobPosts_txExtbaseTypeUpgradeWizard')]
final class TxExtbaseTypeUpgradeWizard implements UpgradeWizardInterface {
    /**
     * Return the speaking name of this wizard
     */
    public function getTitle(): string {
        return 'EXT:hh_simple_job_posts - change tx_extbase_type value';
    }

    /**
     * Return the description for this wizard
     */
    public function getDescription(): string {
        return 'Change value of DB field "tx_extbase_type" from "ttAddress_location" to "place".';
    }

    /**
     * Execute the update
     *
     * Called when a wizard reports that an update is necessary
     */
    public function executeUpdate(): bool {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_address');
        $whereExpressions = [];

        $whereExpressions[] = $queryBuilder->expr()->eq('tx_extbase_type', $queryBuilder->createNamedParameter('ttAddress_location'));

        $queryBuilder->update('tt_address');
        $queryBuilder->where(...$whereExpressions);
        $queryBuilder->set('tx_extbase_type', 'place');
        $results = $queryBuilder->executeStatement();

        if(\is_int($results) && $results > 0) {
            return true;
        }

        return false;
    }

    /**
     * Is an update necessary?
     *
     * Is used to determine whether a wizard needs to be run.
     * Check if data for migration exists.
     *
     * @return bool Whether an update is required (TRUE) or not (FALSE)
     */
    public function updateNecessary(): bool {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_address');
        $whereExpressions = [];

        $whereExpressions[] = $queryBuilder->expr()->eq('tx_extbase_type', $queryBuilder->createNamedParameter('ttAddress_location'));

        $queryBuilder
            ->select('uid', 'tx_extbase_type')
            ->from('tt_address')
            ->where(...$whereExpressions);
        $results = $queryBuilder->executeQuery()->fetchAllAssociative();

        if(!empty($results)) {
            return true;
        }

        return false;
    }

    /**
     * Returns an array of class names of prerequisite classes
     *
     * This way a wizard can define dependencies like "database up-to-date" or
     * "reference index updated"
     *
     * @return string[]
     */
    public function getPrerequisites(): array {
        // Add your logic here

        return [
            DatabaseUpdatedPrerequisite::class,
        ];
    }
}
