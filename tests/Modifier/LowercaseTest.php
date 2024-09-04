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
use Tobento\Service\Slugifier\Modifier\Lowercase;

class LowercaseTest extends TestCase
{
    public function testThatImplementsModifierInterface()
    {
        $this->assertInstanceOf(ModifierInterface::class, new Lowercase());
    }
    
    public function testModify()
    {
        $m = new Lowercase();
        
        $this->assertSame('lorem ipsum', $m->modify('Lorem Ipsum', 'en'));
        
        $m = new Lowercase(encoding: null);
        
        $this->assertSame('lorem ipsum', $m->modify('Lorem Ipsum', 'de'));
    }
}