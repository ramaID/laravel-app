<?php

namespace Domain\Content\Resources;

use TiMacDonald\JsonApi\JsonApiResource;

class CategoryResource extends JsonApiResource
{
    /**
     * @var string[]
     */
    public $attributes = [
        'name',
        'slug',
        'description',
        'blog_posts_count',
    ];
}
