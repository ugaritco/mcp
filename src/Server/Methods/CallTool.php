<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Server\Methods;

use Generator;
use Ugarit\Mcp\Exceptions\JsonRpcException;
use Ugarit\Mcp\Server\Contracts\Errable;
use Ugarit\Mcp\Server\Contracts\Method;
use Ugarit\Mcp\Server\ServerContext;
use Ugarit\Mcp\Server\ToolInvoker;
use Ugarit\Mcp\Transport\JsonRpcRequest;
use Ugarit\Mcp\Transport\JsonRpcResponse;

class CallTool implements Errable, Method
{
    /**
     * @return JsonRpcResponse|Generator<JsonRpcResponse>
     *
     * @throws JsonRpcException
     */
    public function handle(JsonRpcRequest $request, ServerContext $context): Generator|JsonRpcResponse
    {
        if (is_null($request->get('name'))) {
            throw new JsonRpcException(
                'Missing [name] parameter.',
                -32602,
                $request->id,
            );
        }

        $tool = $context
            ->tools()
            ->first(
                fn ($tool): bool => $tool->name() === $request->params['name'],
                fn () => throw new JsonRpcException(
                    "Tool [{$request->params['name']}] not found.",
                    -32602,
                    $request->id,
                ));

        return (new ToolInvoker)->invoke($tool, $request);
    }
}
