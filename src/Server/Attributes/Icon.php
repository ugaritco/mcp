<?php

declare(strict_types=1);

namespace Ugarit\Mcp\Server\Attributes;

use Attribute;
use Ugarit\Mcp\Enums\IconTheme;
use Ugarit\Mcp\Schema\Icon as IconValue;

#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class Icon
{
    /**
     * @param  list<string>  $sizes
     */
    public function __construct(
        public string $src,
        public ?string $mimeType = null,
        public array $sizes = [],
        public ?IconTheme $theme = null,
    ) {}

    public function toIcon(): IconValue
    {
        return IconValue::from($this->src, $this->mimeType, $this->sizes, $this->theme);
    }
}
