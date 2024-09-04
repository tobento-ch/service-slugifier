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

namespace Tobento\Service\Slugifier;

interface SlugifierFactoryInterface
{
    /**
     * Create a slugifier.
     *
     * @return SlugifierInterface
     */
    public function createSlugifier(): SlugifierInterface;
}