<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Client\Methods\Tools;

use Ugarit\Mcp\Client\Contracts\Method;
use Ugarit\Mcp\Client\Contracts\MirrorsParameters;
use Ugarit\Mcp\Client\Protocol;
use Ugarit\Mcp\Client\Schema\ToolResult;
use Ugarit\Mcp\Support\MirroredParameters;

/**
 * @implements Method<ToolResult>
 */
class CallTool implements Method, MirrorsParameters
{
    /**
     * @param  array<string, mixed>  $arguments
     */
    public function __construct(
        protected string $name,
        protected array $arguments = [],
        protected ?MirroredParameters $mirroredParameters = null,
    ) {
        //
    }

    /**
     * @return array<string, string>
     */
    public function requestHeaders(): array
    {
        return $this->mirroredParameters?->headers($this->arguments) ?? [];
    }

    public function method(): string
    {
        return 'tools/call';
    }

    /**
     * @return array<string, mixed>
     */
    public function params(): array
    {
        return [
            'name' => $this->name,
            'arguments' => (object) $this->arguments,
        ];
    }

    public function handle(Protocol $protocol): ToolResult
    {
        return ToolResult::from($protocol->dispatch($this));
    }
}
