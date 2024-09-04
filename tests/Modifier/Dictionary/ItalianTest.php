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
use Tobento\Service\Slugifier\Modifier\Dictionary\Italian;

class ItalianTest extends TestCase
{
    public function testThatImplementsModifierInterface()
    {
        $this->assertInstanceOf(ModifierInterface::class, new Italian());
    }
    
    public function testModify()
    {
        $m = new Italian();
        
        $data = [
            'À È Ì Ò Ù à é è ì ò ù',
            'A E I o u a e e i o u'
        ];
        
        $this->assertSame($data[1], $m->modify($data[0], 'it'));
    }
    
    public function testModifySkipedIfNotItalian()
    {
        $m = new Italian();
        
        $this->assertSame('foo & bar', $m->modify('foo & bar', 'de'));
    }
    
    public function testModifyWords()
    {
        $m = new Italian();
        
        $this->assertSame('foo -e- bar', $m->modify('foo & bar', 'it'));
        $this->assertSame('Foo-e-bar', $m->modify('Foo&bar', 'it-CH'));
        $this->assertSame('foo-e--e-bar', $m->modify('foo&&bar', 'IT'));
        $this->assertSame('foo-e-', $m->modify('foo&', 'it-ch'));
        $this->assertSame('foo -e- bar-e-baz', $m->modify('foo & bar&baz', 'it'));
        
        $m = new Italian(separator: '');
        $this->assertSame('e', $m->modify('&', 'it'));
        $this->assertSame('euro', $m->modify('€', 'it'));
        $this->assertSame('dollaro', $m->modify('$', 'it'));
        $this->assertSame('at', $m->modify('@', 'it'));
        $this->assertSame('per cento', $m->modify('%', 'it'));
    }
    
    public function testModifyWithoutWords()
    {
        $m = new Italian(withWords: false);
        
        $this->assertSame('foo & bar', $m->modify('foo & bar', 'it'));
    }
    
    public function testModifyCustomSeparator()
    {
        $m = new Italian(separator: '');
        
        $this->assertSame('foo e bar', $m->modify('foo & bar', 'it'));
    }
}