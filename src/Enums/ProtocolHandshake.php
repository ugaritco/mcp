<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Enums;

enum ProtocolHandshake
{
    case Initialize;
    case Discovery;
}
