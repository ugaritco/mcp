<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Ugarit\Mcp\Server;

class UriTemplateTestServer extends Server
{
    protected array $resources = [
        UriTemplateSummaryResource::class,
        UriTemplateUserFileResource::class,
    ];
}
