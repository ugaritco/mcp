<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Ugarit\Mcp\Request;
use Ugarit\Mcp\Response;
use Ugarit\Mcp\Server\Contracts\HasUriTemplate;
use Ugarit\Mcp\Server\Resource;
use Ugarit\Mcp\Support\UriTemplate;

class ExampleResourceTemplate extends Resource implements HasUriTemplate
{
    protected string $description = 'Example resource template for testing';

    protected string $mimeType = 'text/plain';

    public function uriTemplate(): UriTemplate
    {
        return new UriTemplate('file://example/{id}');
    }

    public function handle(Request $request): Response
    {
        $id = $request->get('id');

        return Response::text("Example resource: {$id}");
    }
}
