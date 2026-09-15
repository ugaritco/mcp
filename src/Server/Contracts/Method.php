<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Server\Contracts;

use Ugarit\Mcp\Exceptions\JsonRpcException;
use Ugarit\Mcp\Server\ServerContext;
use Ugarit\Mcp\Transport\JsonRpcRequest;
use Ugarit\Mcp\Transport\JsonRpcResponse;

interface Method
{
    /**
     * @return iterable<JsonRpcResponse>|JsonRpcResponse
     *
     * @throws JsonRpcException
     */
    public function handle(JsonRpcRequest $request, ServerContext $context): iterable|JsonRpcResponse;
}
