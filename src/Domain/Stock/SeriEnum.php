<?php

namespace Domain\Stock;

enum SeriEnum: string
{
    case A = 'A';
    case B = 'B';
    case C = 'C';

    public function color(): string
    {
        return match ($this) {
            SeriEnum::A => 'grey',
            SeriEnum::B => 'green',
            SeriEnum::C => 'red',
        };
    }

    /**
     * @return array<string>
     */
    public static function keys(): array
    {
        return array_column(static::cases(), 'name');
    }
}
