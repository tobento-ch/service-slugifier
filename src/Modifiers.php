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
 * Modifiers
 */
class Modifiers implements ModifiersInterface
{
    /**
     * @var array<int, ModifierInterface>
     */
    protected array $modifiers = [];
    
    /**
     * Create a new Modifiers.
     *
     * @param ModifierInterface $modifier
     */
    public function __construct(
        ModifierInterface ...$modifier,
    ) {
        $this->modifiers = $modifier;
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
        foreach($this->all() as $modifier) {
            $string = $modifier->modify($string, $locale);
        }
        
        return $string;
    }
    
    /**
     * Add a modifier.
     *
     * @param ModifierInterface $modifier
     * @return static $this
     */
    public function add(ModifierInterface $modifier): static
    {
        $this->modifiers[] = $modifier;
        return $this;
    }
    
    /**
     * Add a modifier to the beginning.
     *
     * @param ModifierInterface $modifier
     * @return static $this
     */
    public function prepend(ModifierInterface $modifier): static
    {
        array_unshift($this->modifiers, $modifier);
        return $this;
    }
    
    /**
     * Returns all modifiers.
     *
     * @return array<int, ModifierInterface>
     */
    public function all(): array
    {
        return $this->modifiers;
    }
}