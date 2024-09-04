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
use Tobento\Service\Slugifier\Resource\ArrayResource;
use Tobento\Service\Slugifier\ResourceInterface;
use Tobento\Service\Slugifier\Slug;
use Tobento\Service\Slugifier\SlugInterface;
use Tobento\Service\Slugifier\Slugs;
use Tobento\Service\Slugifier\SlugsInterface;

class SlugsTest extends TestCase
{
    public function testThatImplementsSlugsInterface()
    {
        $this->assertInstanceOf(SlugsInterface::class, new Slugs());
    }

    public function testConstructor()
    {
        $slugs = new Slugs(
            new ArrayResource(['login']),
        );
        
        $this->assertTrue($slugs->exists('login'));
    }
    
    public function testAddResourceMethod()
    {
        $slugs = new Slugs();
        $slugs->addResource(resource: new ArrayResource(['login']));
        
        $this->assertTrue($slugs->exists('login'));
    }
    
    public function testExistsMethod()
    {
        $slugs = new Slugs(
            new ArrayResource(slugs: ['anmelden'], supportedLocales: ['de']),
        );
        
        $slugs->addResource(resource: new ArrayResource(['login']));
        
        $this->assertTrue($slugs->exists('login'));
        $this->assertTrue($slugs->exists('login', 'de'));
        $this->assertFalse($slugs->exists('anmelden'));
        $this->assertTrue($slugs->exists('anmelden', 'de'));
    }
    
    public function testExistsMethodPriorityHighestFirst()
    {
        $src1 = new ResourcePriority(slugs: ['login'], priority: 10);
        $src2 = new ResourcePriority(slugs: ['login'], priority: 20);
        $src3 = new ResourcePriority(slugs: ['login'], priority: 30);
        
        $slugs = new Slugs($src1, $src3, $src2);
        
        $slugs->exists('login');
        
        $this->assertSame(0, $src1->usage);
        $this->assertSame(0, $src2->usage);
        $this->assertSame(1, $src3->usage);
    }
    
    public function testExistsMethodCachesSlugs()
    {
        $src = new ResourcePriority(slugs: ['login'], priority: 10);
        
        $slugs = new Slugs($src);
        
        $this->assertSame(0, $src->usage);
        
        $slugs->exists('login');
        $slugs->exists('login');
        
        $this->assertSame(1, $src->usage);
    }
    
    public function testFindSlugMethod()
    {
        $slugs = new Slugs(
            new ArrayResource(slugs: ['anmelden'], supportedLocales: ['de']),
        );
        
        $slugs->addResource(resource: new ArrayResource(['login']));
        
        $this->assertNotNull($slugs->findSlug('login'));
        $this->assertNotNull($slugs->findSlug('login', 'de'));
        $this->assertNull($slugs->findSlug('anmelden'));
        $this->assertNotNull($slugs->findSlug('anmelden', 'de'));
    }
    
    public function testFindSlugMethodPriorityHighestFirst()
    {
        $src1 = new ResourcePriority(slugs: ['login'], priority: 10);
        $src2 = new ResourcePriority(slugs: ['login'], priority: 20);
        $src3 = new ResourcePriority(slugs: ['login'], priority: 30);
        
        $slugs = new Slugs($src1, $src3, $src2);
        
        $slugs->findSlug('login');
        
        $this->assertSame(0, $src1->usage);
        $this->assertSame(0, $src2->usage);
        $this->assertSame(1, $src3->usage);
    }
    
    public function testSlugFindMethodCachesSlugs()
    {
        $src = new ResourcePriority(slugs: ['login'], priority: 10);
        
        $slugs = new Slugs($src);
        
        $this->assertSame(0, $src->usage);
        
        $slugs->findSlug('login');
        $slugs->findSlug('login');
        
        $this->assertSame(1, $src->usage);
    }
    
    public function testSlugFindWithExistsMethod()
    {
        $src = new ResourcePriority(slugs: ['login'], priority: 10);
        
        $slugs = new Slugs($src);
        
        $this->assertSame(0, $src->usage);
        
        $slugs->exists('login');
        $slugs->findSlug('login');
        $slugs->exists('login');
        $slugs->findSlug('login');
        
        $this->assertSame(2, $src->usage);
    }
}

class ResourcePriority implements ResourceInterface
{
    public function __construct(
        protected array $slugs = [],
        protected int $priority,
        public int $usage = 0,
    ) {}

    public function slugExists(string $slug, string $locale = 'en'): bool
    {
        $this->usage++;
        return in_array($slug, $this->slugs);
    }
    
    public function findSlug(string $slug, string $locale = 'en'): null|SlugInterface
    {
        if (! $this->slugExists($slug, $locale)) {
            return null;
        }
        
        return new Slug(slug: $slug, locale: $locale, resourceKey: $this->key());
    }
    
    public function key(): null|string
    {
        return null;
    }

    public function priority(): int
    {
        return $this->priority;
    }
}