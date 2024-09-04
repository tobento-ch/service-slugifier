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
use Tobento\Service\Slugifier\Modifier\LimitLength;

class LimitLengthTest extends TestCase
{
    public function testThatImplementsModifierInterface()
    {
        $this->assertInstanceOf(ModifierInterface::class, new LimitLength());
    }
    
    public function testModify()
    {
        $m = new LimitLength(length: 10);
        
        $this->assertSame('Some very ', $m->modify('Some very long string', 'en'));
    }
    
    public function testThrowsInvalidArgumentExceptionIfBelowMinLength()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Length should not be lower than 5');
        
        new LimitLength(length: 4);
    }
}