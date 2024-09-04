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
use Tobento\Service\Slugifier\Modifier\Dictionary\Latin;

class LatinTest extends TestCase
{
    public function testThatImplementsModifierInterface()
    {
        $this->assertInstanceOf(ModifierInterface::class, new Latin());
    }
    
    public function testModify()
    {
        $m = new Latin();
        
        $data = [
            'À Á Â Ã Ä Å Æ Ç È É Ê Ë Ì Í Î Ï Ð Ñ Ò Ó Ô Õ Ö Œ Ø Ù Ú Û Ü Ý Ÿ Þ à á â ã ä å æ ç è é ê ë ì í î ï ð ñ ò ó ô õ ö œ ø ù ú û ü ý ÿ þ ß',
            'A A A A Ae A Ae C E E E E I I I I D N O O O O Oe Oe O U U U Ue Y Y P a a a a ae a ae c e e e e i i i i o n o o o o oe oe o u u u ue y y p ss'
        ];
        
        $this->assertSame($data[1], $m->modify($data[0], 'en'));
    }
    
    public function testModifySkipedIfNotLatin()
    {
        $m = new Latin();
        
        $this->assertSame('foo & bar', $m->modify('foo & bar', 'de'));
    }
    
    public function testModifyWords()
    {
        $m = new Latin();
        
        $this->assertSame('foo & bar', $m->modify('foo & bar', 'it'));
    }
    
    public function testModifyWithoutWords()
    {
        $m = new Latin(withWords: false);
        
        $this->assertSame('foo & bar', $m->modify('foo & bar', 'it'));
    }
}