<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Domain\Content\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model|TModel>
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words($this->faker->numberBetween(2, 5), true);

        return [
            'ulid' => Str::ulid(),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->realText(120),
        ];
    }
}
