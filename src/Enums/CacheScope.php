<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Enums;

enum CacheScope: string
{
    case Public = 'public';
    case Private = 'private';
}
