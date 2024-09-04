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

namespace Tobento\Service\Slugifier\Modifier;

use Tobento\Service\Slugifier\ModifierInterface;

/**
 * Lowercase
 */
class Lowercase implements ModifierInterface
{
    /**
     * Create a new Lowercase.
     *
     * @param null|string $encoding
     */
    public function __construct(
        protected null|string $encoding = 'UTF-8',
    ) {}
    
    /**
     * Returns the modified string.
     *
     * @param string $string
     * @param string $locale
     * @return string The modified string
     */
    public function modify(string $string, string $locale): string
    {
        return mb_strtolower($string, $this->encoding);
    }
}