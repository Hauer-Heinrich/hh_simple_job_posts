<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\Event;

use \HauerHeinrich\HhSimpleJobPosts\Controller\JobpostController;
use \TYPO3\CMS\Extbase\Mvc\Request;

/**
 * This file is part of the "hh_simple_job_posts" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Christian Hackl <chackl@hauer-heinrich.de>, www.Hauer-Heinrich.de
 */
final class JobpostsListEvent {

    /**
     * originalPluginSettings
     */
    private array $settings;

    private array $assignedValues;

    public function __construct(private Request $request, private JobpostController $jobpostController, array $settings, array $assignedValues) {
        $this->settings = $settings;
        $this->assignedValues = $assignedValues;
    }

    public function getJobpostController(): JobpostController {
        return $this->jobpostController;
    }

    public function setJobpostController(JobpostController $jobpostController): self {
        $this->jobpostController = $jobpostController;

        return $this;
    }

    /**
     * Get original plugin settings
     */
    public function getSettings(): array {
        return $this->settings;
    }

    public function getAssignedValues(): array {
        return $this->assignedValues;
    }

    public function setAssignedValues(array $assignedValues): self {
        $this->assignedValues = $assignedValues;

        return $this;
    }

    public function getRequest(): Request {
        return $this->request;
    }
}
