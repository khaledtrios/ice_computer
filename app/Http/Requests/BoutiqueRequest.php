<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Boutique;

class BoutiqueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ou mettre une logique d’autorisation si nécessaire
    }

    public function rules(): array
    {
        $id = $this->route('id'); // récupère l’ID de la boutique dans la route
        $userId = $id ? Boutique::find($id)?->user_id : null;

        return [
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $userId,
            'password'     => 'nullable|string|min:8',
            'nom_boutique' => 'required|string|max:255',
            'telephone'    => 'nullable|string|max:20',
            'adresse'      => 'nullable|string|max:255',
            'city'         => 'nullable|string|max:100',
            'code_postal'  => 'nullable|string|max:10',
            'siret'        => 'nullable|string|max:14',
            'company'      => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required'   => 'Le prénom est obligatoire.',
            'last_name.required'    => 'Le nom est obligatoire.',
            'email.required'        => 'L’adresse e-mail est obligatoire.',
            'email.email'           => 'L’adresse e-mail doit être valide.',
            'email.unique'          => 'Cette adresse e-mail est déjà utilisée.',
            'password.min'          => 'Le mot de passe doit contenir au moins 8 caractères.',
            'nom_boutique.required' => 'Le nom de la boutique est obligatoire.',
        ];
    }
}
