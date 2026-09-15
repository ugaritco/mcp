<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Ugarit\Mcp\Server\Contracts\Method;
use Ugarit\Mcp\Server\ServerContext;
use Ugarit\Mcp\Transport\JsonRpcRequest;
use Ugarit\Mcp\Transport\JsonRpcResponse;

class CustomMethodHandler implements Method
{
    public function __construct()
    {
        //
    }

    public function handle(JsonRpcRequest $request, ServerContext $context): JsonRpcResponse
    {
        return JsonRpcResponse::result($request->id, ['message' => 'Custom method executed successfully!']);
    }
}
