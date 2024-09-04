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
use Tobento\Service\Slugifier\Modifier\Modify;

class ModifyTest extends TestCase
{
    public function testThatImplementsModifierInterface()
    {
        $this->assertInstanceOf(ModifierInterface::class, new Modify(fn (string $string) => $string));
    }
    
    public function testModify()
    {
        $m = new Modify(modifier: fn (string $string, string $locale): string => $locale === 'de' ? $string : strtoupper($string));
        
        $this->assertSame('Foo', $m->modify('Foo', 'de'));
        $this->assertSame('FOO', $m->modify('Foo', 'en'));
        
        $m = new Modify(modifier: fn (string $string): string => strtoupper($string));
        
        $this->assertSame('FOO', $m->modify('Foo', 'de'));
        $this->assertSame('FOO', $m->modify('Foo', 'en'));
    }
    
    public function testModifyWithSuportedLocales()
    {
        $m = new Modify(
            modifier: fn (string $string): string => strtoupper($string),
            supportedLocales: ['de*', 'en-GB']
        );
        
        $this->assertSame('FOO', $m->modify('Foo', 'de'));
        $this->assertSame('FOO', $m->modify('Foo', 'de-CH'));
        $this->assertSame('Foo', $m->modify('Foo', 'en'));
        $this->assertSame('FOO', $m->modify('Foo', 'en-GB'));
    }
    
    public function testThrowsInvalidArgumentExceptionIfModifierIsNotCallable()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Modifier needs to be a callable, string given.');
        
        $m = new Modify(modifier: 'invalid');
    }
}