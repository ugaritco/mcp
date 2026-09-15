<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Server\Attributes;

abstract class ServerAttribute
{
    public function __construct(public string $value) {}
}
