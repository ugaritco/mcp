<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Server\Methods;

use Generator;
use Heritage\Container\Container;
use InvalidArgumentException;
use Ugarit\Mcp\Exceptions\JsonRpcException;
use Ugarit\Mcp\Response;
use Ugarit\Mcp\ResponseFactory;
use Ugarit\Mcp\Server\Contracts\Method;
use Ugarit\Mcp\Server\Methods\Concerns\InteractsWithResponses;
use Ugarit\Mcp\Server\Methods\Concerns\ResolvesPrompts;
use Ugarit\Mcp\Server\Prompt;
use Ugarit\Mcp\Server\ServerContext;
use Ugarit\Mcp\Transport\JsonRpcRequest;
use Ugarit\Mcp\Transport\JsonRpcResponse;

class GetPrompt implements Method
{
    use InteractsWithResponses;
    use ResolvesPrompts;

    /**
     * @return Generator<JsonRpcResponse>|JsonRpcResponse
     */
    public function handle(JsonRpcRequest $request, ServerContext $context): Generator|JsonRpcResponse
    {
        try {
            $prompt = $this->resolvePrompt($request->get('name'), $context);
        } catch (InvalidArgumentException $invalidArgumentException) {
            throw new JsonRpcException($invalidArgumentException->getMessage(), -32602, $request->id);
        }

        // @phpstan-ignore-next-line
        $response = $this->callHandler(fn (): mixed => Container::getInstance()->call([$prompt, 'handle']), $request);

        return is_iterable($response)
            ? $this->toJsonRpcStreamedResponse($request, $response, $this->serializable($prompt))
            : $this->toJsonRpcResponse($request, $response, $this->serializable($prompt));
    }

    /**
     * @return callable(ResponseFactory): array<string, mixed>
     */
    protected function serializable(Prompt $prompt): callable
    {
        return fn (ResponseFactory $factory): array => $factory->mergeMeta([
            'description' => $prompt->description(),
            'messages' => $factory->responses()->map(fn (Response $response): array => [
                'role' => $response->role()->value,
                'content' => $response->content()->toPrompt($prompt),
            ])->all(),
        ]);
    }
}
