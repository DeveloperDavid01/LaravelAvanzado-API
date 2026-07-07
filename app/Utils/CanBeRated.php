<?php

namespace App\Utils;

trait CanBeRated
{
    public function qualifiers(string $model = null)
    {
        $modelClass = $model ? (new $model)->getMorphClass() : \App\Models\User::class;
        
        return $this->morphToMany($modelClass, 'rateable', 'ratings', 'rateable_id', 'qualifier_id')
            ->withPivot('qualifier_type', 'score')
            ->wherePivot('qualifier_type', $modelClass)
            ->wherePivot('rateable_type', $this->getMorphClass());
    }

    public function averageRating(string $model = null)
    {
        // Convertimos el resultado a float o int para que coincida perfectamente con los asserts numéricos
        return (float) ($this->qualifiers($model)->avg('score') ?: 0.0);
    }
}