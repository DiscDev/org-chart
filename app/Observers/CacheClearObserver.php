<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CacheClearObserver
{
    public function saved(Model $model)
    {
        $this->clearCache($model);
    }

    public function deleted(Model $model)
    {
        $this->clearCache($model);
    }

    protected function clearCache(Model $model)
    {
        $tags = [
            'responses',
            'api_responses',
            class_basename($model),
            $model->getTable()
        ];

        Cache::tags($tags)->flush();
    }
}