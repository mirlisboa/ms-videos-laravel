<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;
use Exception;

trait Uuid
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->id = (string) Str::uuid();
            } catch (Exception $e) {
                abort(500, $e->getMessage());
            }
        });
    }
}
?>