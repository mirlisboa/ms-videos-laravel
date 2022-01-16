<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use Uuid, HasFactory, SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [ 'name', 'description', 'is_active' ];
}
