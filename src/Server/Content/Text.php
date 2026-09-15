<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Server\Content;

use Ugarit\Mcp\Server\Concerns\HasMeta;
use Ugarit\Mcp\Server\Contracts\Content;
use Ugarit\Mcp\Server\Prompt;
use Ugarit\Mcp\Server\Resource;
use Ugarit\Mcp\Server\Tool;

class Text implements Content
{
    use HasMeta;

    public function __construct(protected string $text)
    {
        //
    }

    /**
     * @return array<string, mixed>
     */
    public function toTool(Tool $tool): array
    {
        return $this->toArray();
    }

    /**
     * @return array<string, mixed>
     */
    public function toPrompt(Prompt $prompt): array
    {
        return $this->toArray();
    }

    /**
     * @return array<string, mixed>
     */
    public function toResource(Resource $resource): array
    {
        return $this->mergeMeta([
            'text' => $this->text,
            'uri' => $resource->uri(),
            'mimeType' => $resource->mimeType(),
        ]);
    }

    public function __toString(): string
    {
        return $this->text;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->mergeMeta([
            'type' => 'text',
            'text' => $this->text,
        ]);
    }
}
