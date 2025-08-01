<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = ['id'];

    public static function getDescendantIds($parentId, $depth = 0, $maxDepth = 3)
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
