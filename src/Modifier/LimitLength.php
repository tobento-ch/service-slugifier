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
 * LimitLength
 */
class LimitLength implements ModifierInterface
{
    /**
     * Create a new LimitLength.
     *
     * @param int $length
     */
    public function __construct(
        protected int $length = 255
    ) {
        if ($length < 5) {
            throw new \InvalidArgumentException('Length should not be lower than 5');
        }
    }
    
    /**
     * Returns the modified string.
     *
     * @param string $string
     * @param string $locale
     * @return string The modified string
     */
    public function modify(string $string, string $locale): string
    {
        return substr($string, 0, $this->length);
    }
}