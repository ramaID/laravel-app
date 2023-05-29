<?php

namespace Domain\Content\Data\Casts;

use Illuminate\Support\Str;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class SlugDataCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): string
    {
        return Str::slug($value);
    }
}
