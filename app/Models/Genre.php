<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = ['name', 'is_active'];
}
