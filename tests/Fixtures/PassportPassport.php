<?php

declare(strict_types=1);

namespace Ugarit\Passport;

class Passport
{
    public static $scopes = [];

    public static $clientModel = Client::class;

    public static function tokensCan($scopes): void
    {
        self::$scopes = $scopes;
    }

    public static function useClientModel(string $clientModel): void
    {
        static::$clientModel = $clientModel;
    }

    public static function client(): Client
    {
        return new static::$clientModel;
    }
}
