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

/**
 * ModifiersInterface
 */
interface ModifiersInterface
{
    /**
     * Returns the modified string.
     *
     * @param string $string
     * @param string $locale
     * @return string The modified string
     */
    public function modify(string $string, string $locale): string;
    
    /**
     * Add a modifier.
     *
     * @param ModifierInterface $modifier
     * @return static $this
     */
    public function add(ModifierInterface $modifier): static;
    
    /**
     * Add a modifier to the beginning.
     *
     * @param ModifierInterface $modifier
     * @return static $this
     */
    public function prepend(ModifierInterface $modifier): static;
    
    /**
     * Returns all modifiers.
     *
     * @return array<int, ModifierInterface>
     */
    public function all(): array;
}