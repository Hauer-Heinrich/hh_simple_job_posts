<?php

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

    private JobpostController $jobpostController;

    /**
     * originalPluginSettings
     */
    private array $settings;

    private array $assignedValues;

    private Request $request;

    public function __construct(JobpostController $jobpostController, array $settings, array $assignedValues, Request $request) {
        $this->jobpostController = $jobpostController;
        $this->settings = $settings;
        $this->assignedValues = $assignedValues;
        $this->request = $request;
    }

    /**
     * Get the tag controller
     */
    public function getJobpostController(): JobpostController {
        return $this->jobpostController;
    }

    /**
     * Set the tag controller
     */
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

    /**
     * Get the assignedValues
     */
    public function getAssignedValues(): array {
        return $this->assignedValues;
    }

    /**
     * Set the assignedValues
     */
    public function setAssignedValues(array $assignedValues): self {
        $this->assignedValues = $assignedValues;

        return $this;
    }

    /**
     * Get the request
     */
    public function getRequest(): Request {
        return $this->request;
    }
}
