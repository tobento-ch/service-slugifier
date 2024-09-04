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

use Tobento\Service\Slugifier\ModifierInterface;

/**
 * AbstractDictionary
 */
abstract class AbstractDictionary implements ModifierInterface
{
    /**
     * @var string
     */
    protected string $separator = '-';
    
    /**
     * @var bool
     */
    protected bool $withWords = true;
    
    /**
     * @var null|array<string, string>
     */
    private null|array $words = null;
    
    /**
     * Returns true if the dictionary supports the locale, otherwise false.
     *
     * @param string $locale
     * @return bool
     */
    abstract public function supportsLocale(string $locale): bool;
    
    /**
     * Returns the dictionary.
     *
     * @return array<string, string> E.g. ['ä' => 'ae']
     */
    abstract public function getDictionary(): array;
    
    /**
     * Returns the dictionary words.
     *
     * @return array<string, string> E.g. ['&' => 'and']
     */
    abstract public function getDictionaryWords(): array;
    
    /**
     * Create a new instance.
     *
     * @param bool $withWords
     * @param string $separator
     */
    public function __construct(
        bool $withWords = true,
        string $separator = '-',
    ) {
        $this->withWords = $withWords;
        $this->separator = $separator;
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
        if ($this->supportsLocale($locale)) {
            $string = strtr($string, $this->getDictionary());
            
            if ($this->withWords) {
                return strtr($string, $this->getWords());
            }
            
            return $string;
        }
        
        return $string;
    }
    
    /**
     * Returns the dictionary words with spearator.
     *
     * @return array<string, string> E.g. ['&' => '-and-']
     */
    private function getWords(): array
    {
        if (is_array($this->words)) {
            return $this->words;
        }
        
        $this->words = [];
        
        foreach ($this->getDictionaryWords() as $key => $value) {
            $this->words[$key] = $this->separator.$value.$this->separator;
        }
        
        return $this->words;
    }
}