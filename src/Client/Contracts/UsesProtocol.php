<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Client\Contracts;

use Ugarit\Mcp\Enums\ProtocolVersion;

interface UsesProtocol
{
    public function useProtocol(ProtocolVersion $protocolVersion): void;
}
