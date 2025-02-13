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

namespace Tobento\Service\Slugifier\Modifier\Dictionary;

class English extends AbstractDictionary
{
    /**
     * Returns true if the dictionary supports the locale, otherwise false.
     *
     * @param string $locale
     * @return bool
     */
    public function supportsLocale(string $locale): bool
    {
        return str_starts_with(strtolower($locale), 'en');
    }
    
    /**
     * Returns the dictionary.
     *
     * @return array<string, string> E.g. ['ä' => 'ae']
     */
    public function getDictionary(): array
    {
        return [];
    }
    
    /**
     * Returns the dictionary words.
     *
     * @return array<string, string> E.g. ['&' => 'and']
     */
    public function getDictionaryWords(): array
    {
        return [
            '&' => 'and',
            '€' => 'euro',
            '$' => 'dollar',
            '@' => 'at',
            '%' => 'percent',
        ];
    }
}