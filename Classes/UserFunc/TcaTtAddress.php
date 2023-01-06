<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\UserFunc;

/**
 * This file is part of the "hh_simple_job_posts" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Christian Hackl <chackl@hauer-heinrich.de>, www.Hauer-Heinrich.de
 */

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class TcaTtAddress {

    /**
     * label
     * switch lable for location or person data-set
     *
     * @param array $parameters
     * @return void
     */
    public function label(array &$parameters): void {
        $title = '';

        if($parameters['table'] === 'tt_address') {
            switch ($parameters['row']['tx_extbase_type']) {
                case 'ttAddress_location':
                    $title = $parameters['row']['company'];
                    break;

                default:
                    $title = $parameters['row']['name'];
                    break;
            }
        }

        $parameters['title'] = $title;
    }
}
