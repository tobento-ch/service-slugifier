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
 * Trim
 */
class Trim implements ModifierInterface
{
    /**
     * Create a new Trim.
     *
     * @param null|string $chars
     */
    public function __construct(
        protected null|string $chars = null,
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
        return is_null($this->chars) ? trim($string) : trim($string, $this->chars);
    }
}