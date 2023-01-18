<?php
declare(strict_types=1);

namespace HauerHeinrich\HhSimpleJobPosts\Utility;

/**
 * This file is part of the "hh_simple_job_posts" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Christian Hackl <chackl@hauer-heinrich.de>, www.Hauer-Heinrich.de
 */

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;

final class CacheUtility {

    private FrontendInterface $cache;

    public function __construct(FrontendInterface $cache) {
        $this->cache = $cache;
    }

    /**
     * getCachedValue
     */
    public function getCachedValue(string $cacheIdentifier): array {
        // If value is false, it has not been cached
        $value = $this->cache->get($cacheIdentifier);
        if ($value === false) {
            return [];
        }

        return $value;
    }

    /**
     * setCacheValue
     *
     * @var string $cacheIdentifier
     * @var array $value
     * @var array $tags
     * @var int $lifetime cache duration in seconds (86400 = 1 day)
     */
    public function setCacheValue(string $cacheIdentifier, array $value, array $tags = [], int $lifetime = 86400): void {
        // Calculate the value and store it in the cache
        // Store value in cache
        $this->cache->set($cacheIdentifier, $value, $tags, $lifetime);
    }
}
