<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\Domain\Model;


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
 * This file is part of the "Job offers - simple" Extension for TYPO3 CMS.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 * (c) 2021 Christian Hackl <chackl@hauer-heinrich.de>, www.Hauer-Heinrich.de
 * Joboffer
 */
class Jobpost extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * @var \DateTime
     */
    protected $crdate;

    /**
     * @var \DateTime
     */
    protected $tstamp;

    /**
     * @var \DateTime
     */
    protected $starttime;

    /**
     * @var \DateTime
     */
    protected $endtime;

    /**
     * slug
     * @var string
     */
    protected $slug;

    /**
     * title
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $title = '';

    /**
     * description
     *
     * @var string
     */
    protected $description = '';

    /**
     * maintasks
     *
     * @var string
     */
    protected $maintasks = '';

    /**
     * profile
     *
     * @var string
     */
    protected $profile = '';

    /**
     * weprovide
     *
     * @var string
     */
    protected $weprovide = '';

    /**
     * others
     *
     * @var string
     */
    protected $others = '';

    /**
     * employmentType
     *
     * @var string
     */
    protected $employmentType = '';

    /**
     * workHours
     *
     * @var string
     */
    protected $workHours = '';

    /**
     * hiringOrganization
     *
     * @var \FriendsOfTYPO3\TtAddress\Domain\Model\Address
     */
    protected $hiringOrganization = null;

    /**
     * baseSalaryCurrency
     *
     * @var string
     */
    protected $baseSalaryCurrency = '';

    /**
     * baseSalaryValue
     *
     * @var int
     */
    protected $baseSalaryValue;

    /**
     * Get creation date
     *
     * @return \DateTime
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * Set creation date
     *
     * @param \DateTime $crdate
     * @return void
     */
    public function setCrdate($crdate)
    {
        $this->crdate = $crdate;
    }

    /**
     * Get year of crdate
     *
     * @return string
     */
    public function getYearOfCrdate()
    {
        return $this->getCrdate()->format('Y');
    }

    /**
     * Get month of crdate
     *
     * @return string
     */
    public function getMonthOfCrdate()
    {
        return $this->getCrdate()->format('m');
    }

    /**
     * Get day of crdate
     *
     * @return int
     */
    public function getDayOfCrdate()
    {
        return (int)$this->crdate->format('d');
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }

    /**
     * Set time stamp
     *
     * @param \DateTime $tstamp time stamp
     * @return void
     */
    public function setTstamp($tstamp)
    {
        $this->tstamp = $tstamp;
    }

    /**
     * Get starttime
     *
     * @return \DateTime
     */
    public function getStarttime()
    {
        return $this->starttime;
    }

    /**
     * Set starttime
     *
     * @param \DateTime $starttime
     * @return void
     */
    public function setStarttime($starttime)
    {
        $this->starttime = $starttime;
    }

    /**
     * Get endtime
     *
     * @return \DateTime
     */
    public function getEndtime()
    {
        return $this->endtime;
    }

    /**
     * Set endtime
     *
     * @param \DateTime $endtime
     * @return void
     */
    public function setEndtime($endtime)
    {
        $this->endtime = $endtime;
    }

    /**
     * sets the slug attribute
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * returns the slug attribute
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Returns the title
     *
     * @return string title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the description
     *
     * @return string description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the maintasks
     *
     * @return string maintasks
     */
    public function getMaintasks()
    {
        return $this->maintasks;
    }

    /**
     * Sets the maintasks
     *
     * @param string $maintasks
     * @return void
     */
    public function setMaintasks($maintasks)
    {
        $this->maintasks = $maintasks;
    }

    /**
     * Returns the profile
     *
     * @return string profile
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Sets the profile
     *
     * @param string $profile
     * @return void
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
    }

    /**
     * Returns the weprovide
     *
     * @return string weprovide
     */
    public function getWeprovide()
    {
        return $this->weprovide;
    }

    /**
     * Sets the weprovide
     *
     * @param string $weprovide
     * @return void
     */
    public function setWeprovide($weprovide)
    {
        $this->weprovide = $weprovide;
    }

    /**
     * Returns the others
     *
     * @return string others
     */
    public function getOthers()
    {
        return $this->others;
    }

    /**
     * Sets the others
     *
     * @param string $others
     * @return void
     */
    public function setOthers($others)
    {
        $this->others = $others;
    }

    /**
     * Returns the employmentType
     *
     * @return string employmentType
     */
    public function getEmploymentType()
    {
        return $this->employmentType;
    }

    /**
     * Sets the employmentType
     *
     * @param string $employmentType
     * @return void
     */
    public function setEmploymentType($employmentType)
    {
        $this->employmentType = $employmentType;
    }

    /**
     * Returns the workHours
     *
     * @return string workHours
     */
    public function getWorkHours()
    {
        return $this->workHours;
    }

    /**
     * Sets the workHours
     *
     * @param string $workHours
     * @return void
     */
    public function setWorkHours($workHours)
    {
        $this->workHours = $workHours;
    }

    /**
     * Returns the hiringOrganization
     *
     * @return \FriendsOfTYPO3\TtAddress\Domain\Model\Address $hiringOrganization
     */
    public function getHiringOrganization()
    {
        return $this->hiringOrganization;
    }

    /**
     * Sets the hiringOrganization
     *
     * @param \FriendsOfTYPO3\TtAddress\Domain\Model\Address $hiringOrganization
     * @return void
     */
    public function setHiringOrganization(\FriendsOfTYPO3\TtAddress\Domain\Model\Address $hiringOrganization)
    {
        $this->hiringOrganization = $hiringOrganization;
    }


    /**
     * Returns the baseSalaryCurrency
     *
     * @return string baseSalaryCurrency
     */
    public function getBaseSalaryCurrency()
    {
        return $this->baseSalaryCurrency;
    }

    /**
     * Sets the baseSalaryCurrency
     *
     * @param string $baseSalaryCurrency
     * @return void
     */
    public function setBaseSalaryCurrency($baseSalaryCurrency)
    {
        $this->baseSalaryCurrency = $baseSalaryCurrency;
    }

    /**
     * Returns the baseSalaryValue
     *
     * @return int baseSalaryValue
     */
    public function getBaseSalaryValue()
    {
        return $this->baseSalaryValue;
    }

    /**
     * Sets the baseSalaryValue
     *
     * @param int $baseSalaryValue
     * @return void
     */
    public function setBaseSalaryValue($baseSalaryValue)
    {
        $this->baseSalaryValue = $baseSalaryValue;
    }
}
