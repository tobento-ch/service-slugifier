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

interface SlugInterface
{
    /**
     * Returns the slug.
     *
     * @return string
     */
    public function slug(): string;
    
    /**
     * Returns the locale.
     *
     * @return string
     */
    public function locale(): string;
    
    /**
     * Returns the resource key.
     *
     * @return null|string
     */
    public function resourceKey(): null|string;
    
    /**
     * Returns the resource id.
     *
     * @return null|string|int
     */
    public function resourceId(): null|string|int;
}