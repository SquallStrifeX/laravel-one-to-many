<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize()
    {
        // Autorizza tutti gli utenti a fare questa richiesta.
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:projects,name', // Nome unico nel database
            'description' => 'required|string|max:65535', // Descrizione del progetto
            'repository_link' => 'nullable|url|max:255', // Link al repository, opzionale, deve essere un URL valido
            'date_start' => 'required|date', // Data di inizio, deve essere una data valida
            'date_end' => 'nullable|date|after_or_equal:date_start', // Data di fine, opzionale, deve essere dopo o uguale alla data di inizio
            'img' => 'nullable|image|max:2048', // Immagine del progetto, opzionale, deve essere un'immagine valida e meno di 2MB
            'slug' => 'required|string|max:255|unique:projects,slug' // Slug unico nel database
        ];
    }
}
