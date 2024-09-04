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

/**
 * ModifierInterface
 */
interface ModifierInterface
{
    /**
     * Returns the modified string.
     *
     * @param string $string
     * @param string $locale
     * @return string The modified string
     */
    public function modify(string $string, string $locale): string;
}