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
use Tobento\Service\Slugifier\SupportedLocales;

class SupportedLocalesTest extends TestCase
{
    public function testSupportsAllIfEmpty()
    {
        $sl = new SupportedLocales([]);
        
        $this->assertTrue($sl->supports(locale: 'en'));
        $this->assertTrue($sl->supports(locale: 'de-CH'));
        $this->assertTrue($sl->supports(locale: 'de'));
        $this->assertTrue($sl->supports(locale: 'DE'));
    }
    
    public function testSupportsUsingWildcard()
    {
        $sl = new SupportedLocales(['de*', 'en*']);
        
        $this->assertTrue($sl->supports(locale: 'de-CH'));
        $this->assertTrue($sl->supports(locale: 'de-ch'));
        $this->assertTrue($sl->supports(locale: 'de'));
        $this->assertTrue($sl->supports(locale: 'DE'));
        
        $this->assertTrue($sl->supports(locale: 'en-GB'));
        $this->assertTrue($sl->supports(locale: 'en-gb'));
        $this->assertTrue($sl->supports(locale: 'en'));
        $this->assertTrue($sl->supports(locale: 'EN'));
    }
    
    public function testSupportsUsingSpecific()
    {
        $sl = new SupportedLocales(['de-CH']);
        
        $this->assertTrue($sl->supports(locale: 'de-CH'));
        $this->assertTrue($sl->supports(locale: 'de-ch'));
        $this->assertTrue($sl->supports(locale: 'DE-CH'));
        $this->assertFalse($sl->supports(locale: 'de'));
        $this->assertFalse($sl->supports(locale: 'DE'));
    }
}