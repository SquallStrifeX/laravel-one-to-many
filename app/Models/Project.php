<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    // Nel model Project
public function getRouteKeyName()
{
    return 'slug'; // Assicurati che 'slug' sia il campo che intendi usare per il Route Model Binding.
}
protected $fillable = [
    'name', 'description', 'repository_link', 'date_start', 'date_end', 'img', 'slug'
];

}


