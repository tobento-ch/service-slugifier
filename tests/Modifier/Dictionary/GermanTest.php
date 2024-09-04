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
use Tobento\Service\Slugifier\Modifier\Dictionary\German;

class GermanTest extends TestCase
{
    public function testThatImplementsModifierInterface()
    {
        $this->assertInstanceOf(ModifierInterface::class, new German());
    }
    
    public function testModify()
    {
        $m = new German();
        
        $data = [
            'Ä Ö Ü ä ö ü ß',
            'Ae Oe Ue ae oe ue ss'
        ];
        
        $this->assertSame($data[1], $m->modify($data[0], 'de'));
    }
    
    public function testModifySkipedIfNotGerman()
    {
        $m = new German();
        
        $this->assertSame('foo & bar', $m->modify('foo & bar', 'en'));
    }
    
    public function testModifyWords()
    {
        $m = new German();
        
        $this->assertSame('foo -und- bar', $m->modify('foo & bar', 'de'));
        $this->assertSame('Foo-und-bar', $m->modify('Foo&bar', 'de-CH'));
        $this->assertSame('foo-und--und-bar', $m->modify('foo&&bar', 'DE'));
        $this->assertSame('foo-und-', $m->modify('foo&', 'de-ch'));
        $this->assertSame('foo -und- bar-und-baz', $m->modify('foo & bar&baz', 'de'));
        
        $m = new German(separator: '');
        $this->assertSame('und', $m->modify('&', 'de'));
        $this->assertSame('Euro', $m->modify('€', 'de'));
        $this->assertSame('Dollar', $m->modify('$', 'de'));
        $this->assertSame('at', $m->modify('@', 'de'));
        $this->assertSame('Prozent', $m->modify('%', 'de'));
    }
    
    public function testModifyWithoutWords()
    {
        $m = new German(withWords: false);
        
        $this->assertSame('foo & bar', $m->modify('foo & bar', 'de'));
    }
    
    public function testModifyCustomSeparator()
    {
        $m = new German(separator: '');
        
        $this->assertSame('foo und bar', $m->modify('foo & bar', 'de'));
    }
}