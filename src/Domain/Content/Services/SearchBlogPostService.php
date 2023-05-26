<?php

namespace Domain\Content\Services;

use Domain\Content\Models\BlogPost;
use Illuminate\Database\Eloquent\Builder;

class SearchBlogPostService
{
    private int $take;

    private string $orderBy;

    private string $orderDirection;

    private string $search;

    private Builder $query;

    public function __construct($parameters)
    {
        $this->setLocalParameters($parameters);
        $this->query = BlogPost::query();
    }

    public function search()
    {
        $this->applySearch();
        $this->applyOrder();

        return $this->query->paginate($this->take);
    }

    private function setLocalParameters($parameters)
    {
        $this->take = isset($parameters['take']) ? $parameters['take'] : 15;
        $this->orderBy = isset($parameters['order_by']) ? $parameters['order_by'] : 'created_at';
        $this->orderDirection = isset($parameters['order_direction']) ? $parameters['order_direction'] : 'DESC';
        $this->search = isset($parameters['search']) ? $parameters['search'] : '';
    }

    private function applyOrder()
    {
        if (! $this->orderBy) {
            $this->query->orderBy($this->orderBy, $this->orderDirection);
        } else {
            $this->query->latest();
        }
    }

    private function applySearch()
    {
        if ($this->search !== '') {
            $search = urldecode($this->search);

            $this->query->where(function (Builder $query) use ($search) {
                $query->where('title', 'LIKE', "%$search%")
                    ->orWhere('body', 'LIKE', "%$search%");
            });
        }
    }
}
