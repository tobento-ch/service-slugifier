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
 * AlphaNumOnly
 */
class AlphaNumOnly implements ModifierInterface
{
    /**
     * Create a new AlphaNumOnly.
     *
     * @param string $separator
     */
    public function __construct(
        protected string $separator = '-',
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
        return preg_replace('~[^\w\d-]+~', $this->separator, $string);
    }
}