<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize()
    {
        // Qui puoi inserire la logica per determinare se l'utente è autorizzato a fare questa richiesta.
        // Per ora, restituiamo true per consentire a chiunque di aggiornare un progetto.
        return true;
    }

    public function rules()
{
    return [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        // altri campi...
        'type_id' => 'nullable|exists:types,id', // Assicurati che questa riga sia presente
    ];
}
}
