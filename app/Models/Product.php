<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Utils\CanBeRated; // 

class Product extends Model
{
    use HasFactory;
    use CanBeRated; // 

    protected $guarded = [];

    /**
     * Relación: Un producto pertenece a una categoría
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Relación: Un producto fue creado por un usuario (Administrador/Creador)
     * Como el método se llama createdBy(), Laravel por defecto buscaría "created_by_id".
     * 
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    /**
     * Relación: Un producto tiene muchos usuarios que lo han calificado.
     */
    public function users()
    {
        return $this->morphToMany(\App\Models\User::class, 'rateable', 'ratings', 'rateable_id', 'qualifier_id')
            ->withPivot('qualifier_type', 'score');
    }
}