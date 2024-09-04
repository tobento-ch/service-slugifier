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

namespace Tobento\Service\Slugifier\Test\Modifier\Dictionary;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Slugifier\ModifierInterface;
use Tobento\Service\Slugifier\Modifier\Dictionary\English;

class EnglishTest extends TestCase
{
    public function testThatImplementsModifierInterface()
    {
        $this->assertInstanceOf(ModifierInterface::class, new English());
    }
    
    public function testModify()
    {
        $m = new English();
        
        $this->assertSame('foo -and- bar', $m->modify('foo & bar', 'en'));
    }
    
    public function testModifySkipedIfNotEnglish()
    {
        $m = new English();
        
        $this->assertSame('foo & bar', $m->modify('foo & bar', 'de'));
    }
    
    public function testModifyWords()
    {
        $m = new English();
        
        $this->assertSame('foo -and- bar', $m->modify('foo & bar', 'en'));
        $this->assertSame('Foo-and-bar', $m->modify('Foo&bar', 'en-GB'));
        $this->assertSame('foo-and--and-bar', $m->modify('foo&&bar', 'EN'));
        $this->assertSame('foo-and-', $m->modify('foo&', 'en-gb'));
        $this->assertSame('foo -and- bar-and-baz', $m->modify('foo & bar&baz', 'en'));
        
        $m = new English(separator: '');
        
        $this->assertSame('and', $m->modify('&', 'en'));
        $this->assertSame('euro', $m->modify('€', 'en'));
        $this->assertSame('dollar', $m->modify('$', 'en'));
        $this->assertSame('at', $m->modify('@', 'en'));
        $this->assertSame('percent', $m->modify('%', 'en'));
    }
    
    public function testModifyWithoutWords()
    {
        $m = new English(withWords: false);
        
        $this->assertSame('foo & bar', $m->modify('foo & bar', 'en'));
    }
    
    public function testModifyCustomSeparator()
    {
        $m = new English(separator: '');
        
        $this->assertSame('foo and bar', $m->modify('foo & bar', 'en'));
    }
}