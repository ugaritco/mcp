<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Ugarit\Mcp\Enums\CacheScope;
use Ugarit\Mcp\Server\Attributes\Cacheable;
use Ugarit\Mcp\Server\Resource;

#[Cacheable(ttlMs: 120000, scope: CacheScope::Public)]
class CacheableResource extends Resource
{
    public function description(): string
    {
        return 'A resource that declares its own caching hint';
    }

    public function handle(): string
    {
        return 'Cacheable contents.';
    }
}
