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
use Tobento\Service\Slugifier\SlugsInterface;

class PreventDublicate implements ModifierInterface
{
    /**
     * Create a new PreventDublicate.
     *
     * @param SlugsInterface $slugs
     * @param string $separator
     */
    public function __construct(
        protected SlugsInterface $slugs,
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
        return $this->generateUniqueSlug($string, $locale);
    }
    
    /**
     * Returns a generated unique slug.
     *
     * @param string $string
     * @param string $locale
     * @return string The modified string
     */
    protected function generateUniqueSlug(string $string, string $locale): string
    {
        $originalString = $string;
        $limit = 5;
        $i = 1;

        while ($this->slugs->exists($string, $locale)) {
            
            if ($i >= $limit) {
                return $originalString.'-'.time();
            }
            
            $string = $originalString.$this->separator.$i++;
        }

        return $string;
    }
}