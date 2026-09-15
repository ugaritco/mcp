<?php

declare(strict_types=1);

namespace Tests\Conformance\Tools;

use Ugarit\Mcp\Request;
use Ugarit\Mcp\Response;
use Ugarit\Mcp\Server\Tool;

class EmbeddedResourceTool extends Tool
{
    protected string $name = 'test_embedded_resource';

    protected string $description = 'Tests embedded resource content response';

    public function handle(Request $request): Response
    {
        return Response::resourceLink(
            uri: 'test://embedded-resource',
            name: 'embedded-resource',
            mimeType: 'text/plain',
            description: 'This is an embedded resource content.',
        );
    }
}
