<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Ugarit\Mcp\Server;

class ExampleServer extends Server
{
    public array $tools = [
        SayHiTool::class,
        StreamingTool::class,
    ];

    public array $resources = [
        LastLogLineResource::class,
        DailyPlanResource::class,
        RecentMeetingRecordingResource::class,
    ];
}
