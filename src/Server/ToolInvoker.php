<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Server;

use Generator;
use Heritage\Container\Container;
use Ugarit\Mcp\Response;
use Ugarit\Mcp\ResponseFactory;
use Ugarit\Mcp\Server\Contracts\Errable;
use Ugarit\Mcp\Server\Methods\Concerns\InteractsWithResponses;
use Ugarit\Mcp\Transport\JsonRpcRequest;
use Ugarit\Mcp\Transport\JsonRpcResponse;

class ToolInvoker implements Errable
{
    use InteractsWithResponses;

    public function invoke(Tool $tool, JsonRpcRequest $request): Generator|JsonRpcResponse
    {
        // @phpstan-ignore-next-line
        $response = $this->callHandler(fn (): mixed => Container::getInstance()->call([$tool, 'handle']), $request);

        return is_iterable($response)
            ? $this->toJsonRpcStreamedResponse($request, $response, $this->serializable($tool))
            : $this->toJsonRpcResponse($request, $response, $this->serializable($tool));
    }

    protected function serializable(Tool $tool): callable
    {
        return fn (ResponseFactory $factory): array => $factory->mergeStructuredContent(
            $factory->mergeMeta([
                'content' => $factory->responses()->map(fn (Response $response): array => $response->content()->toTool($tool))->all(),
                'isError' => $factory->responses()->contains(fn (Response $response): bool => $response->isError()),
            ])
        );
    }
}
