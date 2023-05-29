<?php

namespace Domain\Content\Services;

use Domain\Content\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchCategoryService
{
    private int $take;

    private string $orderBy;

    private string $orderDirection;

    private string $search;

    /**
     * @var Builder<Category>
     */
    private Builder $query;

    /**
     * @param  array<string, string|int>  $parameters
     */
    public function __construct(array $parameters)
    {
        $this->setLocalParameters($parameters);
        $this->query = Category::query();
    }

    /**
     * @return LengthAwarePaginator<Category>
     */
    public function search(): LengthAwarePaginator
    {
        $this->applySearch();
        $this->applyOrder();

        return $this->query->paginate($this->take);
    }

    /**
     * @param  array<string, string|int>  $parameters
     */
    private function setLocalParameters(array $parameters): void
    {
        $this->take = isset($parameters['take']) ? (int) $parameters['take'] : 15;
        $this->orderBy = isset($parameters['order_by']) ? (string) $parameters['order_by'] : 'created_at';
        $this->orderDirection = isset($parameters['order_direction']) ? (string) $parameters['order_direction'] : 'DESC';
        $this->search = isset($parameters['search']) ? (string) $parameters['search'] : '';
    }

    private function applyOrder(): void
    {
        if (! $this->orderBy) {
            $this->query->orderBy($this->orderBy, $this->orderDirection);
        } else {
            $this->query->latest();
        }
    }

    private function applySearch(): void
    {
        if ($this->search !== '') {
            $search = urldecode($this->search);

            $this->query->where(function (Builder $query) use ($search) {
                $query->where('name', 'LIKE', "%$search%")
                    ->orWhere('slug', 'LIKE', "%$search%")
                    ->orWhere('description', 'LIKE', "%$search%");
            });
        }
    }
}
