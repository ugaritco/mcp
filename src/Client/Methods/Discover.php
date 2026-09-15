<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Client\Methods;

use Ugarit\Mcp\Client\Contracts\Method;
use Ugarit\Mcp\Client\Protocol;
use Ugarit\Mcp\Client\Schema\DiscoverResult;

/**
 * @implements Method<DiscoverResult>
 */
class Discover implements Method
{
    public function method(): string
    {
        return 'server/discover';
    }

    /**
     * @return array<string, mixed>
     */
    public function params(): array
    {
        return [];
    }

    public function handle(Protocol $protocol): DiscoverResult
    {
        return DiscoverResult::from($protocol->dispatch($this));
    }
}
