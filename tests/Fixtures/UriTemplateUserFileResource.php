<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Ugarit\Mcp\Request;
use Ugarit\Mcp\Response;
use Ugarit\Mcp\Server\Contracts\HasUriTemplate;
use Ugarit\Mcp\Server\Resource;
use Ugarit\Mcp\Support\UriTemplate;

class UriTemplateUserFileResource extends Resource implements HasUriTemplate
{
    public function uriTemplate(): UriTemplate
    {
        return new UriTemplate('file://users/{userId}/files/{fileId}');
    }

    public function handle(Request $request): Response
    {
        return Response::json([
            'userId' => $request->get('userId'),
            'fileId' => $request->get('fileId'),
            'uri' => $request->uri(),
        ]);
    }
}
