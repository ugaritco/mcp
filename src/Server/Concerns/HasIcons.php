<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Server\Concerns;

use Ugarit\Mcp\Schema\Icon;
use Ugarit\Mcp\Server\Attributes\Icon as IconAttribute;

trait HasIcons
{
    use ReadsAttributes;

    /**
     * @return list<Icon>
     */
    public function resolvedIcons(): array
    {
        $attributeIcons = array_map(
            fn (IconAttribute $icon): Icon => $icon->toIcon(),
            $this->resolveAttributes(IconAttribute::class),
        );

        return [...$attributeIcons, ...$this->icons()];
    }
}
