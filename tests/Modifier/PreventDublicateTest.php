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
use Tobento\Service\Slugifier\Modifier\PreventDublicate;
use Tobento\Service\Slugifier\Resource\ArrayResource;
use Tobento\Service\Slugifier\Slugs;

class PreventDublicateTest extends TestCase
{
    public function testThatImplementsModifierInterface()
    {
        $this->assertInstanceOf(ModifierInterface::class, new PreventDublicate(new Slugs()));
    }
    
    public function testModify()
    {
        $m = new PreventDublicate(
            slugs: new Slugs(
                new ArrayResource(['login'])
            ),
        );
        
        $this->assertSame('login-1', $m->modify('login', 'de'));
        $this->assertSame('login-1', $m->modify('login', 'en'));
        $this->assertSame('foo', $m->modify('foo', 'en'));
    }
    
    public function testModifyIncreasesNum()
    {
        $slugs = new Slugs(new ArrayResource(['login']));
        $m = new PreventDublicate(slugs: $slugs);
        
        $this->assertSame('login-1', $m->modify('login', 'de'));
        
        $slugs->addResource(new ArrayResource(['login-1']));
        
        $this->assertSame('login-1-1', $m->modify('login-1', 'en'));
        $this->assertSame('login-2', $m->modify('login', 'en'));
        
        $slugs->addResource(new ArrayResource(['login-2']));
        
        $this->assertSame('login-3', $m->modify('login', 'en'));
    }
    
    public function testModifyIfLimitReachedUsesTime()
    {
        $m = new PreventDublicate(
            slugs: new Slugs(
                new ArrayResource(['login', 'login-1', 'login-2', 'login-3', 'login-4', 'login-5'])
            ),
        );
        
        $modified = explode('-', $m->modify('login', 'de'));
        
        $this->assertSame('login', $modified[0]);
        $this->assertSame(10, strlen($modified[1]));
    }
    
    public function testModifyWithCustomSeparator()
    {
        $m = new PreventDublicate(
            slugs: new Slugs(
                new ArrayResource(['login'])
            ),
            separator: '_',
        );
        
        $this->assertSame('login_1', $m->modify('login', 'en'));
    }    
}