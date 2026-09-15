<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Heritage\Contracts\JsonSchema\JsonSchema;
use Ugarit\Mcp\Request;
use Ugarit\Mcp\Response;
use Ugarit\Mcp\Server\Tool;

class SayHiTwiceTool extends Tool
{
    protected string $description = 'This tool says hello to a person twice';

    public function handle(Request $request): array
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $name = $request->get('name');

        return [
            Response::text('Hello, '.$name.'!'),
            Response::text('Hello again, '.$name.'!'),
        ];
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'name' => $schema->string()
                ->description('The name of the person to greet')
                ->required(),
        ];
    }
}
