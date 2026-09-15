<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Server\Methods;

use Generator;
use Heritage\Container\Container;
use Heritage\Contracts\Container\BindingResolutionException;
use InvalidArgumentException;
use Ugarit\Mcp\Enums\ErrorCode;
use Ugarit\Mcp\Exceptions\JsonRpcException;
use Ugarit\Mcp\Request;
use Ugarit\Mcp\Response;
use Ugarit\Mcp\ResponseFactory;
use Ugarit\Mcp\Server\AppResource;
use Ugarit\Mcp\Server\Contracts\HasUriTemplate;
use Ugarit\Mcp\Server\Contracts\Method;
use Ugarit\Mcp\Server\Methods\Concerns\InteractsWithResponses;
use Ugarit\Mcp\Server\Methods\Concerns\ResolvesResources;
use Ugarit\Mcp\Server\Resource;
use Ugarit\Mcp\Server\ServerContext;
use Ugarit\Mcp\Transport\JsonRpcRequest;
use Ugarit\Mcp\Transport\JsonRpcResponse;

class ReadResource implements Method
{
    use InteractsWithResponses;
    use ResolvesResources;

    /**
     * @return Generator<JsonRpcResponse>|JsonRpcResponse
     *
     * @throws BindingResolutionException
     */
    public function handle(JsonRpcRequest $request, ServerContext $context): Generator|JsonRpcResponse
    {
        $uri = $request->get('uri');

        try {
            $resource = $this->resolveResource($uri, $context);
        } catch (InvalidArgumentException $invalidArgumentException) {
            throw new JsonRpcException(
                $invalidArgumentException->getMessage(),
                ErrorCode::INVALID_PARAMS->value,
                $request->id,
            );
        }

        $response = $this->callHandler(fn (): mixed => $this->invokeResource($resource, $uri), $request);

        return is_iterable($response)
            ? $this->toJsonRpcStreamedResponse($request, $response, $this->serializable($resource, $uri))
            : $this->toJsonRpcResponse($request, $response, $this->serializable($resource, $uri));
    }

    /**
     * @throws BindingResolutionException
     */
    protected function invokeResource(Resource $resource, string $uri): mixed
    {
        $container = Container::getInstance();

        $request = $container->make(Request::class);
        $request->setUri($uri);

        if ($resource instanceof HasUriTemplate) {
            $variables = $resource->uriTemplate()->match($uri) ?? [];
            $request->merge($variables);
        }

        $container->instance(Request::class, $request);

        if ($resource instanceof AppResource) {
            $container->instance('mcp.library_scripts', $resource->libraryScripts());
        }

        try {
            // @phpstan-ignore-next-line
            return $container->call([$resource, 'handle']);
        } finally {
            $container->forgetInstance(Request::class);
            $container->forgetInstance('mcp.library_scripts');
        }
    }

    protected function serializable(Resource $resource, string $uri): callable
    {
        $appMeta = $resource instanceof AppResource ? $resource->resolvedAppMeta() : null;

        return fn (ResponseFactory $factory): array => $factory->mergeMeta([
            'contents' => $factory->responses()->map(function (Response $response) use ($resource, $uri, $appMeta): array {
                $content = [
                    ...$response->content()->toResource($resource),
                    'uri' => $uri,
                ];

                if ($appMeta !== null && $appMeta !== []) {
                    $content['_meta'] = array_merge($content['_meta'] ?? [], [
                        'ui' => $appMeta,
                    ]);
                }

                return $content;
            })->all(),
        ]);
    }
}
