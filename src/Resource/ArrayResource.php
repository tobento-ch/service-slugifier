<?php

/**
 * TOBENTO
 *
 * @copyright   Tobias Strub, TOBENTO
 * @license     MIT License, see LICENSE file distributed with this source code.
 * @author      Tobias Strub
 * @link        https://www.tobento.ch
 */

declare(strict_types=1);

namespace Tobento\Service\Slugifier\Resource;

use Tobento\Service\Slugifier\HasSupportedLocales;
use Tobento\Service\Slugifier\ResourceInterface;
use Tobento\Service\Slugifier\Slug;
use Tobento\Service\Slugifier\SlugInterface;

/**
 * ArrayResource
 */
class ArrayResource implements ResourceInterface
{
    use HasSupportedLocales;
    
    /**
     * Create a new ArrayResource.
     *
     * @param array<array-key, string> $slugs
     * @param array $supportedLocales e.g. ['de', 'de-CH', 'de_CH'] or empty all supported.
     *    Furthermore, use an asterix as a wildcard to support all locales starting with e.g. ['de*', 'fr*']
     * @param null|string $key
     * @param int $priority
     */
    public function __construct(
        protected array $slugs,
        array $supportedLocales = [],
        protected null|string $key = null,
        protected int $priority = 1000,
    ) {
        $this->supportedLocales($supportedLocales);
    }
    
    /**
     * Returns true if the given slug exists, otherwise false.
     *
     * @param string $slug
     * @param string $locale
     * @return bool
     */
    public function slugExists(string $slug, string $locale = 'en'): bool
    {
        if (! $this->supportsLocale($locale)) {
            return false;
        }
        
        return in_array($slug, $this->slugs);
    }
    
    /**
     * Returns a single slug by the specified parameters or null if not found.
     *
     * @param string $slug
     * @param string $locale
     * @return null|SlugInterface
     */
    public function findSlug(string $slug, string $locale = 'en'): null|SlugInterface
    {
        if (! $this->slugExists($slug, $locale)) {
            return null;
        }
        
        return new Slug(slug: $slug, locale: $locale, resourceKey: $this->key());
    }
    
    /**
     * Returns the key.
     *
     * @return null|string
     */
    public function key(): null|string
    {
        return $this->key;
    }
    
    /**
     * Returns the priority.
     *
     * @return int
     */
    public function priority(): int
    {
        return $this->priority;
    }
}