<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\Domain\Model;

use \TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This file is part of the "hh_simple_job_posts" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Christian Hackl <chackl@hauer-heinrich.de>, www.Hauer-Heinrich.de
 */
class Jobpost extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * @var int
     */
    protected $apiUid;

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
     * shortDescription
     *
     * @var string
     */
    protected $shortDescription = '';

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
     * jobLocations
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FriendsOfTYPO3\TtAddress\Domain\Model\Address>
     */
    protected $jobLocations = null;

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
     * downloads
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $downloads;

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
     * applicationForm
     *
     * @var string url
     */
    protected $applicationForm = '';

    /**
     * Initialize categories and media relation
     */
    public function __construct() {
        $this->images = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->downloads = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->ogImage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->twitterImage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->jobLocations = $this->jobLocations ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Get apiUid
     *
     * @return int
     */
    public function getApiUid(): int {
        return $this->apiUid;
    }

    /**
     * set apiUid
     *
     * @param int
     * @return void
     */
    public function setApiUid(int $apiUid): void {
        $this->apiUid = $apiUid;
    }

    /**
     * Get creation date
     *
     * @return \DateTime
     */
    public function getCrdate(): \DateTime {
        return $this->crdate;
    }

    /**
     * Set creation date
     *
     * @param \DateTime $crdate
     * @return void
     */
    public function setCrdate(\DateTime $crdate): void {
        $this->crdate = $crdate;
    }

    /**
     * Get year of crdate
     *
     * @return string
     */
    public function getYearOfCrdate(): string {
        return $this->getCrdate()->format('Y');
    }

    /**
     * Get month of crdate
     *
     * @return string
     */
    public function getMonthOfCrdate(): string {
        return $this->getCrdate()->format('m');
    }

    /**
     * Get day of crdate
     *
     * @return int
     */
    public function getDayOfCrdate(): int {
        return (int)$this->crdate->format('d');
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTstamp() {
        return $this->tstamp;
    }

    /**
     * Set time stamp
     *
     * @param \DateTime $tstamp time stamp
     * @return void
     */
    public function setTstamp($tstamp): void {
        $this->tstamp = $tstamp;
    }

    /**
     * Get starttime
     *
     * @return \DateTime
     */
    public function getStarttime() {
        return $this->starttime;
    }

    /**
     * Set starttime
     *
     * @param \DateTime $starttime
     * @return void
     */
    public function setStarttime($starttime) {
        $this->starttime = $starttime;
    }

    /**
     * Get endtime
     *
     * @return \DateTime
     */
    public function getEndtime() {
        return $this->endtime;
    }

    /**
     * Set endtime
     *
     * @param \DateTime $endtime
     * @return void
     */
    public function setEndtime($endtime) {
        $this->endtime = $endtime;
    }

    /**
     * sets the slug attribute
     *
     * @param string $slug
     */
    public function setSlug(string $slug): void {
        $this->slug = $slug;
    }

    /**
     * returns the slug attribute
     *
     * @return string
     */
    public function getSlug(): string {
        return $this->slug;
    }

    /**
     * Returns the title
     *
     * @return string title
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    /**
     * Returns the shortDescription
     *
     * @return string shortDescription
     */
    public function getShortDescription(): string {
        return $this->shortDescription;
    }

    /**
     * Sets the shortDescription
     *
     * @param string $shortDescription
     * @return void
     */
    public function setShortDescription(string $shortDescription): void {
        $this->shortDescription = $shortDescription;
    }

    /**
     * Returns the description
     *
     * @return string description
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void {
        $this->description = $description;
    }

    /**
     * Returns the maintasks
     *
     * @return string maintasks
     */
    public function getMaintasks(): string {
        return $this->maintasks;
    }

    /**
     * Sets the maintasks
     *
     * @param string $maintasks
     * @return void
     */
    public function setMaintasks(string $maintasks): void {
        $this->maintasks = $maintasks;
    }

    /**
     * Returns the profile
     *
     * @return string profile
     */
    public function getProfile(): string {
        return $this->profile;
    }

    /**
     * Sets the profile
     *
     * @param string $profile
     * @return void
     */
    public function setProfile(string $profile): void {
        $this->profile = $profile;
    }

    /**
     * Returns the educationRequirements
     *
     * @return string educationRequirements
     */
    public function getEducationRequirements(): string {
        return $this->educationRequirements;
    }

    /**
     * Sets the educationRequirements
     *
     * @param string $educationRequirements
     * @return void
     */
    public function setEducationRequirements(string $educationRequirements): void {
        $this->educationRequirements = $educationRequirements;
    }

    /**
     * Returns the experienceRequirements
     *
     * @return string experienceRequirements
     */
    public function getExperienceRequirements(): string {
        return $this->experienceRequirements;
    }

    /**
     * Sets the experienceRequirements
     *
     * @param string $experienceRequirements
     * @return void
     */
    public function setExperienceRequirements(string $experienceRequirements): void {
        $this->experienceRequirements = $experienceRequirements;
    }

    /**
     * Returns the skills
     *
     * @return string skills
     */
    public function getSkills(): string {
        return $this->skills;
    }

    /**
     * Sets the skills
     *
     * @param string $skills
     * @return void
     */
    public function setSkills(string $skills): void {
        $this->skills = $skills;
    }

    /**
     * Returns the weprovide
     *
     * @return string weprovide
     */
    public function getWeprovide(): string {
        return $this->weprovide;
    }

    /**
     * Sets the weprovide
     *
     * @param string $weprovide
     * @return void
     */
    public function setWeprovide(string $weprovide): void {
        $this->weprovide = $weprovide;
    }

    /**
     * Returns the others
     *
     * @return string others
     */
    public function getOthers(): string {
        return $this->others;
    }

    /**
     * Sets the others
     *
     * @param string $others
     * @return void
     */
    public function setOthers(string $others): void {
        $this->others = $others;
    }

    /**
     * Returns the employmentType
     *
     * @return string employmentType
     */
    public function getEmploymentType(): string {
        return $this->employmentType;
    }

    /**
     * Sets the employmentType
     *
     * @param string $employmentType
     * @return void
     */
    public function setEmploymentType(string $employmentType): void {
        $this->employmentType = $employmentType;
    }

    /**
     * Returns the employmentType as array
     *
     * @return array employmentType
     */
    public function getEmploymentTypeArray(): array {
        return GeneralUtility::trimExplode(',', $this->employmentType, true);
    }

    /**
     * Sets the employmentTypeArray
     *
     * @param string $employmentType
     * @return void
     */
    public function setEmploymentTypeArray(string $employmentType): void {
        $this->employmentTypeArray = GeneralUtility::trimExplode(',', $employmentType, true);
    }

    /**
     * Returns the workHours
     *
     * @return string workHours
     */
    public function getWorkHours(): string {
        return $this->workHours;
    }

    /**
     * Sets the workHours
     *
     * @param string $workHours
     * @return void
     */
    public function setWorkHours(string $workHours): void {
        $this->workHours = $workHours;
    }

    /**
     * Returns the hiringOrganization
     *
     * @return \FriendsOfTYPO3\TtAddress\Domain\Model\Address $hiringOrganization
     */
    public function getHiringOrganization(): ?\FriendsOfTYPO3\TtAddress\Domain\Model\Address {
        return $this->hiringOrganization;
    }

    /**
     * Sets the hiringOrganization
     *
     * @param \FriendsOfTYPO3\TtAddress\Domain\Model\Address $hiringOrganization
     * @return void
     */
    public function setHiringOrganization(\FriendsOfTYPO3\TtAddress\Domain\Model\Address $hiringOrganization): void {
        $this->hiringOrganization = $hiringOrganization;
    }

    /**
     * Returns the jobLocation
     *
     * @return \FriendsOfTYPO3\TtAddress\Domain\Model\Address
     */
    public function getJobLocation(): ?\FriendsOfTYPO3\TtAddress\Domain\Model\Address {
        return $this->jobLocation;
    }

    /**
     * Sets the jobLocation
     *
     * @param \FriendsOfTYPO3\TtAddress\Domain\Model\Address $jobLocation
     * @return void
     */
    public function setJobLocation(\FriendsOfTYPO3\TtAddress\Domain\Model\Address $jobLocation): void {
        $this->jobLocation = $jobLocation;
    }

    /**
     * Adds a Address
     *
     * @param \FriendsOfTYPO3\TtAddress\Domain\Model\Address $jobLocation
     * @return void
     */
    public function addJobLocation(\FriendsOfTYPO3\TtAddress\Domain\Model\Address $jobLocation): void {
        $this->jobLocations->attach($jobLocation);
    }

    /**
     * Removes a Address
     *
     * @param \FriendsOfTYPO3\TtAddress\Domain\Model\Address $jobLocationToRemove The Address to be removed
     * @return void
     */
    public function removeJobLocation(\FriendsOfTYPO3\TtAddress\Domain\Model\Address $jobLocationToRemove): void {
        $this->jobLocations->detach($jobLocationToRemove);
    }

    /**
     * Returns the jobLocations
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FriendsOfTYPO3\TtAddress\Domain\Model\Address>
     */
    public function getJobLocations(): \TYPO3\CMS\Extbase\Persistence\ObjectStorage {
        return $this->jobLocations;
    }

    /**
     * Sets the jobLocations
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FriendsOfTYPO3\TtAddress\Domain\Model\Address> $jobLocations
     * @return void
     */
    public function setJobLocations(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $jobLocations): void {
        $this->jobLocations = $jobLocations;
    }

    /**
     * Returns the baseSalaryCurrency
     *
     * @return string baseSalaryCurrency
     */
    public function getBaseSalaryCurrency(): string {
        return $this->baseSalaryCurrency;
    }

    /**
     * Sets the baseSalaryCurrency
     *
     * @param string $baseSalaryCurrency
     * @return void
     */
    public function setBaseSalaryCurrency(string $baseSalaryCurrency): void {
        $this->baseSalaryCurrency = $baseSalaryCurrency;
    }

    /**
     * Returns the baseSalaryValue
     *
     * @return double baseSalaryValue
     */
    public function getBaseSalaryValue() {
        return number_format($this->baseSalaryValue, 2, '.', '');
    }

    /**
     * Sets the baseSalaryValue
     *
     * @param double $baseSalaryValue
     * @return void
     */
    public function setBaseSalaryValue($baseSalaryValue): void {
        $this->baseSalaryValue = number_format($baseSalaryValue, 2, '.', '');
    }

    /**
     * Returns the baseSalaryValueMax
     *
     * @return double baseSalaryValueMax
     */
    public function getBaseSalaryValueMax() {
        return number_format($this->baseSalaryValueMax, 2, '.', '');
    }

    /**
     * Sets the baseSalaryValueMax
     *
     * @param double $baseSalaryValueMax
     * @return void
     */
    public function setBaseSalaryValueMax($baseSalaryValueMax): void {
        $this->baseSalaryValueMax = number_format($baseSalaryValueMax, 2, '.', '');
    }

    /**
     * Returns the baseSalaryUnitText
     *
     * @return string baseSalaryUnitText
     */
    public function getBaseSalaryUnitText(): string {
        return $this->baseSalaryUnitText;
    }

    /**
     * Sets the baseSalaryUnitText
     *
     * @param string $baseSalaryUnitText
     * @return void
     */
    public function setBaseSalaryUnitText(string $baseSalaryUnitText): void {
        $this->baseSalaryUnitText = $baseSalaryUnitText;
    }

    /**
     * Returns the contactPointEmail
     *
     * @return string contactPointEmail
     */
    public function getContactPointEmail(): string {
        return $this->contactPointEmail;
    }

    /**
     * Sets the contactPointEmail
     *
     * @param string $contactPointEmail
     * @return void
     */
    public function setContactPointEmail(string $contactPointEmail): void {
        $this->contactPointEmail = $contactPointEmail;
    }

    /**
     * Returns the contactPointTelephone
     *
     * @return string contactPointTelephone
     */
    public function getContactPointTelephone(): string {
        return $this->contactPointTelephone;
    }

    /**
     * Sets the contactPointTelephone
     *
     * @param string $contactPointTelephone
     * @return void
     */
    public function setContactPointTelephone(string $contactPointTelephone): void {
        $this->contactPointTelephone = $contactPointTelephone;
    }

    /**
     * Returns the contactPointAddress
     *
     * @return \FriendsOfTYPO3\TtAddress\Domain\Model\Address $contactPointAddress
     */
    public function getContactPointAddress(): ?\FriendsOfTYPO3\TtAddress\Domain\Model\Address {
        return $this->contactPointAddress;
    }

    /**
     * Sets the contactPointAddress
     *
     * @param \FriendsOfTYPO3\TtAddress\Domain\Model\Address $contactPointAddress
     * @return void
     */
    public function setContactPointAddress(\FriendsOfTYPO3\TtAddress\Domain\Model\Address $contactPointAddress): void {
        $this->contactPointAddress = $contactPointAddress;
    }

    /**
     * Returns the images
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $images
     */
    public function getImages() {
        return $this->images;
    }

    /**
     * Sets the images
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $images
     * @return void
     */
    public function setImages(\TYPO3\CMS\Extbase\Domain\Model\FileReference $images): void {
        $this->images = $images;
    }

    /**
     * Adds a Images
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $images
     * @return void
     */
    public function addImages(\TYPO3\CMS\Extbase\Domain\Model\FileReference $images): void {
        $this->images->attach($images);
    }

    /**
     * Removes a Images
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $imagesFileToRemove The Images to be removed
     * @return void
     */
    public function removeImages(\TYPO3\CMS\Extbase\Domain\Model\FileReference $imagesFileToRemove): void {
        $this->images->detach($imagesFileToRemove);
    }

    /**
     * Returns the downloads
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $downloads
     */
    public function getDownloads() {
        return $this->downloads;
    }

    /**
     * Sets the downloads
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $downloads
     * @return void
     */
    public function setDownloads(\TYPO3\CMS\Extbase\Domain\Model\FileReference $downloads): void {
        $this->downloads = $downloads;
    }

    /**
     * Adds a downloads
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $downloads
     * @return void
     */
    public function addDownloads(\TYPO3\CMS\Extbase\Domain\Model\FileReference $downloads): void {
        $this->downloads->attach($downloads);
    }

    /**
     * Removes a downloads
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $downloadsFileToRemove The download to be removed
     * @return void
     */
    public function removeDownloads(\TYPO3\CMS\Extbase\Domain\Model\FileReference $downloadsFileToRemove): void {
        $this->downloads->detach($downloadsFileToRemove);
    }

    /**
     * Returns the ogTitle
     *
     * @return string ogTitle
     */
    public function getOgTitle(): string {
        return $this->ogTitle;
    }

    /**
     * Sets the ogTitle
     *
     * @param string $ogTitle
     * @return void
     */
    public function setOgTitle(string $ogTitle): void {
        $this->ogTitle = $ogTitle;
    }

    /**
     * Returns the ogDescription
     *
     * @return string ogDescription
     */
    public function getOgDescription(): string {
        return $this->ogDescription;
    }

    /**
     * Sets the ogDescription
     *
     * @param string $ogDescription
     * @return void
     */
    public function setOgDescription(string $ogDescription): void {
        $this->ogDescription = $ogDescription;
    }

    /**
     * Returns the ogImage
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $ogImage
     */
    public function getOgImage() {
        return $this->ogImage;
    }

    /**
     * Sets the ogImage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $ogImage
     * @return void
     */
    public function setOgImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $ogImage): void {
        $this->ogImage = $ogImage;
    }

    /**
     * Adds a ogImage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $ogImage
     * @return void
     */
    public function addOgImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $ogImage): void {
        $this->ogImage->attach($ogImage);
    }

    /**
     * Removes a ogImage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $imagesFileToRemove The ogImage to be removed
     * @return void
     */
    public function removeOgImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $imagesFileToRemove): void {
        $this->ogImage->detach($imagesFileToRemove);
    }

    /**
     * Returns the twitterTitle
     *
     * @return string twitterTitle
     */
    public function getTwitterTitle(): string {
        return $this->twitterTitle;
    }

    /**
     * Sets the twitterTitle
     *
     * @param string $twitterTitle
     * @return void
     */
    public function setTwitterTitle(string $twitterTitle): void {
        $this->twitterTitle = $twitterTitle;
    }

    /**
     * Returns the twitterDescription
     *
     * @return string twitterDescription
     */
    public function getTwitterDescription(): string {
        return $this->twitterDescription;
    }

    /**
     * Sets the twitterDescription
     *
     * @param string $twitterDescription
     * @return void
     */
    public function setTwitterDescription(string $twitterDescription): void {
        $this->twitterDescription = $twitterDescription;
    }

    /**
     * Returns the twitterCard
     *
     * @return string twitterCard
     */
    public function getTwitterCard(): string {
        return $this->twitterCard;
    }

    /**
     * Sets the twitterCard
     *
     * @param string $twitterCard
     * @return void
     */
    public function setTwitterCard(string $twitterCard): void {
        $this->twitterCard = $twitterCard;
    }

    /**
     * Returns the twitterImage
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $twitterImage
     */
    public function getTwitterImage() {
        return $this->twitterImage;
    }

    /**
     * Sets the twitterImage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $twitterImage
     * @return void
     */
    public function setTwitterImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $twitterImage): void {
        $this->twitterImage = $twitterImage;
    }

    /**
     * Adds a twitterImage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $twitterImage
     * @return void
     */
    public function addTwitterImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $twitterImage): void {
        $this->twitterImage->attach($twitterImage);
    }

    /**
     * Removes a twitterImage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $imagesFileToRemove The twitterImage to be removed
     * @return void
     */
    public function removeTwitterImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $imagesFileToRemove): void {
        $this->twitterImage->detach($imagesFileToRemove);
    }

    /**
     * getApplicationForm
     *
     * @return string
     */
    public function getApplicationForm(): string {
        return $this->applicationForm;
    }

    /**
     * setApplicationForm
     *
     * @param string
     */
    public function setApplicationForm(string $url): void {
        $this->applicationForm = $url;
    }
}
