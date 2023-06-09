<?php

declare(strict_types=1);

namespace BombenProdukt\ChangelogParser\Data;

use Spatie\LaravelData\Data;

final class Section extends Data
{
    public readonly array $items;

    public function __construct(
        public readonly string $type,
        public readonly string $content,
        public readonly ?string $description = null,
    ) {
        $this->items = \array_map(
            fn (string $item) => new SectionItem(\trim(\mb_substr($item, 1))),
            \array_filter(
                \explode("\n", $this->content),
                fn (string $item) => \str_starts_with($item, '-'),
            ),
        );
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return array<int, SectionItem>
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
