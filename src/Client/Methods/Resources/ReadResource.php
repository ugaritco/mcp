<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Client\Methods\Resources;

use Ugarit\Mcp\Client\Contracts\Method;
use Ugarit\Mcp\Client\Protocol;
use Ugarit\Mcp\Client\Schema\ResourceReadResult;

/**
 * @implements Method<ResourceReadResult>
 */
class ReadResource implements Method
{
    public function __construct(
        protected string $uri,
    ) {
        //
    }

    public function method(): string
    {
        return 'resources/read';
    }

    /**
     * @return array<string, mixed>
     */
    public function params(): array
    {
        return ['uri' => $this->uri];
    }

    public function handle(Protocol $protocol): ResourceReadResult
    {
        return ResourceReadResult::from($protocol->dispatch($this));
    }
}
