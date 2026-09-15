<?php

declare(strict_types=1);

use Ugarit\Mcp\Enums\Role;
use Ugarit\Mcp\Request;
use Ugarit\Mcp\Response;
use Ugarit\Mcp\Server\Annotations\Audience;
use Ugarit\Mcp\Server\Annotations\Priority;
use Ugarit\Mcp\Server\Tool;
use Ugarit\Mcp\Server\Tools\Annotations\IsIdempotent;
use Ugarit\Mcp\Server\Tools\Annotations\IsReadOnly;

it('accepts valid tool annotations', function (): void {
    $tool = new #[IsReadOnly] class extends Tool
    {
        public function handle(Request $request): Response
        {
            return Response::text('test');
        }
    };

    $annotations = $tool->annotations();

    expect($annotations)->toHaveKey('readOnlyHint')
        ->and($annotations['readOnlyHint'])->toBeTrue();
});

it('rejects resource annotations on tools', function (): void {
    expect(function (): void {
        $tool = new #[Audience(Role::Assistant)] class extends Tool
        {
            public function handle(Request $request): Response
            {
                return Response::text('test');
            }
        };

        $tool->annotations();
    })->toThrow(InvalidArgumentException::class, 'Annotation [Ugarit\Mcp\Server\Annotations\Audience] cannot be used on');
});

it('rejects priority annotation on tools', function (): void {
    expect(function (): void {
        $tool = new #[Priority(0.8)] class extends Tool
        {
            public function handle(Request $request): Response
            {
                return Response::text('test');
            }
        };

        $tool->annotations();
    })->toThrow(InvalidArgumentException::class, 'Annotation [Ugarit\Mcp\Server\Annotations\Priority] cannot be used on');
});

it('accepts multiple tool annotations', function (): void {
    $tool = new #[IsReadOnly]
    #[IsIdempotent] class extends Tool
    {
        public function handle(Request $request): Response
        {
            return Response::text('test');
        }
    };

    $annotations = $tool->annotations();

    expect($annotations)->toHaveKey('readOnlyHint')
        ->and($annotations)->toHaveKey('idempotentHint')
        ->and($annotations['readOnlyHint'])->toBeTrue()
        ->and($annotations['idempotentHint'])->toBeTrue();
});
