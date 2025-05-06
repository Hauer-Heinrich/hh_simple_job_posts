<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\Domain\Model;

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Extbase\Annotation\Validate;
use \TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use \TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use \TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use \TYPO3\CMS\Extbase\Domain\Model\FileReference;
use \FriendsOfTYPO3\TtAddress\Domain\Model\Address;

/**
 * This file is part of the "hh_simple_job_posts" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Christian Hackl <chackl@hauer-heinrich.de>, www.Hauer-Heinrich.de
 */
class Jobpost extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    protected int $apiUid;
    protected ?\DateTime $crdate;
    protected ?\DateTime $tstamp;

    /** @var ?\DateTime */
    protected $starttime;

    /** @var ?\DateTime */
    protected $endtime;

    protected string $slug = '';

    #[Validate(['validator' => \TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator::class])]
    protected string $title;

    protected string $shortDescription = '';
    protected string $description = '';
    protected string $maintasks = '';
    protected string $profile = '';
    protected string $educationRequirements = '';
    protected string $experienceRequirements = '';
    protected string $skills = '';
    protected string $weprovide = '';
    protected string $others = '';
    protected string $employmentType = '';
    protected array $employmentTypeArray = [];
    protected string $workHours = '';
    protected ?Address $hiringOrganization = null;

    /**
     * @var ObjectStorage<Address>
     */
    protected ?ObjectStorage $jobLocations = null;

    protected string $baseSalaryCurrency = '';
    protected float $baseSalaryValue;
    protected float $baseSalaryValueMax;
    protected string $baseSalaryUnitText;
    protected string $contactPointEmail = '';
    protected string $contactPointTelephone = '';
    protected ?Address $contactPointAddress = null;

    /**
     * @var ObjectStorage<Address>
     */
    protected ?ObjectStorage $contactPointAddresses = null;

    /**
     * @var ObjectStorage<FileReference>
     */
    #[Lazy()]
    #[Cascade(['value' => 'remove'])]
    protected ?ObjectStorage $images;

    /**
     * @var ObjectStorage<FileReference>
     */
    #[Lazy()]
    #[Cascade(['value' => 'remove'])]
    protected ?ObjectStorage $downloads;

    protected string $ogTitle = '';
    protected string $ogDescription = '';

    /**
     * @var ObjectStorage<FileReference>
     */
    #[Lazy()]
    #[Cascade(['value' => 'remove'])]
    protected ?ObjectStorage $ogImage;

    protected string $twitterTitle = '';
    protected string $twitterDescription = '';
    protected string $twitterCard = '';

    /**
     * @var ObjectStorage<FileReference>
     */
    #[Lazy()]
    #[Cascade(['value' => 'remove'])]
    protected ?ObjectStorage $twitterImage;

    protected string $applicationForm = '';

    /**
     * @var ObjectStorage<\HauerHeinrich\HhSimpleJobPosts\Domain\Model\Category>
     */
    protected ?ObjectStorage $categories = null;

    /**
     * Initialize categories and media relation
     */
    public function __construct() {
        $this->images = new ObjectStorage();
        $this->downloads = new ObjectStorage();
        $this->ogImage = new ObjectStorage();
        $this->twitterImage = new ObjectStorage();
        $this->jobLocations = $this->jobLocations ?: new ObjectStorage();
        $this->contactPointAddresses = $this->contactPointAddresses ?: new ObjectStorage();
        $this->categories = new ObjectStorage();
    }

    public function getApiUid(): int {
        return $this->apiUid;
    }

    public function setApiUid(int $apiUid): void {
        $this->apiUid = $apiUid;
    }

    public function getCrdate(): ?\DateTime  {
        return $this->crdate;
    }

    public function setCrdate(\DateTime $crdate): void {
        $this->crdate = $crdate;
    }

    public function getYearOfCrdate(): string {
        return $this->getCrdate()->format('Y');
    }

    public function getMonthOfCrdate(): string {
        return $this->getCrdate()->format('m');
    }

    public function getDayOfCrdate(): int {
        return (int)$this->crdate->format('d');
    }

    public function getTstamp(): ?\DateTime {
        return $this->tstamp;
    }

    public function setTstamp(\DateTime $tstamp): void {
        $this->tstamp = $tstamp;
    }

    public function getStarttime(): ?\DateTime {
        return $this->starttime;
    }

    public function setStarttime(\DateTime $starttime) {
        $this->starttime = $starttime;
    }

    public function getEndtime(): ?\DateTime {
        return $this->endtime;
    }

    public function setEndtime(\DateTime $endtime) {
        $this->endtime = $endtime;
    }

    public function setSlug(string $slug): void {
        $this->slug = $slug;
    }

    public function getSlug(): string {
        return $this->slug;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function getShortDescription(): string {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): void {
        $this->shortDescription = $shortDescription;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function getMaintasks(): string {
        return $this->maintasks;
    }

    public function setMaintasks(string $maintasks): void {
        $this->maintasks = $maintasks;
    }

    public function getProfile(): string {
        return $this->profile;
    }

    public function setProfile(string $profile): void {
        $this->profile = $profile;
    }

    public function getEducationRequirements(): string {
        return $this->educationRequirements;
    }

    public function setEducationRequirements(string $educationRequirements): void {
        $this->educationRequirements = $educationRequirements;
    }

    public function getExperienceRequirements(): string {
        return $this->experienceRequirements;
    }

    public function setExperienceRequirements(string $experienceRequirements): void {
        $this->experienceRequirements = $experienceRequirements;
    }

    public function getSkills(): string {
        return $this->skills;
    }

    public function setSkills(string $skills): void {
        $this->skills = $skills;
    }

    public function getWeprovide(): string {
        return $this->weprovide;
    }

    public function setWeprovide(string $weprovide): void {
        $this->weprovide = $weprovide;
    }

    public function getOthers(): string {
        return $this->others;
    }

    public function setOthers(string $others): void {
        $this->others = $others;
    }

    public function getEmploymentType(): string {
        return $this->employmentType;
    }

    public function setEmploymentType(string $employmentType): void {
        $this->employmentType = $employmentType;
    }

    public function getEmploymentTypeArray(): array {
        return GeneralUtility::trimExplode(',', $this->employmentType, true);
    }

    public function setEmploymentTypeArray(string $employmentType): void {
        $this->employmentTypeArray = GeneralUtility::trimExplode(',', $employmentType, true);
    }

    public function getWorkHours(): string {
        return $this->workHours;
    }

    public function setWorkHours(string $workHours): void {
        $this->workHours = $workHours;
    }

    public function getHiringOrganization(): ?Address {
        return $this->hiringOrganization;
    }

    public function setHiringOrganization(Address $hiringOrganization): void {
        $this->hiringOrganization = $hiringOrganization;
    }

    public function addJobLocation(Address $jobLocation): void {
        $this->jobLocations->attach($jobLocation);
    }

    public function removeJobLocation(Address $jobLocationToRemove): void {
        $this->jobLocations->detach($jobLocationToRemove);
    }

    public function getJobLocations(): ObjectStorage {
        return $this->jobLocations;
    }

    public function setJobLocations(ObjectStorage $jobLocations): void {
        $this->jobLocations = $jobLocations;
    }

    public function getBaseSalaryCurrency(): string {
        return $this->baseSalaryCurrency;
    }

    public function setBaseSalaryCurrency(string $baseSalaryCurrency): void {
        $this->baseSalaryCurrency = $baseSalaryCurrency;
    }

    public function getBaseSalaryValue() {
        return number_format($this->baseSalaryValue, 2, '.', '');
    }

    public function setBaseSalaryValue($baseSalaryValue): void {
        $this->baseSalaryValue = number_format($baseSalaryValue, 2, '.', '');
    }

    public function getBaseSalaryValueMax() {
        return number_format($this->baseSalaryValueMax, 2, '.', '');
    }

    public function setBaseSalaryValueMax($baseSalaryValueMax): void {
        $this->baseSalaryValueMax = number_format($baseSalaryValueMax, 2, '.', '');
    }

    public function getBaseSalaryUnitText(): string {
        return $this->baseSalaryUnitText;
    }

    public function setBaseSalaryUnitText(string $baseSalaryUnitText): void {
        $this->baseSalaryUnitText = $baseSalaryUnitText;
    }

    public function getContactPointEmail(): string {
        return $this->contactPointEmail;
    }

    public function setContactPointEmail(string $contactPointEmail): void {
        $this->contactPointEmail = $contactPointEmail;
    }

    public function getContactPointTelephone(): string {
        return $this->contactPointTelephone;
    }

    public function setContactPointTelephone(string $contactPointTelephone): void {
        $this->contactPointTelephone = $contactPointTelephone;
    }

    /**
     * @deprecated
     */
    public function getContactPointAddress(): ?Address {
        return $this->contactPointAddress;
    }

    /**
     * @deprecated
     */
    public function setContactPointAddress(Address $contactPointAddress): void {
        $this->contactPointAddress = $contactPointAddress;
    }

    public function addContactPointAddress(Address $contactPointAddress): void {
        $this->contactPointAddresses->attach($contactPointAddress);
    }

    public function removeContactPointAddress(Address $contactPointAddressToRemove): void {
        $this->contactPointAddresses->detach($contactPointAddressToRemove);
    }

    public function getContactPointAddresses(): ObjectStorage {
        return $this->contactPointAddresses;
    }

    /**
     * @param ObjectStorage<Address> $contactPointAddresses
     */
    public function setContactPointAddresses(ObjectStorage $contactPointAddresses): void {
        $this->contactPointAddresses = $contactPointAddresses;
    }

    public function getImages(): ?ObjectStorage {
        return $this->images;
    }

    public function setImages(FileReference $images): void {
        $this->images = $images;
    }

    public function addImages(FileReference $images): void {
        $this->images->attach($images);
    }

    public function removeImages(FileReference $imagesFileToRemove): void {
        $this->images->detach($imagesFileToRemove);
    }

    public function getDownloads(): ?ObjectStorage {
        return $this->downloads;
    }

    public function setDownloads(FileReference $downloads): void {
        $this->downloads = $downloads;
    }

    public function addDownloads(FileReference $downloads): void {
        $this->downloads->attach($downloads);
    }

    public function removeDownloads(FileReference $downloadsFileToRemove): void {
        $this->downloads->detach($downloadsFileToRemove);
    }

    public function getOgTitle(): string {
        return $this->ogTitle;
    }

    public function setOgTitle(string $ogTitle): void {
        $this->ogTitle = $ogTitle;
    }

    public function getOgDescription(): string {
        return $this->ogDescription;
    }

    public function setOgDescription(string $ogDescription): void {
        $this->ogDescription = $ogDescription;
    }

    public function getOgImage(): ?ObjectStorage {
        return $this->ogImage;
    }

    public function setOgImage(FileReference $ogImage): void {
        $this->ogImage = $ogImage;
    }

    public function addOgImage(FileReference $ogImage): void {
        $this->ogImage->attach($ogImage);
    }

    public function removeOgImage(FileReference $imagesFileToRemove): void {
        $this->ogImage->detach($imagesFileToRemove);
    }

    public function getTwitterTitle(): string {
        return $this->twitterTitle;
    }

    public function setTwitterTitle(string $twitterTitle): void {
        $this->twitterTitle = $twitterTitle;
    }

    public function getTwitterDescription(): string {
        return $this->twitterDescription;
    }

    public function setTwitterDescription(string $twitterDescription): void {
        $this->twitterDescription = $twitterDescription;
    }

    public function getTwitterCard(): string {
        return $this->twitterCard;
    }

    public function setTwitterCard(string $twitterCard): void {
        $this->twitterCard = $twitterCard;
    }

    public function getTwitterImage(): ?ObjectStorage {
        return $this->twitterImage;
    }

    public function setTwitterImage(FileReference $twitterImage): void {
        $this->twitterImage = $twitterImage;
    }

    public function addTwitterImage(FileReference $twitterImage): void {
        $this->twitterImage->attach($twitterImage);
    }

    public function removeTwitterImage(FileReference $imagesFileToRemove): void {
        $this->twitterImage->detach($imagesFileToRemove);
    }

    public function getApplicationForm(): string {
        return $this->applicationForm;
    }

    public function setApplicationForm(string $url): void {
        $this->applicationForm = $url;
    }

    public function getCategories(): ?ObjectStorage {
        return $this->categories;
    }

    /**
     * @param ObjectStorage<\HauerHeinrich\HhSimpleJobPosts\Domain\Model\Category> $categories
     */
    public function setCategories(ObjectStorage $categories) {
        $this->categories = $categories;
    }

    /**
     * @param \HauerHeinrich\HhSimpleJobPosts\Domain\Model\Category $category
     */
    public function addCategory(\HauerHeinrich\HhSimpleJobPosts\Domain\Model\Category $category): void {
        $this->categories->attach($category);
    }

    /**
     * @param  \HauerHeinrich\HhSimpleJobPosts\Domain\Model\Category $category
     */
    public function removeCategory(\HauerHeinrich\HhSimpleJobPosts\Domain\Model\Category $category): void {
        $this->categories->detach($category);
    }

    /**
     * json_encode RTE-fields for usage at json-ld / meta-tags and so on
     * e. g. escapes double-quotes
     */
    public function getEscapedRteFields(): array {
        $result = [];

        $job = [];
        $job['shortDescription'] = $this->getDescription();
        $job['description'] = $this->getShortDescription();
        $job['maintasks'] = $this->getMaintasks();
        $job['profile'] = $this->getProfile();
        $job['educationRequirements'] = $this->getEducationRequirements();
        $job['experienceRequirements'] = $this->getExperienceRequirements();
        $job['skills'] = $this->getSkills();
        $job['weprovide'] = $this->getWeprovide();
        $job['others'] = $this->getOthers();

        // Strip all html-attributes and double quotes
        // $result = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/si",'<$1$2>', $job);

        foreach ($job as $key => $value) {
            $result[$key] = \json_encode($value);
        }

        return $result;
    }

    /**
     * get full description accordion to google:
     * (including job responsibilities, qualifications, skills, working hours, education requirements, and experience requirements)
     * https://developers.google.com/search/docs/appearance/structured-data/job-posting?hl=de#job-posting-definition
     */
    public function getDescriptionForGoogle(): string {
        return $this->getDescription() . $this->getMaintasks() . $this->getEducationRequirements() . $this->getExperienceRequirements() . $this->getSkills() . $this->getWorkHours();
    }
}
