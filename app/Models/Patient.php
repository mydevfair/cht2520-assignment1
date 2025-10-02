<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'sex',
        'blood_type',
        'phone'
    ];

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('blood_type', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        return $query;
    }

    public function scopeSortBy($query, $column, $order = 'asc')
    {
        $allowedColumns = ['id', 'name', 'age', 'sex', 'blood_type', 'phone'];
        $column = in_array($column, $allowedColumns) ? $column : 'id';
        $order = in_array($order, ['asc', 'desc']) ? $order : 'asc';

        return $query->orderBy($column, $order);
    }
}
