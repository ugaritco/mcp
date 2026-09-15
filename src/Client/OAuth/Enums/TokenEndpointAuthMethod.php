<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Client\OAuth\Enums;

enum TokenEndpointAuthMethod: string
{
    case None = 'none';
    case ClientSecretBasic = 'client_secret_basic';
    case ClientSecretPost = 'client_secret_post';
}
