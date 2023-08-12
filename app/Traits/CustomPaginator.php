<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

trait CustomPaginator
{
    public function paginate(Collection|array $data, int $perPage = 10, int $page = null, array $options = []): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $data = $data instanceof Collection ? $data : Collection::make($data);

        return new LengthAwarePaginator($data->forPage($page, $perPage), $data->count(), $perPage, $page, $options);
    }
}
