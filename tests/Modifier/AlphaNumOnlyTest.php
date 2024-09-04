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
use Tobento\Service\Slugifier\Modifier\AlphaNumOnly;

class AlphaNumOnlyTest extends TestCase
{
    public function testThatImplementsModifierInterface()
    {
        $this->assertInstanceOf(ModifierInterface::class, new AlphaNumOnly());
    }
    
    public function testModify()
    {
        $m = new AlphaNumOnly();
        
        $this->assertSame('foo-bar', $m->modify('foo & bar', 'en'));
        $this->assertSame('123-foo-45', $m->modify('123 foo 45', 'en'));
        $this->assertSame('Foo-Bar', $m->modify('Foo Bar', 'en'));
        $this->assertSame('-foo-bar-', $m->modify('  foo  ?!  bar  ', 'en'));
        $this->assertSame('gr-n', $m->modify('grün', 'de'));
    }
    
    public function testModifyCustomSeparator()
    {
        $m = new AlphaNumOnly(separator: '_');
        
        $this->assertSame('foo_bar', $m->modify('foo bar', 'en'));
    }
}