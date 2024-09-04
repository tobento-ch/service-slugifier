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

namespace Tobento\Service\Slugifier\Test\Resource;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Slugifier\ResourceInterface;
use Tobento\Service\Slugifier\Resource\ArrayResource;

class ArrayResourceTest extends TestCase
{
    public function testThatImplementsResourceInterface()
    {
        $this->assertInstanceOf(ResourceInterface::class, new ArrayResource([]));
    }

    public function testKeyMethod()
    {
        $this->assertSame(null, (new ArrayResource(slugs: []))->key());
        $this->assertSame('foo', (new ArrayResource(slugs: [], key: 'foo'))->key());
    }
    
    public function testPriorityMethod()
    {
        $this->assertSame(1000, (new ArrayResource(slugs: []))->priority());
        $this->assertSame(10, (new ArrayResource(slugs: [], priority: 10))->priority());
    }
    
    public function testSlugExistsMethod()
    {
        $r = new ArrayResource(slugs: ['foo']);
        
        $this->assertTrue($r->slugExists(slug: 'foo', locale: 'en'));
        $this->assertTrue($r->slugExists(slug: 'foo', locale: 'de'));
        $this->assertTrue($r->slugExists(slug: 'foo', locale: 'de-CH'));
        $this->assertFalse($r->slugExists(slug: 'bar', locale: 'en'));
        $this->assertFalse($r->slugExists(slug: 'bar', locale: 'de'));
    }
    
    public function testSlugExistsMethodWithSuportedLocales()
    {
        $r = new ArrayResource(slugs: ['foo'], supportedLocales: ['de*', 'en-GB']);
        
        $this->assertTrue($r->slugExists(slug: 'foo', locale: 'de'));
        $this->assertTrue($r->slugExists(slug: 'foo', locale: 'de-CH'));
        $this->assertFalse($r->slugExists(slug: 'foo', locale: 'en'));
        $this->assertTrue($r->slugExists(slug: 'foo', locale: 'en-GB'));
    }
    
    public function testFindSlugMethod()
    {
        $r = new ArrayResource(slugs: ['foo']);
        $slug = $r->findSlug(slug: 'foo', locale: 'en');
        
        $this->assertSame('foo', $slug?->slug());
        $this->assertSame('en', $slug?->locale());
        $this->assertSame(null, $slug?->resourceKey());
        $this->assertSame(null, $slug?->resourceId());
        
        $this->assertNotNull($r->findSlug(slug: 'foo', locale: 'de'));
        $this->assertNotNull($r->findSlug(slug: 'foo', locale: 'de-CH'));
        $this->assertNotNull($r->findSlug(slug: 'foo', locale: 'en'));
        $this->assertNull($r->findSlug(slug: 'bar', locale: 'en'));
    }
    
    public function AtestFindSlugMethodWithSuportedLocales()
    {
        $r = new ArrayResource(slugs: ['foo'], supportedLocales: ['de*', 'en-GB']);

        $this->assertNotNull($r->findSlug(slug: 'foo', locale: 'de'));
        $this->assertNotNull($r->findSlug(slug: 'foo', locale: 'de-CH'));
        $this->assertNull($r->findSlug(slug: 'foo', locale: 'en'));
        $this->assertNotNull($r->findSlug(slug: 'bar', locale: 'en-GB'));
    }
}