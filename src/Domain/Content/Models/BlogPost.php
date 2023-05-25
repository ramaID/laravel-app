<?php

namespace Domain\Content\Models;

use Database\Factories\BlogPostFactory;
use Domain\Content\Enums\BlogPostStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property string $ulid
 * @property string $title
 * @property string $slug
 * @property string $author
 * @property string $date
 * @property string $body
 */
class BlogPost extends Model
{
    use HasFactory, HasUlids;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ulid';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'datetime',
        'likes' => 'integer',
        'status' => BlogPostStatus::class,
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): BlogPostFactory
    {
        return BlogPostFactory::new();
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(function (BlogPost $post) {
            if (! $post->slug) {
                $post->slug = Str::slug($post->title);
            }
        });
    }
}
