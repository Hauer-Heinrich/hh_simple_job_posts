<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\UserFunc;

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class TcaTtAddress {

    /**
     * label
     * switch lable for location or person data-set
     *
     * @param array $parameters
     * @return void
     */
    public function label(array &$parameters) {
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
