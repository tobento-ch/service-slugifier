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
use Closure;

/**
 * Modify
 */
class Modify implements ModifierInterface
{
    use HasSupportedLocales;
    
    /**
     * Create a new Modify.
     *
     * @param callable $modifier
     * @param array $supportedLocales e.g. ['de', 'de-CH', 'de_CH'] or empty all supported.
     *    Furthermore, use an asterix as a wildcard to support all locales starting with e.g. ['de*', 'fr*']
     */
    public function __construct(
        protected $modifier,
        array $supportedLocales = [],
    ) {
        if (!is_callable($modifier)) {
            throw new \InvalidArgumentException(
                sprintf('Modifier needs to be a callable, %s given.', gettype($modifier))
            );
        }
    
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
        
        return call_user_func_array($this->modifier, [$string, $locale]);
    }
}