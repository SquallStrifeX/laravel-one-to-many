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
            'name' => 'required|string|max:255', // Regole di validazione simili a StoreProjectRequest
            'description' => 'required|string', // Assicurati che le regole di validazione siano appropriate per l'aggiornamento
            // Puoi inserire regole di validazione specifiche per l'aggiornamento se necessario
        ];
    }
}
