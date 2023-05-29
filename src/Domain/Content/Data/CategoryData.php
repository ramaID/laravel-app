<?php

namespace Domain\Content\Data;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;

class CategoryData extends Data
{
    public function __construct(
        public string $name,
        public ?string $slug,
        public ?string $description,
        public ?Carbon $created_at,
        public ?Carbon $updated_at,
    ) {
    }
}
