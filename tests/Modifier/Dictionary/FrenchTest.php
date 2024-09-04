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
use Tobento\Service\Slugifier\Modifier\Dictionary\French;

class FrenchTest extends TestCase
{
    public function testThatImplementsModifierInterface()
    {
        $this->assertInstanceOf(ModifierInterface::class, new French());
    }
    
    public function testModify()
    {
        $m = new French();
        
        $data = [
            'À Â Æ Ç É È Ê Ë Ï Î Ô Œ Ù Û Ü à â æ ç é è ê ë ï î ô œ ù û ü ÿ Ÿ',
            'A A Ae C E E E E I I O Oe U U U a a ae c e e e e i i o oe u u u y Y'
        ];
        
        $this->assertSame($data[1], $m->modify($data[0], 'fr'));
    }
    
    public function testModifySkipedIfNotFrench()
    {
        $m = new French();
        
        $this->assertSame('foo & bar', $m->modify('foo & bar', 'de'));
    }
    
    public function testModifyWords()
    {
        $m = new French();
        
        $this->assertSame('foo -et- bar', $m->modify('foo & bar', 'fr'));
        $this->assertSame('Foo-et-bar', $m->modify('Foo&bar', 'fr-CH'));
        $this->assertSame('foo-et--et-bar', $m->modify('foo&&bar', 'FR'));
        $this->assertSame('foo-et-', $m->modify('foo&', 'fr-ch'));
        $this->assertSame('foo -et- bar-et-baz', $m->modify('foo & bar&baz', 'fr'));
        
        $m = new French(separator: '');
        $this->assertSame('et', $m->modify('&', 'fr'));
        $this->assertSame('euros', $m->modify('€', 'fr'));
        $this->assertSame('dollar', $m->modify('$', 'fr'));
        $this->assertSame('at', $m->modify('@', 'fr'));
        $this->assertSame('pour cent', $m->modify('%', 'fr'));
    }
    
    public function testModifyWithoutWords()
    {
        $m = new French(withWords: false);
        
        $this->assertSame('foo & bar', $m->modify('foo & bar', 'fr'));
    }
    
    public function testModifyCustomSeparator()
    {
        $m = new French(separator: '');
        
        $this->assertSame('foo et bar', $m->modify('foo & bar', 'fr'));
    }
}