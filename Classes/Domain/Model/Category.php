<?php
declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace HauerHeinrich\HhSimpleJobPosts\Domain\Model;

use \TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;

class Category extends AbstractEntity {

    protected string $title = '';
    protected string $description = '';
    protected $parent;
    protected array $records;

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function getParent() {
        if ($this->parent instanceof LazyLoadingProxy) {
            $this->parent->_loadRealInstance();
        }
        return $this->parent;
    }

    public function setParent(\HauerHeinrich\HhSimpleJobPosts\Domain\Model\Category $parent) {
        $this->parent = $parent;
    }

    public function getRecords(): array {
        return $this->records;
    }

    public function setRecords(array $records) {
        $this->records = $records;
    }
}
