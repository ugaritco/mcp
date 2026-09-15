<?php

declare(strict_types=1);

use Ugarit\Mcp\Server\Registrar;

beforeEach(function (): void {
    $this->registrar = Mockery::mock(Registrar::class);
    $this->app->instance(Registrar::class, $this->registrar);
});

it('starts a registered local server successfully', function (): void {
    $serverCalled = false;
    $server = function () use (&$serverCalled): void {
        $serverCalled = true;
    };

    $this->registrar
        ->shouldReceive('getLocalServer')
        ->with('demo')
        ->andReturn($server);

    $this->scribe('mcp:start', ['handle' => 'demo'])
        ->assertExitCode(0);

    expect($serverCalled)->toBeTrue();
});

it('fails when server handle is not found', function (): void {
    $this->registrar
        ->shouldReceive('getLocalServer')
        ->with('invalid')
        ->andReturn(null);

    $this->scribe('mcp:start', ['handle' => 'invalid'])
        ->expectsOutputToContain('MCP Server with name [invalid] not found. Did you register it using [Mcp::local()]?')
        ->assertExitCode(1);
});

it('requires handle argument', function (): void {
    expect(function (): void {
        $this->scribe('mcp:start');
    })->toThrow(RuntimeException::class, 'Not enough arguments (missing: "handle")');
});

it('asserts handle is a string', function (): void {
    $server = function (): void {};

    $this->registrar
        ->shouldReceive('getLocalServer')
        ->with('test-handle')
        ->andReturn($server);

    // This test ensures the assert(is_string($handle)) works correctly
    $this->scribe('mcp:start', ['handle' => 'test-handle'])
        ->assertExitCode(0);
});
