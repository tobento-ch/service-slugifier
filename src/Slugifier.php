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

class Slugifier implements SlugifierInterface
{
    /**
     * Create a new Slugifier.
     *
     * @param ModifiersInterface $modifiers
     */
    public function __construct(
        protected ModifiersInterface $modifiers
    ) {}
    
    /**
     * Returns the slug version of the string.
     *
     * @param string $string
     * @param string $locale
     * @return string
     */
    public function slugify(string $string, string $locale = 'en'): string
    {
        return $this->modifiers->modify($string, $locale);
    }
}