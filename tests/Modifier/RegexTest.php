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
use Tobento\Service\Slugifier\Modifier\Regex;

class RegexTest extends TestCase
{
    public function testThatImplementsModifierInterface()
    {
        $this->assertInstanceOf(ModifierInterface::class, new Regex(pattern: '#-+#'));
    }
    
    public function testModify()
    {
        $m = new Regex(pattern: '#-+#');
        
        $this->assertSame('foo-bar', $m->modify('foo---bar', 'de'));
        $this->assertSame('foo-bar', $m->modify('foo---bar', 'en'));
    }
    
    public function testModifyWithCustomSeparator()
    {
        $m = new Regex(pattern: '#-+#', separator: '_');
        
        $this->assertSame('foo_bar', $m->modify('foo---bar', 'en'));
    }
    
    public function testModifyWithSuportedLocales()
    {
        $m = new Regex(pattern: '#-+#', supportedLocales: ['de*', 'en-GB']);
        
        $this->assertSame('foo-bar', $m->modify('foo---bar', 'de'));
        $this->assertSame('foo-bar', $m->modify('foo---bar', 'de-CH'));
        $this->assertSame('foo---bar', $m->modify('foo---bar', 'en'));
        $this->assertSame('foo-bar', $m->modify('foo---bar', 'en-GB'));
    }
}