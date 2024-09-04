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

interface SlugifierInterface
{
    /**
     * Returns the slug version of the string.
     *
     * @param string $string
     * @return string
     */
    public function slugify(string $string): string;
}