<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Client\Methods\Tools;

use Heritage\Support\Collection;
use Heritage\Support\Facades\Log;
use Ugarit\Mcp\Client;
use Ugarit\Mcp\Client\Contracts\Method;
use Ugarit\Mcp\Client\Methods\Concerns\PaginatesList;
use Ugarit\Mcp\Client\Primitives\Tool;
use Ugarit\Mcp\Exceptions\MirroredParameterException;

/**
 * @implements Method<Collection<string, Tool>>
 */
class ListTools implements Method
{
    use PaginatesList;

    public function __construct(
        protected ?Client $client = null,
        ?string $cursor = null,
        ?int $limit = null,
    ) {
        $this->cursor = $cursor;
        $this->limit = $limit;
    }

    protected function listType(): string
    {
        return 'tools';
    }

    protected function nextPage(?string $cursor): static
    {
        return new static($this->client, $cursor, $this->limit);
    }

    /**
     * @param  array<int, array<string, mixed>>  $payloads
     * @return Collection<string, Tool>
     */
    protected function hydrate(array $payloads): Collection
    {
        $tools = [];

        foreach ($payloads as $payload) {
            try {
                $tool = Tool::from($this->client, $payload);
            } catch (MirroredParameterException $mirroredParameterException) {
                $name = is_string($payload['name'] ?? null) ? $payload['name'] : 'unknown';

                Log::warning("Excluded the MCP tool [{$name}] from the tool list because {$mirroredParameterException->getMessage()}.");

                continue;
            }

            $tools[$tool->name] = $tool;
        }

        return collect($tools);
    }
}
