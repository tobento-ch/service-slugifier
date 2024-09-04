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
use Tobento\Service\Slugifier\Modifier\Trim;

class TrimTest extends TestCase
{
    public function testThatImplementsModifierInterface()
    {
        $this->assertInstanceOf(ModifierInterface::class, new Trim());
    }
    
    public function testModify()
    {
        $m = new Trim();
        
        $this->assertSame('foo', $m->modify(' foo   ', 'de'));
        $this->assertSame('foo Bar', $m->modify(' foo Bar ', 'de'));
        $this->assertSame('foo', $m->modify(' foo   ', 'en'));
    }
    
    public function testModifyWithChars()
    {
        $m = new Trim(chars: '-');
        
        $this->assertSame('foo ', $m->modify('-foo --', 'de'));
    }
}