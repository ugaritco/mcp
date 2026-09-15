<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Generator;
use Heritage\Contracts\JsonSchema\JsonSchema;
use Ugarit\Mcp\Request;
use Ugarit\Mcp\Response;
use Ugarit\Mcp\Server\Tool;

class StreamingTool extends Tool
{
    protected string $description = 'A tool that streams multiple responses.';

    public function schema(JsonSchema $schema): array
    {
        return [
            'count' => $schema->integer()
                ->description('Number of messages to stream.')
                ->required(),
        ];
    }

    public function handle(Request $request): Generator
    {
        $count = $request->integer('count', 2);

        for ($i = 1; $i <= $count; $i++) {
            yield Response::notification('stream/progress', ['progress' => $i / $count * 100, 'message' => "Processing item {$i} of {$count}"]);
        }

        yield Response::text("Finished streaming {$count} messages.");
    }
}
