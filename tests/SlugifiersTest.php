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

namespace Tobento\Service\Slugifier\Test;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Slugifier\SlugifierFactory;
use Tobento\Service\Slugifier\Slugifiers;
use Tobento\Service\Slugifier\SlugifiersInterface;

class SlugifiersTest extends TestCase
{
    public function testThatImplementsSlugifiersInterface()
    {
        $this->assertInstanceOf(SlugifiersInterface::class, new Slugifiers());
    }

    public function testConstructor()
    {
        $slugifier = (new SlugifierFactory())->createSlugifier();
        
        $slugifiers = new Slugifiers([
            'foo' => $slugifier,
            'bar' => new SlugifierFactory(),
        ]);
        
        $this->assertSame($slugifier, $slugifiers->get('foo'));
        $this->assertFalse($slugifiers->get('bar') === $slugifiers->get('foo'));
        $this->assertFalse($slugifiers->get('bar') === $slugifiers->get('baz'));
    }
    
    public function testAddMethod()
    {
        $slugifiers = new Slugifiers();
        $slugifier = (new SlugifierFactory())->createSlugifier();
        $slugifiers->add(name: 'foo', slugifier: $slugifier);
        $slugifiers->add(name: 'bar', slugifier: new SlugifierFactory());
        
        $this->assertSame($slugifier, $slugifiers->get('foo'));
        $this->assertFalse($slugifiers->get('bar') === $slugifiers->get('foo'));
        $this->assertFalse($slugifiers->get('bar') === $slugifiers->get('baz'));
    }
    
    public function testHasMethod()
    {
        $slugifiers = new Slugifiers();
        $slugifiers->add(name: 'foo', slugifier: new SlugifierFactory());
        
        $this->assertTrue($slugifiers->has('foo'));
        $this->assertFalse($slugifiers->has('bar'));
    }
    
    public function testGetMethod()
    {
        $slugifiers = new Slugifiers();
        $slugifier = (new SlugifierFactory())->createSlugifier();
        $slugifiers->add(name: 'foo', slugifier: $slugifier);
        
        $this->assertSame($slugifier, $slugifiers->get('foo'));
        $this->assertFalse($slugifiers->get('foo') === $slugifiers->get('bar'));
    }
    
    public function testGetMethodThrowsExceptionIfInvalidSlugifierPassed()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unable to create slugifier foo as invalid type');
        
        $slugifiers = new Slugifiers([
            'foo' => 'invalid',
        ]);
        
        $slugifiers->get('foo');
    }

    public function testNamesMethod()
    {
        $this->assertSame([], (new Slugifiers())->names());
        
        $slugifiers = new Slugifiers([
            'foo' => new SlugifierFactory(),
        ]);
        
        $slugifiers->add(name: 'bar', slugifier: new SlugifierFactory());
        
        $this->assertSame(['foo', 'bar'], $slugifiers->names());
    }
}