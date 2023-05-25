<?php

namespace Domain\Content\Resources;

use TiMacDonald\JsonApi\JsonApiResource;

class BlogPostResource extends JsonApiResource
{
    /**
     * @var string[]
     */
    public $attributes = [
        'title',
        'slug',
        'author',
        'date',
        'body',
        'likes',
        'status',
    ];
}
