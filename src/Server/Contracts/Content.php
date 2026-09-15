<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Server\Contracts;

use Heritage\Contracts\Support\Arrayable;
use Ugarit\Mcp\Server\Prompt;
use Ugarit\Mcp\Server\Resource;
use Ugarit\Mcp\Server\Tool;
use Stringable;

/**
 * @extends Arrayable<string, mixed>
 */
interface Content extends Arrayable, Stringable
{
    /**
     * @return array<string, mixed>
     */
    public function toTool(Tool $tool): array;

    /**
     * @return array<string, mixed>
     */
    public function toPrompt(Prompt $prompt): array;

    /**
     * @return array<string, mixed>
     */
    public function toResource(Resource $resource): array;

    /**
     * @param  array<string, mixed>|string  $meta
     */
    public function setMeta(array|string $meta, mixed $value = null): void;

    public function __toString(): string;
}
