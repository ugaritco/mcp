<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Server\Methods;

use Ugarit\Mcp\Server\Contracts\Method;
use Ugarit\Mcp\Server\ServerContext;
use Ugarit\Mcp\Transport\JsonRpcRequest;
use Ugarit\Mcp\Transport\JsonRpcResponse;

class Ping implements Method
{
    public function handle(JsonRpcRequest $request, ServerContext $context): JsonRpcResponse
    {
        return JsonRpcResponse::result($request->id, []);
    }
}
