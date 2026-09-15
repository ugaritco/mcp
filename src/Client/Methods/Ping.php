<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Client\Methods;

use Ugarit\Mcp\Client\Contracts\Method;
use Ugarit\Mcp\Client\Protocol;

/**
 * @implements Method<void>
 */
class Ping implements Method
{
    public function method(): string
    {
        return 'ping';
    }

    /**
     * @return array<string, mixed>
     */
    public function params(): array
    {
        return [];
    }

    public function handle(Protocol $protocol): void
    {
        $protocol->dispatch($this);
    }
}
