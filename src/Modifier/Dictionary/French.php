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

class French extends AbstractDictionary
{
    /**
     * Returns true if the dictionary supports the locale, otherwise false.
     *
     * @param string $locale
     * @return bool
     */
    public function supportsLocale(string $locale): bool
    {
        return str_starts_with(strtolower($locale), 'fr');
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
            'Â' => 'A',
            'Æ' => 'Ae',
            'Ç' => 'C',
            'É' => 'E',
            'È' => 'E',
            'Ê' => 'E',
            'Ë' => 'E',
            'Ï' => 'I',
            'Î' => 'I',
            'Ô' => 'O',
            'Œ' => 'Oe',
            'Ù' => 'U',
            'Û' => 'U',
            'Ü' => 'U',
            'à' => 'a',
            'â' => 'a',
            'æ' => 'ae',
            'ç' => 'c',
            'é' => 'e',
            'è' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'ï' => 'i',
            'î' => 'i',
            'ô' => 'o',
            'œ' => 'oe',
            'ù' => 'u',
            'û' => 'u',
            'ü' => 'u',
            'ÿ' => 'y',
            'Ÿ' => 'Y',
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
            '&' => 'et',
            '€' => 'euros',
            '$' => 'dollar',
            '@' => 'at',
            '%' => 'pour cent',
        ];
    }
}