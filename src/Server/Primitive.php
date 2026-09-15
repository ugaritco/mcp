<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Server;

use Heritage\Container\Container;
use Heritage\Contracts\Support\Arrayable;
use Heritage\Support\Str;
use Ugarit\Mcp\Schema\Icon;
use Ugarit\Mcp\Server\Attributes\Description;
use Ugarit\Mcp\Server\Attributes\Name;
use Ugarit\Mcp\Server\Attributes\Title;
use Ugarit\Mcp\Server\Concerns\HasIcons;
use Ugarit\Mcp\Server\Concerns\HasMeta;

/**
 * @implements Arrayable<string, mixed>
 */
abstract class Primitive implements Arrayable
{
    use HasIcons;
    use HasMeta;

    protected string $name = '';

    protected string $title = '';

    protected string $description = '';

    public function name(): string
    {
        $attribute = $this->resolveAttribute(Name::class);

        return $attribute !== null
            ? $attribute->value
            : ($this->name !== '' ? $this->name : Str::kebab(class_basename($this)));
    }

    public function title(): string
    {
        $attribute = $this->resolveAttribute(Title::class);

        return $attribute !== null
            ? $attribute->value
            : ($this->title !== '' ? $this->title : Str::headline(class_basename($this)));
    }

    public function description(): string
    {
        $attribute = $this->resolveAttribute(Description::class);

        return $attribute !== null
            ? $attribute->value
            : ($this->description !== '' ? $this->description : Str::headline(class_basename($this)));
    }

    /**
     * @return array<string, mixed>|null
     */
    public function meta(): ?array
    {
        return $this->meta;
    }

    /**
     * @return list<Icon>
     */
    public function icons(): array
    {
        return [];
    }

    /**
     * @template T of array<string, mixed>
     *
     * @param  T  $baseArray
     * @return T&array{icons?: list<array<string, mixed>>}
     */
    protected function mergeIcons(array $baseArray): array
    {
        $icons = $this->resolvedIcons();

        if ($icons === []) {
            return $baseArray;
        }

        return [...$baseArray, 'icons' => array_map(fn (Icon $icon): array => $icon->toArray(), $icons)];
    }

    public function eligibleForRegistration(): bool
    {
        if (method_exists($this, 'shouldRegister')) {
            return Container::getInstance()->call([$this, 'shouldRegister']);
        }

        return true;
    }

    /**
     * @return array<string, mixed>
     */
    abstract public function toMethodCall(): array;

    /**
     * @return array<string, mixed>
     */
    abstract public function toArray(): array;
}
