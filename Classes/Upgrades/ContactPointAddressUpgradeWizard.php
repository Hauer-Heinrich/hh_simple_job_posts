<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\Upgrades;

use \Symfony\Component\Console\Output\OutputInterface;
// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Install\Attribute\UpgradeWizard;
use \TYPO3\CMS\Install\Updates\UpgradeWizardInterface;
use \TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use \TYPO3\CMS\Install\Updates\ChattyInterface;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Database\ConnectionPool;

#[UpgradeWizard('hhSimpleJobPosts_contactPointAddressUpgradeWizard')]
final class ContactPointAddressUpgradeWizard implements UpgradeWizardInterface, ChattyInterface {

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * Setter injection for output into upgrade wizards
     */
    public function setOutput(OutputInterface $output): void {
        $this->output = $output;
    }

    /**
     * Return the speaking name of this wizard
     */
    public function getTitle(): string {
        return 'EXT:hh_simple_job_posts - move contact_point_address';
    }

    /**
     * Return the description for this wizard
     */
    public function getDescription(): string {
        return 'Move DB field "contact_point_address" to field "contact_point_addresses". Don\'t forget to update your Database afterwards.';
    }

    /**
     * Execute the update
     *
     * Called when a wizard reports that an update is necessary
     */
    public function executeUpdate(): bool {
        $affectedJobs = $this->getAffectedJobs();

        if(empty($affectedJobs)) {
            return true;
        }

        $this->output->writeln('Performing ' . count($affectedJobs) . ' database operations.');

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_hhsimplejobposts_domain_model_jobpost');

        foreach ($affectedJobs as $job) {
            $queryBuilder->update('tx_hhsimplejobposts_domain_model_jobpost', 'jobpost');
            $queryBuilder->where(
                $queryBuilder->expr()->eq('jobpost.uid', $job['uid'])
            );
            $queryBuilder->set('jobpost.contact_point_addresses', $job['contact_point_address']);
            $queryBuilder->executeStatement();
        }

        return true;
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
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_hhsimplejobposts_domain_model_jobpost');
        $whereExpressions = [];

        $whereExpressions[] = $queryBuilder->expr()->gt('contact_point_address', 0);
        $whereExpressions[] = $queryBuilder->expr()->eq('contact_point_addresses', $queryBuilder->createNamedParameter(''));

        $queryBuilder
            ->select('uid', 'contact_point_address')
            ->from('tx_hhsimplejobposts_domain_model_jobpost');
        $queryBuilder->where(...$whereExpressions);
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

    protected function getAffectedJobs(): array {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_hhsimplejobposts_domain_model_jobpost');
        $whereExpressions = [];

        $whereExpressions[] = $queryBuilder->expr()->gt('contact_point_address', 0);
        $whereExpressions[] = $queryBuilder->expr()->eq('contact_point_addresses', $queryBuilder->createNamedParameter(''));

        $queryBuilder
            ->select('uid', 'contact_point_address')
            ->from('tx_hhsimplejobposts_domain_model_jobpost');
        $queryBuilder->where(...$whereExpressions);
        $results = $queryBuilder->executeQuery()->fetchAllAssociative();

        if(!empty($results) && \is_array($results)) {
            return $results;
        }

        return [];
    }
}
