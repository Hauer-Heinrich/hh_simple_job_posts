<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\Domain\Model;

/**
 * This file is part of the "hh_simple_job_posts" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Christian Hackl <chackl@hauer-heinrich.de>, www.Hauer-Heinrich.de
 */
class Address extends \FriendsOfTYPO3\TtAddress\Domain\Model\Address {

    protected string $extbaseType = '';

    public function getExtbaseType(): string {
        return $this->extbaseType;
    }

    public function setTxExtbaseType(string $extbaseType): void {
        $this->extbaseType = $extbaseType;
    }
}
