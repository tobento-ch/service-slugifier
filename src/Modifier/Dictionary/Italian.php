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

class Italian extends AbstractDictionary
{
    /**
     * Returns true if the dictionary supports the locale, otherwise false.
     *
     * @param string $locale
     * @return bool
     */
    public function supportsLocale(string $locale): bool
    {
        return str_starts_with(strtolower($locale), 'it');
    }
    
    /**
     * Returns the dictionary.
     *
     * @return array<string, string> E.g. ['ä' => 'ae']
     */
    public function getDictionary(): array
    {
        return [
            'À' => 'A',
            'È' => 'E',
            'Ì' => 'I',
            'Ò' => 'o',
            'Ù' => 'u',
            'à' => 'a',
            'é' => 'e',
            'è' => 'e',
            'ì' => 'i',
            'ò' => 'o',
            'ù' => 'u',
        ];
    }
    
    /**
     * Returns the dictionary words.
     *
     * @return array<string, string> E.g. ['&' => 'and']
     */
    public function getDictionaryWords(): array
    {
        return [
            '&' => 'e',
            '€' => 'euro',
            '$' => 'dollaro',
            '@' => 'at',
            '%' => 'per cento',
        ];
    }
}