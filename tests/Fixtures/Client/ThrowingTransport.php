<?php

declare(strict_types=1);

namespace Tests\Fixtures\Client;

use Ugarit\Mcp\Exceptions\ClientException;

class ThrowingTransport extends FakeTransport
{
    public function disconnect(): never
    {
        throw new ClientException('disconnect failed');
    }
}
