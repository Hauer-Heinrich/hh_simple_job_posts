<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\Domain\Model;

use \TYPO3\CMS\Core\Utility\GeneralUtility;

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
     * educationRequirements
     *
     * @var string
     */
    protected $educationRequirements = '';

    /**
     * experienceRequirements
     *
     * @var string
     */
    protected $experienceRequirements = '';

    /**
     * skills
     *
     * @var string
     */
    protected $skills = '';

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
     * employmentTypeArray
     *
     * @var array
     */
    protected $employmentTypeArray = [];

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
     * jobLocation
     *
     * @var \FriendsOfTYPO3\TtAddress\Domain\Model\Address
     */
    protected $jobLocation = null;

    /**
     * baseSalaryCurrency
     *
     * @var string
     */
    protected $baseSalaryCurrency = '';

    /**
     * baseSalaryValue
     *
     * @var double
     */
    protected $baseSalaryValue;

    /**
     * baseSalaryValueMax
     *
     * @var double
     */
    protected $baseSalaryValueMax;

    /**
     * baseSalaryUnitText
     *
     * @var string
     */
    protected $baseSalaryUnitText;

    /**
     * contactPointEmail
     *
     * @var string
     */
    protected $contactPointEmail = '';

    /**
     * contactPointTelephone
     *
     * @var string
     */
    protected $contactPointTelephone = '';

    /**
     * contactPointAddress
     *
     * @var \FriendsOfTYPO3\TtAddress\Domain\Model\Address
     */
    protected $contactPointAddress = null;

    /**
     * images
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $images;

    /**
     * ogTitle
     *
     * @var string
     */
    protected $ogTitle = '';

    /**
     * ogDescription
     *
     * @var string
     */
    protected $ogDescription = '';

    /**
     * ogImage
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $ogImage;

    /**
     * twitterTitle
     *
     * @var string
     */
    protected $twitterTitle = '';

    /**
     * twitterDescription
     *
     * @var string
     */
    protected $twitterDescription = '';

    /**
     * twitterCard
     *
     * @var string
     */
    protected $twitterCard = '';

    /**
     * twitterImage
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $twitterImage;

    /**
     * Initialize categories and media relation
     */
    public function __construct()
    {
        $this->images = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->ogImage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->twitterImage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

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
     * Returns the educationRequirements
     *
     * @return string educationRequirements
     */
    public function getEducationRequirements()
    {
        return $this->educationRequirements;
    }

    /**
     * Sets the educationRequirements
     *
     * @param string $educationRequirements
     * @return void
     */
    public function setEducationRequirements($educationRequirements)
    {
        $this->educationRequirements = $educationRequirements;
    }

    /**
     * Returns the experienceRequirements
     *
     * @return string experienceRequirements
     */
    public function getExperienceRequirements()
    {
        return $this->experienceRequirements;
    }

    /**
     * Sets the experienceRequirements
     *
     * @param string $experienceRequirements
     * @return void
     */
    public function setExperienceRequirements($experienceRequirements)
    {
        $this->experienceRequirements = $experienceRequirements;
    }

    /**
     * Returns the skills
     *
     * @return string skills
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * Sets the skills
     *
     * @param string $skills
     * @return void
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;
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
     * Returns the employmentType as array
     *
     * @return array employmentType
     */
    public function getEmploymentTypeArray()
    {
        return GeneralUtility::trimExplode(',', $this->employmentType, true);
    }

    /**
     * Sets the employmentTypeArray
     *
     * @param string $employmentType
     * @return void
     */
    public function setEmploymentTypeArray($employmentType)
    {
        $this->employmentTypeArray = GeneralUtility::trimExplode(',', $employmentType, true);
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
     * Returns the jobLocation
     *
     * @return \FriendsOfTYPO3\TtAddress\Domain\Model\AdJobLocation
     */
    public function getJobLocation()
    {
        return $this->jobLocation;
    }

    /**
     * Sets the jobLocation
     *
     * @param \FriendsOfTYPO3\TtAddress\Domain\Model\Address $jobLocation
     * @return void
     */
    public function setJobLocation(\FriendsOfTYPO3\TtAddress\Domain\Model\Address $jobLocation)
    {
        $this->jobLocation = $jobLocation;
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
     * @return double baseSalaryValue
     */
    public function getBaseSalaryValue()
    {
        return number_format($this->baseSalaryValue, 2, '.', '');
    }

    /**
     * Sets the baseSalaryValue
     *
     * @param double $baseSalaryValue
     * @return void
     */
    public function setBaseSalaryValue($baseSalaryValue)
    {
        $this->baseSalaryValue = number_format($baseSalaryValue, 2, '.', '');
    }

    /**
     * Returns the baseSalaryValueMax
     *
     * @return double baseSalaryValueMax
     */
    public function getBaseSalaryValueMax()
    {
        return number_format($this->baseSalaryValueMax, 2, '.', '');
    }

    /**
     * Sets the baseSalaryValueMax
     *
     * @param double $baseSalaryValueMax
     * @return void
     */
    public function setBaseSalaryValueMax($baseSalaryValueMax)
    {
        $this->baseSalaryValueMax = number_format($baseSalaryValueMax, 2, '.', '');
    }

    /**
     * Returns the baseSalaryUnitText
     *
     * @return string baseSalaryUnitText
     */
    public function getBaseSalaryUnitText()
    {
        return $this->baseSalaryUnitText;
    }

    /**
     * Sets the baseSalaryUnitText
     *
     * @param string $baseSalaryUnitText
     * @return void
     */
    public function setBaseSalaryUnitText($baseSalaryUnitText)
    {
        $this->baseSalaryUnitText = $baseSalaryUnitText;
    }

    /**
     * Returns the contactPointEmail
     *
     * @return string contactPointEmail
     */
    public function getContactPointEmail()
    {
        return $this->contactPointEmail;
    }

    /**
     * Sets the contactPointEmail
     *
     * @param string $contactPointEmail
     * @return void
     */
    public function setContactPointEmail($contactPointEmail)
    {
        $this->contactPointEmail = $contactPointEmail;
    }

    /**
     * Returns the contactPointTelephone
     *
     * @return string contactPointTelephone
     */
    public function getContactPointTelephone()
    {
        return $this->contactPointTelephone;
    }

    /**
     * Sets the contactPointTelephone
     *
     * @param string $contactPointTelephone
     * @return void
     */
    public function setContactPointTelephone($contactPointTelephone)
    {
        $this->contactPointTelephone = $contactPointTelephone;
    }

    /**
     * Returns the contactPointAddress
     *
     * @return \FriendsOfTYPO3\TtAddress\Domain\Model\Address $contactPointAddress
     */
    public function getContactPointAddress()
    {
        return $this->contactPointAddress;
    }

    /**
     * Sets the contactPointAddress
     *
     * @param \FriendsOfTYPO3\TtAddress\Domain\Model\Address $contactPointAddress
     * @return void
     */
    public function setContactPointAddress(\FriendsOfTYPO3\TtAddress\Domain\Model\Address $contactPointAddress)
    {
        $this->contactPointAddress = $contactPointAddress;
    }

    /**
     * Returns the images
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Sets the images
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $images
     * @return void
     */
    public function setImages(\TYPO3\CMS\Extbase\Domain\Model\FileReference $images)
    {
        $this->images = $images;
    }

    /**
     * Adds a Images
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $images
     * @return void
     */
    public function addImages(\TYPO3\CMS\Extbase\Domain\Model\FileReference $images) {
        $this->images->attach($images);
    }

    /**
     * Removes a Images
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $imagesFileToRemove The Images to be removed
     * @return void
     */
    public function removeImages(\TYPO3\CMS\Extbase\Domain\Model\FileReference $imagesFileToRemove) {
        $this->images->detach($imagesFileToRemove);
    }

    /**
     * Returns the ogTitle
     *
     * @return string ogTitle
     */
    public function getOgTitle()
    {
        return $this->ogTitle;
    }

    /**
     * Sets the ogTitle
     *
     * @param string $ogTitle
     * @return void
     */
    public function setOgTitle($ogTitle)
    {
        $this->ogTitle = $ogTitle;
    }

    /**
     * Returns the ogDescription
     *
     * @return string ogDescription
     */
    public function getOgDescription()
    {
        return $this->ogDescription;
    }

    /**
     * Sets the ogDescription
     *
     * @param string $ogDescription
     * @return void
     */
    public function setOgDescription($ogDescription)
    {
        $this->ogDescription = $ogDescription;
    }

    /**
     * Returns the ogImage
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $ogImage
     */
    public function getOgImage()
    {
        return $this->ogImage;
    }

    /**
     * Sets the ogImage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $ogImage
     * @return void
     */
    public function setOgImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $ogImage)
    {
        $this->ogImage = $ogImage;
    }

    /**
     * Adds a ogImage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $ogImage
     * @return void
     */
    public function addOgImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $ogImage) {
        $this->ogImage->attach($ogImage);
    }

    /**
     * Removes a ogImage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $imagesFileToRemove The ogImage to be removed
     * @return void
     */
    public function removeOgImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $imagesFileToRemove) {
        $this->ogImage->detach($imagesFileToRemove);
    }

    /**
     * Returns the twitterTitle
     *
     * @return string twitterTitle
     */
    public function getTwitterTitle()
    {
        return $this->twitterTitle;
    }

    /**
     * Sets the twitterTitle
     *
     * @param string $twitterTitle
     * @return void
     */
    public function setTwitterTitle($twitterTitle)
    {
        $this->twitterTitle = $twitterTitle;
    }

    /**
     * Returns the twitterDescription
     *
     * @return string twitterDescription
     */
    public function getTwitterDescription()
    {
        return $this->twitterDescription;
    }

    /**
     * Sets the twitterDescription
     *
     * @param string $twitterDescription
     * @return void
     */
    public function setTwitterDescription($twitterDescription)
    {
        $this->twitterDescription = $twitterDescription;
    }

    /**
     * Returns the twitterCard
     *
     * @return string twitterCard
     */
    public function getTwitterCard()
    {
        return $this->twitterCard;
    }

    /**
     * Sets the twitterCard
     *
     * @param string $twitterCard
     * @return void
     */
    public function setTwitterCard($twitterCard)
    {
        $this->twitterCard = $twitterCard;
    }

    /**
     * Returns the twitterImage
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $twitterImage
     */
    public function getTwitterImage()
    {
        return $this->twitterImage;
    }

    /**
     * Sets the twitterImage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $twitterImage
     * @return void
     */
    public function setTwitterImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $twitterImage)
    {
        $this->twitterImage = $twitterImage;
    }

    /**
     * Adds a twitterImage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $twitterImage
     * @return void
     */
    public function addTwitterImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $twitterImage) {
        $this->twitterImage->attach($twitterImage);
    }

    /**
     * Removes a twitterImage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $imagesFileToRemove The twitterImage to be removed
     * @return void
     */
    public function removeTwitterImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $imagesFileToRemove) {
        $this->twitterImage->detach($imagesFileToRemove);
    }
}
