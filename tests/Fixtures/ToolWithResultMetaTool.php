<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Heritage\Contracts\JsonSchema\JsonSchema;
use Ugarit\Mcp\Request;
use Ugarit\Mcp\Response;
use Ugarit\Mcp\ResponseFactory;
use Ugarit\Mcp\Server\Tool;

class ToolWithResultMetaTool extends Tool
{
    protected string $description = 'This tool returns a response with result-level meta';

    public function handle(Request $request): ResponseFactory
    {
        return Response::make(
            Response::text('Tool response with result meta')
        )->withMeta([
            'session_id' => 50,
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [];
    }
}
