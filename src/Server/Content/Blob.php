<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Server\Content;

use InvalidArgumentException;
use Ugarit\Mcp\Server\Concerns\HasMeta;
use Ugarit\Mcp\Server\Contracts\Content;
use Ugarit\Mcp\Server\Prompt;
use Ugarit\Mcp\Server\Resource;
use Ugarit\Mcp\Server\Tool;

class Blob implements Content
{
    use HasMeta;

    public function __construct(protected string $content)
    {
        //
    }

    /**
     * @return array<string, mixed>
     */
    public function toTool(Tool $tool): array
    {
        throw new InvalidArgumentException(
            'Blob content may not be used in tools.',
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toPrompt(Prompt $prompt): array
    {
        throw new InvalidArgumentException(
            'Blob content may not be used in prompts.',
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toResource(Resource $resource): array
    {
        return $this->mergeMeta([
            'blob' => base64_encode($this->content),
            'uri' => $resource->uri(),
            'mimeType' => $resource->mimeType(),
        ]);
    }

    public function __toString(): string
    {
        return $this->content;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->mergeMeta([
            'type' => 'blob',
            'blob' => $this->content,
        ]);
    }
}
