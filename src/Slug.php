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

namespace Tobento\Service\Slugifier;

class Slug implements SlugInterface
{
    /**
     * Create a new Slug.
     *
     * @param string $slug
     * @param string $locale
     * @param null|string $resourceKey
     * @param null|string|int $resourceId
     */
    public function __construct(
        protected string $slug,
        protected string $locale,
        protected null|string $resourceKey = null,
        protected null|string|int $resourceId = null,
    ) {}
    
    /**
     * Returns the slug.
     *
     * @return string
     */
    public function slug(): string
    {
        return $this->slug;
    }
    
    /**
     * Returns the locale.
     *
     * @return string
     */
    public function locale(): string
    {
        return $this->locale;
    }
    
    /**
     * Returns the resource key.
     *
     * @return null|string
     */
    public function resourceKey(): null|string
    {
        return $this->resourceKey;
    }
    
    /**
     * Returns the resource id.
     *
     * @return null|string|int
     */
    public function resourceId(): null|string|int
    {
        return $this->resourceId;
    }
}