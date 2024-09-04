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
use Tobento\Service\Slugifier\Resource;
use Tobento\Service\Slugifier\SlugifierFactory;
use Tobento\Service\Slugifier\SlugifierFactoryInterface;
use Tobento\Service\Slugifier\SlugifierInterface;
use Tobento\Service\Slugifier\Slugs;

class SlugifierFactoryTest extends TestCase
{
    public function testThatImplementsSlugifierFactoryInterface()
    {
        $this->assertInstanceOf(
            SlugifierFactoryInterface::class,
            new SlugifierFactory(),
        );
    }

    public function testCreateSlugifierMethod()
    {
        $slugifier = (new SlugifierFactory())->createSlugifier();

        $this->assertInstanceOf(SlugifierInterface::class, $slugifier);
    }
    
    public function testCreateSlugifierMethodWithModifiers()
    {
        $s = (new SlugifierFactory(
            modifiers: new Modifiers(
                new Modifier\AlphaNumOnly(),
            ),
        ))->createSlugifier();

        $this->assertSame('Lorem-ipsum', $s->slugify('Lorem & ipsum'));
    }
    
    public function testCreateSlugifierMethodWithSlugs()
    {
        $s = (new SlugifierFactory(
            slugs: new Slugs(
                new Resource\ArrayResource(['login', 'register']),
            ),
        ))->createSlugifier();

        $this->assertSame('login-1', $s->slugify('login'));
    }
    
    public function testSlugify()
    {
        $s = (new SlugifierFactory())->createSlugifier();
        
        $this->assertSame('', $s->slugify(''));
        $this->assertSame('lorem-ipsum', $s->slugify('Lorem ipsum'));
        $this->assertSame('lorem-ipsum', $s->slugify('Lorem-ipsum'));
        $this->assertSame('lorem-ipsum', $s->slugify('-Lorem---ipsum--'));
        $this->assertSame('lorem-ipsum', $s->slugify('Lorem ipsum!'));
        $this->assertSame('lorem-ipsum', $s->slugify('  lorem   ipsum   '));
        
        // dictonaries:
        $this->assertSame('blau-und-gruen', $s->slugify('Blau & grün', 'de'));
        $this->assertSame('blau-und-gruen', $s->slugify('Blau&grün', 'de'));
        $this->assertSame('blau-und-gruen', $s->slugify('Blau-&---grün', 'de'));
        $this->assertSame('blau-and-gruen', $s->slugify('Blau&grün', 'en'));
    }
}