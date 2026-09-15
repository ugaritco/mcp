<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Server\Contracts;

use Ugarit\Mcp\Support\UriTemplate;

interface HasUriTemplate
{
    /**
     * Get the URI pattern for the resource template.
     */
    public function uriTemplate(): UriTemplate;
}
