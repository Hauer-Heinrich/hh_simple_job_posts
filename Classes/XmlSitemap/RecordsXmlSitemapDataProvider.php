<?php
declare(strict_types=1);

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

namespace HauerHeinrich\HhSimpleJobPosts\XmlSitemap;

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \Psr\Http\Message\ServerRequestInterface;
use \TYPO3\CMS\Core\Context\Context;
use \TYPO3\CMS\Core\Database\Connection;
use \TYPO3\CMS\Core\Database\ConnectionPool;
use \TYPO3\CMS\Core\Database\Query\QueryHelper;
use \TYPO3\CMS\Core\Domain\Repository\PageRepository;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use \TYPO3\CMS\Seo\XmlSitemap\Exception\MissingConfigurationException;

/**
 * XmlSiteDataProvider will provide information for the XML sitemap for a specific database table
 * @internal
 */
class RecordsXmlSitemapDataProvider extends \TYPO3\CMS\Seo\XmlSitemap\AbstractXmlSitemapDataProvider {

    protected PageRepository $pageRepository;

    /**
     * @param ServerRequestInterface $request
     * @param string $key
     * @param array $config
     * @param ContentObjectRenderer|null $cObj
     * @throws MissingConfigurationException
     */
    public function __construct(ServerRequestInterface $request, string $key, array $config = [], ContentObjectRenderer $cObj = null) {
        parent::__construct($request, $key, $config, $cObj);

        $this->pageRepository = GeneralUtility::makeInstance(PageRepository::class);
        $this->generateItems();
    }

    /**
     * @throws MissingConfigurationException
     */
    public function generateItems(): void {
        $table = $this->config['table'];

        if (empty($table)) {
            throw new MissingConfigurationException(
                'No configuration found for sitemap ' . $this->getKey(),
                1535576053
            );
        }

        $queryBuilderPlugin = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tt_content');
        $pluginsSettings = $queryBuilderPlugin->select('uid', 'pi_flexform')
            ->from('tt_content')
            ->where(
                $queryBuilderPlugin->expr()->eq('CType', $queryBuilderPlugin->createNamedParameter('hhsimplejobposts_jobslist'))
            )
            ->executeQuery()->fetchAllAssociative();

        if (!empty($pluginsSettings)) {
            foreach ($pluginsSettings as $plugin) {
                $flexform = $plugin['pi_flexform'];
                $flexformArray = GeneralUtility::xml2array($flexform);
                $pluginSettings = $flexformArray['data']['sDEF']['lDEF'];
                $pid = $pluginSettings['settings.jobsStorage']['vDEF'];
                $pageId = $pluginSettings['settings.jobsDetailView']['vDEF'];
                if(empty($pageId)) {
                    $pageId = $pid;
                }

                if (empty($this->config['url']['pageId'])) {
                    $this->config['url']['pageId'] = $pageId;
                }

                $pids = !empty($pid) ? GeneralUtility::intExplode(',', $pid) : [];
                $lastModifiedField = $this->config['lastModifiedField'] ?? 'tstamp';
                $sortField = $this->config['sortField'] ?? 'sorting';

                $changeFreqField = $this->config['changeFreqField'] ?? '';
                $priorityField = $this->config['priorityField'] ?? '';

                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                    ->getQueryBuilderForTable($table);

                $constraints = [];
                if (!empty($GLOBALS['TCA'][$table]['ctrl']['languageField'])) {
                    $constraints[] = $queryBuilder->expr()->in(
                        $GLOBALS['TCA'][$table]['ctrl']['languageField'],
                        [
                            -1, // All languages
                            $this->getLanguageId()  // Current language
                        ]
                    );
                }

                if (!empty($pids)) {
                    $recursiveLevel = (int)($this->config['recursive'] ?? 0);
                    $pids = $this->pageRepository->getPageIdsRecursive($pids, $recursiveLevel);

                    $constraints[] = $queryBuilder->expr()->in('pid', $queryBuilder->createNamedParameter($pids, Connection::PARAM_INT_ARRAY));
                }

                if (!empty($this->config['additionalWhere'])) {
                    $constraints[] = QueryHelper::stripLogicalOperatorPrefix($this->config['additionalWhere']);
                }

                $queryBuilder->select('*')
                    ->from($table);

                if (!empty($constraints)) {
                    $queryBuilder->where(
                        ...$constraints
                    );
                }

                $rows = $queryBuilder->orderBy($sortField)
                    ->executeQuery()->fetchAllAssociative();

                foreach ($rows as $row) {
                    $item = [
                        'data' => $row,
                        'lastMod' => (int)$row[$lastModifiedField]
                    ];
                    if (!empty($changeFreqField)) {
                        $item['changefreq'] = $row[$changeFreqField];
                    }
                    $item['priority'] = !empty($priorityField) ? $row[$priorityField] : 0.5;
                    $this->items[] = $item;
                }
            }
        }

        // Delete duplicate items
        $this->arrayUniqueByUid($this->items);
    }

    /**
     * @param array $data
     * @return array
     */
    protected function defineUrl(array $data): array {
        $pageId = $this->config['url']['pageId'] ?? $GLOBALS['TSFE']->id;
        $additionalParams = [];

        $additionalParams = $this->getUrlFieldParameterMap($additionalParams, $data['data']);
        $additionalParams = $this->getUrlAdditionalParams($additionalParams);

        $additionalParamsString = http_build_query(
            $additionalParams,
            '',
            '&',
            PHP_QUERY_RFC3986
        );

        $typoLinkConfig = [
            'parameter' => $pageId,
            'additionalParams' => $additionalParamsString ? '&' . $additionalParamsString : '',
            'forceAbsoluteUrl' => 1,
        ];

        $data['loc'] = $this->cObj->typoLink_URL($typoLinkConfig);

        return $data;
    }

    /**
     * @param array $additionalParams
     * @param array $data
     * @return array
     */
    protected function getUrlFieldParameterMap(array $additionalParams, array $data): array {
        if (!empty($this->config['url']['fieldToParameterMap']) &&
            \is_array($this->config['url']['fieldToParameterMap'])) {
            foreach ($this->config['url']['fieldToParameterMap'] as $field => $urlPart) {
                $additionalParams[$urlPart] = $data[$field];
            }
        }

        return $additionalParams;
    }

    /**
     * @param array $additionalParams
     * @return array
     */
    protected function getUrlAdditionalParams(array $additionalParams): array {
        if (!empty($this->config['url']['additionalGetParameters']) &&
            is_array($this->config['url']['additionalGetParameters'])) {
            foreach ($this->config['url']['additionalGetParameters'] as $extension => $extensionConfig) {
                foreach ($extensionConfig as $key => $value) {
                    $additionalParams[$extension . '[' . $key . ']'] = $value;
                }
            }
        }

        return $additionalParams;
    }

    /**
     * @return int
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     */
    protected function getLanguageId(): int {
        $context = GeneralUtility::makeInstance(Context::class);

        return (int)$context->getPropertyFromAspect('language', 'id');
    }

    /**
     * deletes duplicate items by uid
     *
     * @param  array $items
     * @return array
     */
    protected function arrayUniqueByUid(array &$items): void {
        $seen = [];

        foreach ($items as $key => $item) {
            $uid = $item['data']['uid'] ?? null;

            if (isset($seen[$uid])) {
                unset($items[$key]);
            } else {
                $seen[$uid] = true;
            }
        }
    }
}
