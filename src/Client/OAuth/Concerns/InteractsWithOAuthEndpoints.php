<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Client\OAuth\Concerns;

use Heritage\Http\Client\PendingRequest;
use Heritage\Support\Facades\Http;

trait InteractsWithOAuthEndpoints
{
    protected function oAuthRequest(): PendingRequest
    {
        return Http::acceptJson()
            ->timeout(5)
            ->connectTimeout(2)
            ->withOptions(['allow_redirects' => false]);
    }
}
