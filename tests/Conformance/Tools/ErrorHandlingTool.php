<?php

declare(strict_types=1);

namespace Tests\Conformance\Tools;

use Ugarit\Mcp\Request;
use Ugarit\Mcp\Response;
use Ugarit\Mcp\Server\Tool;

class ErrorHandlingTool extends Tool
{
    protected string $name = 'test_error_handling';

    protected string $description = 'Tests error response handling';

    public function handle(Request $request): Response
    {
        return Response::error('This tool intentionally returns an error for testing');
    }
}
