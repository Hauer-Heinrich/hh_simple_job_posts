<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\Hooks\Tca;

/**
 * This file is part of the "hh_simple_job_posts" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Core\Localization\LanguageService;

/**
 * Class AddFieldsToSelector
 */
class AddFieldsToSelector {

    /** @var LanguageService */
    protected $languageService;

    public function __construct() {
        $this->languageService = $GLOBALS['LANG'];
    }

    // TODO: consolidate with list
    const sortFields = ['title', 'employment_type'];

    /**
     * Manipulating the input array, $params, adding new selectorbox items.
     *
     * @param array $params array of select field options (reference)
     */
    public function main(array &$params) {
        $selectOptions = [];
        foreach (self::sortFields as $field) {
            $label = $this->languageService->sL($GLOBALS['TCA']['tx_hhsimplejobposts_domain_model_jobpost']['columns'][$field]['label']);
            $label = rtrim($label, ':');

            $selectOptions[] = [
                'field' => $field,
                'label' => $label
            ];
        }

        // sort by labels
        $labels = [];
        foreach ($selectOptions as $key => $v) {
            $labels[$key] = $v['label'];
        }
        $labels = array_map('strtolower', $labels);
        array_multisort($labels, SORT_ASC, $selectOptions);

        // add fields to <select>
        foreach ($selectOptions as $option) {
            $params['items'][] = [
                $option['label'],
                $option['field']
            ];
        }
    }
}
