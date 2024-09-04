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

class Slugs implements SlugsInterface
{
    /**
     * @var array<array-key, ResourceInterface>
     */
    protected array $resources = [];
    
    /**
     * @var array<string, array<string, bool|SlugInterface>>
     */
    protected array $slugs = [];
    
    /**
     * Create a new Slugs.
     *
     * @param ResourceInterface ...$resources
     */
    public function __construct(
        ResourceInterface ...$resources,
    ) {
        $this->resources = $resources;
    }

    /**
     * Add a resource.
     *
     * @param ResourceInterface $resource
     * @return static $this
     */
    public function addResource(ResourceInterface $resource): static
    {
        $this->resources[] = $resource;
        return $this;
    }
    
    /**
     * Returns true if the given slug exists, otherwise false.
     *
     * @param string $slug
     * @param string $locale
     * @return bool
     */
    public function exists(string $slug, string $locale = 'en'): bool
    {
        if (isset($this->slugs[$locale][$slug])) {
            return true;
        }
        
        $resources = $this->resources;
        
        usort(
            $resources,
            fn (ResourceInterface $a, ResourceInterface $b): int
                => $b->priority() <=> $a->priority()
        );
        
        foreach($resources as $resource) {
            if ($resource->slugExists($slug, $locale)) {
                $this->slugs[$locale][$slug] = true;
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Returns a single slug by the specified parameters or null if not found.
     *
     * @param string $slug
     * @param string $locale
     * @return null|SlugInterface
     */
    public function findSlug(string $slug, string $locale = 'en'): null|SlugInterface
    {
        if (
            isset($this->slugs[$locale][$slug])
            && $this->slugs[$locale][$slug] instanceof SlugInterface
        ) {
            return $this->slugs[$locale][$slug];
        }
        
        $resources = $this->resources;
        
        usort(
            $resources,
            fn (ResourceInterface $a, ResourceInterface $b): int
                => $b->priority() <=> $a->priority()
        );
        
        foreach($resources as $resource) {
            if ($foundSlug = $resource->findSlug($slug, $locale)) {
                $this->slugs[$locale][$slug] = $foundSlug;
                return $foundSlug;
            }
        }
        
        return null;
    }
}