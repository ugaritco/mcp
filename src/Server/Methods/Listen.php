<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Server\Methods;

use Generator;
use Ugarit\Mcp\Enums\MetaKey;
use Ugarit\Mcp\Server\Contracts\Method;
use Ugarit\Mcp\Server\ServerContext;
use Ugarit\Mcp\Transport\JsonRpcRequest;
use Ugarit\Mcp\Transport\JsonRpcResponse;

class Listen implements Method
{
    /**
     * @return Generator<int, JsonRpcResponse>
     */
    public function handle(JsonRpcRequest $request, ServerContext $context): Generator
    {
        yield JsonRpcResponse::notification('notifications/subscriptions/acknowledged', [
            '_meta' => [MetaKey::SUBSCRIPTION_ID->value => $request->id],
            'notifications' => (object) [],
        ]);

        yield JsonRpcResponse::result($request->id, [
            '_meta' => [MetaKey::SUBSCRIPTION_ID->value => $request->id],
        ]);
    }
}
