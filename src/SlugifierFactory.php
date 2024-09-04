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

use Tobento\Service\Slugifier\Modifier;

/**
 * SlugifierFactory
 */
class SlugifierFactory implements SlugifierFactoryInterface
{
    /**
     * Create a new SlugifierFactory.
     *
     * @param null|ModifiersInterface $modifiers
     * @param null|SlugsInterface $slugs
     */
    public function __construct(
        protected null|ModifiersInterface $modifiers = null,
        protected null|SlugsInterface $slugs = null,
    ) {}
    
    /**
     * Create a slugifier.
     *
     * @return SlugifierInterface
     */
    public function createSlugifier(): SlugifierInterface
    {
        if (!is_null($this->modifiers)) {
            return new Slugifier($this->modifiers);
        }
        
        $modifiers = [
            new Modifier\StripTags(),
            
            // locale specific dictionaries:
            new Modifier\Dictionary\English(),
            new Modifier\Dictionary\German(),
            new Modifier\Dictionary\French(),
            new Modifier\Dictionary\Italian(),
            // supports all locales, acts as a fallback:
            new Modifier\Dictionary\Latin(),
            
            new Modifier\Lowercase(),
            new Modifier\Trim(),
            new Modifier\AlphaNumOnly(separator: '-'),
            new Modifier\Trim('-'),
            
            // removes repeated separators like -- to -:
            new Modifier\Regex(pattern: '#-+#', separator: '-'),
            
            new Modifier\LimitLength(),
        ];
        
        if ($this->slugs) {
            $modifiers[] = new Modifier\PreventDublicate($this->slugs);
        }
        
        return new Slugifier(new Modifiers(...$modifiers));
    }
}