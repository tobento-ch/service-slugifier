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

interface SlugifiersInterface
{
    /**
     * Returns true if slugifier exists, otherwise false.
     *
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool;
    
    /**
     * Returns a slugifier by name.
     *
     * @param string $name
     * @return SlugifierInterface
     */
    public function get(string $name): SlugifierInterface;
    
    /**
     * Returns all slugifier names.
     *
     * @return array<array-key, string>
     */
    public function names(): array;
}