<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Heritage\Contracts\JsonSchema\JsonSchema;
use Ugarit\Mcp\Request;
use Ugarit\Mcp\Response;
use Ugarit\Mcp\ResponseFactory;
use Ugarit\Mcp\Server\Tool;

class ToolWithBothMetaTool extends Tool
{
    protected string $description = 'This tool returns a response with both content-level and result-level meta';

    public function handle(Request $request): ResponseFactory
    {
        return Response::make([
            Response::text('First response')->withMeta(['content_index' => 1]),
            Response::text('Second response')->withMeta(['content_index' => 2]),
        ])->withMeta([
            'result_key' => 'result_value',
            'total_responses' => 2,
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [];
    }
}
