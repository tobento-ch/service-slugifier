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

class Slugifiers implements SlugifiersInterface
{
    /**
     * Create a new Slugifiers.
     *
     * @param array<string, SlugifierInterface|SlugifierFactoryInterface> $slugifiers
     */
    public function __construct(
        protected array $slugifiers = [],
    ) {}
    
    /**
     * Add a slugifier.
     *
     * @param string $name
     * @param SlugifierInterface|SlugifierFactoryInterface $slugifier
     * @return static $this
     */
    public function add(string $name, SlugifierInterface|SlugifierFactoryInterface $slugifier): static
    {
        $this->slugifiers[$name] = $slugifier;
        return $this;
    }
    
    /**
     * Returns true if slugifier exists, otherwise false.
     *
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->slugifiers);
    }
    
    /**
     * Returns a slugifier by name.
     *
     * @param string $name
     * @return SlugifierInterface
     */
    public function get(string $name): SlugifierInterface
    {
        if (!isset($this->slugifiers[$name])) {
            return $this->getFallbackSlugifier($name);
        }
        
        if ($this->slugifiers[$name] instanceof SlugifierInterface) {
            return $this->slugifiers[$name];
        }

        if ($this->slugifiers[$name] instanceof SlugifierFactoryInterface) {
            return $this->slugifiers[$name] = $this->slugifiers[$name]->createSlugifier();
        }
        
        throw new \InvalidArgumentException(
            sprintf('Unable to create slugifier %s as invalid type', $name)
        );
    }
    
    /**
     * Returns all slugifier names.
     *
     * @return array<array-key, string>
     */
    public function names(): array
    {
        return array_keys($this->slugifiers);
    }
    
    /**
     * Returns the fallback slugifier.
     *
     * @param string $name
     * @return SlugifierInterface
     */
    protected function getFallbackSlugifier(string $name): SlugifierInterface
    {
        return $this->slugifiers[$name] = (new SlugifierFactory())->createSlugifier();
    }
}