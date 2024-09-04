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

trait HasSupportedLocales
{
    /**
     * @var null|SupportedLocales
     */
    protected null|SupportedLocales $supportedLocales = null;

    /**
     * Sets the supported locales.
     *
     * @param array $locales
     * @return void
     */
    public function supportedLocales(array $locales): void
    {
        if (!empty($locales)) {
            $this->supportedLocales = new SupportedLocales($locales);
        }
    }
    
    /**
     * Returns true if the locale is supported, otherwise false.
     *
     * @param string $locale
     * @return bool
     */
    public function supportsLocale(string $locale): bool
    {
        if ($this->supportedLocales) {
            return $this->supportedLocales->supports($locale);
        }
        
        return true;
    }
}