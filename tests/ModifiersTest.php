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
use Tobento\Service\Slugifier\ModifiersInterface;

class ModifiersTest extends TestCase
{
    public function testThatImplementsModifiersInterface()
    {
        $this->assertInstanceOf(ModifiersInterface::class, new Modifiers());
    }

    public function testAddMethod()
    {
        $modifiers = new Modifiers();
        $modifier = new Modifier\Trim();
        $modifiers->add($modifier);
        
        $this->assertSame($modifier, $modifiers->all()[0]);
    }
    
    public function testPrependMethod()
    {
        $modifiers = new Modifiers();
        $modifier = new Modifier\Trim();
        $modifiers->add($modifier);
        
        $stripTags = new Modifier\StripTags();
        $modifiers->prepend($stripTags);
        
        $this->assertSame($stripTags, $modifiers->all()[0]);
    }
    
    public function testAllMethod()
    {
        $modifiers = new Modifiers(new Modifier\StripTags());
        $modifiers->add(new Modifier\Trim());
        
        $this->assertSame(2, count($modifiers->all()));
    }

    public function testModifyMethod()
    {
        $modifiers = new Modifiers(
            new Modifier\StripTags(),
            new Modifier\AlphaNumOnly(),
        );

        $modified = $modifiers->modify(
            string: '<p>Lorem ipsum</p>',
            locale: 'en',
        );
        
        $this->assertSame('Lorem-ipsum', $modified);
    }
}