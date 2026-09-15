<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Ugarit\Mcp\Enums\Role;
use Ugarit\Mcp\Server\Annotations\Audience;
use Ugarit\Mcp\Server\Annotations\LastModified;
use Ugarit\Mcp\Server\Annotations\Priority;
use Ugarit\Mcp\Server\Resource;

#[Audience([Role::User])]
#[Priority(0.7)]
#[LastModified('2026-05-01T00:00:00Z')]
class AnnotatedResource extends Resource
{
    protected string $uri = 'file://resources/annotated';

    protected string $mimeType = 'text/plain';

    public function handle(): string
    {
        return 'annotated content';
    }
}
