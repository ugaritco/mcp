<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Client\Contracts;

use Ugarit\Mcp\Client\Protocol;

/**
 * @template TResult
 */
interface Method
{
    public function method(): string;

    /**
     * @return array<string, mixed>
     */
    public function params(): array;

    /**
     * @return TResult
     */
    public function handle(Protocol $protocol);
}
