<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Server\Methods;

use Ugarit\Mcp\Enums\ProtocolVersion;
use Ugarit\Mcp\Server\Contracts\Method;
use Ugarit\Mcp\Server\ServerContext;
use Ugarit\Mcp\Transport\JsonRpcRequest;
use Ugarit\Mcp\Transport\JsonRpcResponse;

class Initialize implements Method
{
    public function handle(JsonRpcRequest $request, ServerContext $context): JsonRpcResponse
    {
        $requested = $request->params['protocolVersion'] ?? null;

        return JsonRpcResponse::result($request->id, [
            'protocolVersion' => in_array($requested, ProtocolVersion::initializeSupported(), true)
                ? $requested
                : ProtocolVersion::initializeSupported()[0],
            'capabilities' => $context->serverCapabilities ?: (object) [],
            'serverInfo' => $context->implementation->toArray(),
            'instructions' => $context->instructions,
        ]);
    }
}
