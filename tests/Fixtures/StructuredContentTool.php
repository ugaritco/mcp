<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Heritage\Contracts\JsonSchema\JsonSchema;
use Ugarit\Mcp\Request;
use Ugarit\Mcp\Response;
use Ugarit\Mcp\ResponseFactory;
use Ugarit\Mcp\Server\Tool;

class StructuredContentTool extends Tool
{
    protected string $description = 'This tool returns structured content';

    public function handle(Request $request): ResponseFactory
    {
        return Response::structured([
            'temperature' => 22.5,
            'conditions' => 'Partly cloudy',
            'humidity' => 65,
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [];
    }
}
