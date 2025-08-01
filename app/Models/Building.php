<?php

namespace App\Models;

use Database\Factories\BuildingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Building extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }

    protected static function newFactory(): BuildingFactory
    {
        return BuildingFactory::new();
    }
}
