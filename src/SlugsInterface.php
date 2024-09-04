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

interface SlugsInterface
{
    /**
     * Add a resource.
     *
     * @param ResourceInterface $resource
     * @return static $this
     */
    public function addResource(ResourceInterface $resource): static;
    
    /**
     * Returns true if the given slug exists, otherwise false.
     *
     * @param string $slug
     * @param string $locale
     * @return bool
     */
    public function exists(string $slug, string $locale = 'en'): bool;
    
    /**
     * Returns a single slug by the specified parameters or null if not found.
     *
     * @param string $slug
     * @param string $locale
     * @return null|SlugInterface
     */
    public function findSlug(string $slug, string $locale = 'en'): null|SlugInterface;
}