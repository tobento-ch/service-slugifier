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
use Tobento\Service\Slugifier\Modifier\Replace;

class ReplaceTest extends TestCase
{
    public function testThatImplementsModifierInterface()
    {
        $this->assertInstanceOf(ModifierInterface::class, new Replace(replace: []));
    }
    
    public function testModify()
    {
        $m = new Replace(replace: ['ä' => 'ae']);
        
        $this->assertSame('ae', $m->modify('ä', 'de'));
        $this->assertSame('Baer', $m->modify('Bär', 'de'));
        $this->assertSame('ae aeae', $m->modify('ä ää', 'de'));
        $this->assertSame('ae', $m->modify('ä', 'en'));
    }
    
    public function testModifyWithSuportedLocales()
    {
        $m = new Replace(replace: ['ä' => 'ae'], supportedLocales: ['de*', 'en-GB']);
        
        $this->assertSame('Baer', $m->modify('Bär', 'de'));
        $this->assertSame('Baer', $m->modify('Bär', 'de-CH'));
        $this->assertSame('Bär', $m->modify('Bär', 'en'));
        $this->assertSame('Baer', $m->modify('Bär', 'en-GB'));
    }
}