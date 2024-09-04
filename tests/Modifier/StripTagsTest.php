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

namespace Tobento\Service\Slugifier\Test\Modifier;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Slugifier\ModifierInterface;
use Tobento\Service\Slugifier\Modifier\StripTags;

class StripTagsTest extends TestCase
{
    public function testThatImplementsModifierInterface()
    {
        $this->assertInstanceOf(ModifierInterface::class, new StripTags());
    }
    
    public function testModify()
    {
        $m = new StripTags();
        
        $this->assertSame('', $m->modify('<p></p>', 'en'));
        $this->assertSame('foo barbaz', $m->modify('foo <p>bar</p>baz', 'en'));
        $this->assertSame('foo', $m->modify('<p>foo</p>', 'de'));
    }
}