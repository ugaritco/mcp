<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Server\Methods;

use Ugarit\Mcp\Server\Contracts\Method;
use Ugarit\Mcp\Server\Pagination\CursorPaginator;
use Ugarit\Mcp\Server\ServerContext;
use Ugarit\Mcp\Transport\JsonRpcRequest;
use Ugarit\Mcp\Transport\JsonRpcResponse;

class ListPrompts implements Method
{
    public function handle(JsonRpcRequest $request, ServerContext $context): JsonRpcResponse
    {
        $paginator = new CursorPaginator(
            items: $context->prompts(),
            perPage: $context->perPage($request->get('per_page')),
            cursor: $request->cursor(),
        );

        return JsonRpcResponse::result($request->id, $paginator->paginate('prompts'));
    }
}
