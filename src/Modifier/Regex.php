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

use Tobento\Service\Slugifier\HasSupportedLocales;
use Tobento\Service\Slugifier\ModifierInterface;

/**
 * Regex
 */
class Regex implements ModifierInterface
{
    use HasSupportedLocales;
    
    /**
     * Create a new Regex.
     *
     * @param string $pattern
     * @param string $separator
     * @param array $supportedLocales e.g. ['de', 'de-CH', 'de_CH'] or empty all supported.
     *    Furthermore, use an asterix as a wildcard to support all locales starting with e.g. ['de*', 'fr*']
     */
    public function __construct(
        protected string $pattern,
        protected string $separator = '-',
        array $supportedLocales = [],
    ) {
        $this->supportedLocales($supportedLocales);
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
        if (! $this->supportsLocale($locale)) {
            return $string;
        }
        
        return preg_replace($this->pattern, $this->separator, $string);
    }
}