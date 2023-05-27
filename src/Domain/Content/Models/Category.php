<?php

namespace Domain\Content\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, HasUlids;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ulid';

    protected static function boot(): void
    {
        parent::boot();

        self::creating(function (Category $cat) {
            if (! $cat->slug) {
                $cat->slug = Str::slug($cat->name);
            }
        });

        self::updating(function (Category $cat) {
            if (! $cat->slug) {
                $cat->slug = Str::slug($cat->name);
            }
        });
    }

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function blogPosts(): HasMany
    {
        return $this->hasMany(BlogPost::class, 'category_id', 'id');
    }
}
