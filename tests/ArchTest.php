<?php

use Heritage\Console\Command;
use Ugarit\Mcp\Server\Contracts\Annotation;
use Ugarit\Mcp\Server\Contracts\Method;
use Ugarit\Mcp\Server\Testing\TestListResponse;
use Ugarit\Mcp\Server\Testing\TestResponse;
use Symfony\Component\Console\Attribute\AsCommand;

arch('strict and safe')
    ->expect('Ugarit\Mcp')
    ->toUseStrictTypes()
    ->not->toUse(['die', 'dd', 'dump', 'var_dump'])
    ->ignoring([TestResponse::class, TestListResponse::class]);

arch('mcp methods extend base class')
    ->expect('Ugarit\Mcp\Server\Methods')
    ->toImplement([Method::class])
    ->ignoring('Ugarit\Mcp\Server\Methods\Concerns');

arch('tool annotations implement annotation interface')
    ->expect('Ugarit\Mcp\Server\Tools\Annotations')
    ->toOnlyImplement(Annotation::class);

arch('resource annotations implement annotation interface')
    ->expect('Ugarit\Mcp\Server\Annotations')
    ->toOnlyImplement(Annotation::class);

arch('contracts are interfaces')
    ->expect('Ugarit\Mcp\Server\Contracts')
    ->toBeInterfaces();

arch('exceptions extend')
    ->expect('Ugarit\Mcp\Server\Exceptions')
    ->toExtend(Exception::class);

arch('commands extend command')
    ->expect('Ugarit\Mcp\Console\Commands')
    ->toExtend(Command::class)
    ->toHaveAttribute(attribute: AsCommand::class);
