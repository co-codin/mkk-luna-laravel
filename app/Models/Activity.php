<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    protected $guarded = ['id'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Activity::class, 'parent_id');
    }

    // Связь с организациями: вид деятельности может принадлежать многим организациям
    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class);
    }

    public static function getDescendantIds($parentId, $depth = 0, $maxDepth = 3): array
    {
        if ($depth >= $maxDepth) {
            return [];
        }

        $ids = [$parentId];
        $children = self::query()->where('parent_id', $parentId)->pluck('id');

        foreach ($children as $childId) {
            $ids = array_merge($ids, self::getDescendantIds($childId, $depth + 1));
        }

        return $ids;
    }
}
