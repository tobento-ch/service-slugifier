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

class SupportedLocales
{
    /**
     * @var array<array-key, string>
     */
    protected array $wildcardLocales = [];
    
    /**
     * @var array<array-key, string>
     */
    protected array $locales = [];
    
    /**
     * Create a new SupportedLocales.
     *
     * @param array $locales E.g. ['de', 'de-CH', 'de_CH'] or empty all supported.
     *    Furthermore, use an asterix as a wildcard to support all locales starting with e.g. ['de*', 'fr*']
     */
    public function __construct(array $locales)
    {
        foreach($locales as $locale) {
            if (str_ends_with($locale, '*')) {
                $this->wildcardLocales[] = rtrim($locale, '*');
            } else {
                $this->locales[] = strtolower($locale);
            }
        }
    }

    /**
     * Returns true if the locale is supported, otherwise false.
     *
     * @param string $locale
     * @return bool
     */
    public function supports(string $locale): bool
    {
        if (empty($this->wildcardLocales) && empty($this->locales)) {
            return true;
        }
        
        $locale = strtolower($locale);
        
        foreach($this->wildcardLocales as $wildcardLocale) {
            if (str_starts_with($locale, $wildcardLocale)) {
                return true;
            }
        }
        
        return in_array($locale, $this->locales);
    }
}