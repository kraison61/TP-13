<?php

namespace App\Support;

use Closure;
use Illuminate\Support\Facades\Cache;

final class FrontendCache
{
    public static function remember(string $key, Closure $callback): mixed
    {
        return Cache::remember(
            'frontend:'.$key,
            now()->addMinutes((int) config('frontend.performance.data_ttl', 60)),
            $callback
        );
    }

    /**
     * Cache a list of model primary keys, then re-fetch with the given query.
     *
     * @template TModel of \Illuminate\Database\Eloquent\Model
     *
     * @param  Closure(): \Illuminate\Database\Eloquent\Builder<TModel>  $query
     * @return \Illuminate\Database\Eloquent\Collection<int, TModel>
     */
    public static function rememberIds(string $key, Closure $query): \Illuminate\Database\Eloquent\Collection
    {
        $ids = self::remember($key, function () use ($query) {
            $builder = $query();

            return $builder->pluck($builder->getModel()->getQualifiedKeyName())->all();
        });

        if ($ids === []) {
            return $query()->whereRaw('0 = 1')->get();
        }

        $builder = $query();
        $models = $builder->whereIn($builder->getModel()->getQualifiedKeyName(), $ids)->get();

        $order = array_flip($ids);

        return $models->sortBy(fn ($model) => $order[$model->getKey()] ?? PHP_INT_MAX)->values();
    }
}
