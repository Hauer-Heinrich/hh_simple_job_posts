<?php
namespace HauerHeinrich\HhSimpleJobPosts\ViewHelper;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Core\LinkHandling\TypoLinkCodecService;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ViewHelper to render a phone link
 * TODO:Needed as long as BUG isn't fixed: https://forge.typo3.org/issues/102139
 */

class PhoneLinkViewHelper extends AbstractViewHelper {

    /**
     * As this ViewHelper renders HTML, the output must not be escaped.
     *
     * @var bool
     */
    protected $escapeOutput = false;

    public function initializeArguments() {
        $this->registerArgument('parameter', 'string', 'String from BE link wizard phone.', true);
    }

    /**
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): string {
        $parameter = $arguments['parameter'] ?? '';
        if($parameter !== '') {
            $typoLinkCodec = GeneralUtility::makeInstance(TypoLinkCodecService::class);
            $typoLinkConfiguration = $typoLinkCodec->decode($parameter);

            if(isset($typoLinkConfiguration['url']) && $typoLinkConfiguration['url'] !== '') {
                return str_replace('tel:', '', $typoLinkConfiguration['url']);
            }
        }

        return '';
    }
}
