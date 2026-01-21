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
        // Detect existing numeric suffix: slug-2, slug-10, etc.
        if (preg_match('/^(.*)' . preg_quote($this->separator, '/') . '(\d+)$/', $string, $matches)) {
            $base = $matches[1];
            $i = (int)$matches[2];
        } else {
            $base = $string;
            $i = 1;
        }

        // Dynamic limit: allow 5 attempts beyond the current suffix
        $limit = $i + 5;

        while ($this->slugs->exists($string, $locale)) {

            if ($i >= $limit) {
                return $base . $this->separator . time();
            }

            $string = $base . $this->separator . $i;
            $i++;
        }

        return $string;
    }
}