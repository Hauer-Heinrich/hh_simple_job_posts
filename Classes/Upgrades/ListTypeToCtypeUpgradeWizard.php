<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\Upgrades;

// composer req linawolf/list-type-migration
use \HauerHeinrich\HhSimpleJobPosts\Upgrades\AbstractListTypeToCTypeUpdate;
use \TYPO3\CMS\Install\Attribute\UpgradeWizard;

#[UpgradeWizard('hhSimpleJobPostsListTypeToCtypeUpgradeWizard')]
final class ListTypeToCtypeUpgradeWizard extends AbstractListTypeToCTypeUpdate {

    protected function getListTypeToCTypeMapping(): array {
        return [ // OldPlugin => new CType
            'hhsimplejobposts_jobslist' => 'hhsimplejobposts_jobslist',
            'hhsimplejobposts_jobsdetail' => 'hhsimplejobposts_jobsdetail',
        ];
    }

    public function getTitle(): string {
        return 'Migrates hh_simple_job_posts plugins';
    }

    public function getDescription(): string {
        return 'Migrates hhsimplejobposts_jobslist, hhsimplejobposts_jobsdetail  from list_type to CType. ';
    }
}
