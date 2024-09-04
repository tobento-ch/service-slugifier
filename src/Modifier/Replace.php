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
 * Replaces the given replace pairs.
 */
class Replace implements ModifierInterface
{
    use HasSupportedLocales;
    
    /**
     * Create a new Replacer.
     *
     * @param array<string, string> $replace The replace pairs e.g. ['ä' => 'ae']
     * @param array $supportedLocales e.g. ['de', 'de-CH', 'de_CH'] or empty all supported.
     *    Furthermore, use an asterix as a wildcard to support all locales starting with e.g. ['de*', 'fr*']
     */
    public function __construct(
        protected array $replace,
        array $supportedLocales = [],
    ) {
        $this->supportedLocales($supportedLocales);
    }
    
    /**
     * Returns the modified string.
     *
     * @param string $string
     * @param string $locale
     * @param SlugifierInterface $slugifier
     * @return string The modified string
     */
    public function modify(string $string, string $locale): string
    {
        if (! $this->supportsLocale($locale)) {
            return $string;
        }
        
        return strtr($string, $this->replace);
    }
}