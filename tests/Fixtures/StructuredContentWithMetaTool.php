<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Heritage\Contracts\JsonSchema\JsonSchema;
use Ugarit\Mcp\Request;
use Ugarit\Mcp\Response;
use Ugarit\Mcp\ResponseFactory;
use Ugarit\Mcp\Server\Tool;

class StructuredContentWithMetaTool extends Tool
{
    protected string $description = 'This tool returns structured content with meta';

    public function handle(Request $request): ResponseFactory
    {
        return Response::structured([
            'result' => 'The operation completed successfully',
        ])->withMeta(['requestId' => 'abc123']);
    }

    public function schema(JsonSchema $schema): array
    {
        return [];
    }
}
