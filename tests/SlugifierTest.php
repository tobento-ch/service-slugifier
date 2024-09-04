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

namespace Tobento\Service\Slugifier\Test;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Slugifier\Modifier;
use Tobento\Service\Slugifier\Modifiers;
use Tobento\Service\Slugifier\Slugifier;
use Tobento\Service\Slugifier\SlugifierInterface;

class SlugifierTest extends TestCase
{
    public function testThatImplementsSlugifierInterface()
    {
        $this->assertInstanceOf(SlugifierInterface::class, new Slugifier(new Modifiers()));
    }

    public function testSlugifyMethod()
    {
        $slugifier = new Slugifier(new Modifiers(
            new Modifier\StripTags(),
            new Modifier\AlphaNumOnly(),
        ));

        $slug = $slugifier->slugify(
            string: '<p>Lorem ipsum</p>',
            locale: 'en',
        );
        
        $this->assertSame('Lorem-ipsum', $slug);
    }
}