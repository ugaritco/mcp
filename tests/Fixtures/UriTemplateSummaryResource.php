<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Ugarit\Mcp\Request;
use Ugarit\Mcp\Response;
use Ugarit\Mcp\Server\Contracts\HasUriTemplate;
use Ugarit\Mcp\Server\Resource;
use Ugarit\Mcp\Support\UriTemplate;

class UriTemplateSummaryResource extends Resource implements HasUriTemplate
{
    public function uriTemplate(): UriTemplate
    {
        return new UriTemplate('file://summary/{id}');
    }

    public function handle(Request $request): Response
    {
        $request->validate(['id' => 'required|string']);

        return Response::json([
            'id' => $request->get('id'),
            'uri' => $request->uri(),
        ]);
    }
}
