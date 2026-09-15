<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Server\Contracts;

use Ugarit\Mcp\Server\Completions\CompletionResponse;

interface Completable
{
    /**
     * @param  array<string, mixed>  $context
     */
    public function complete(string $argument, string $value, array $context): CompletionResponse;
}
