<?php

    return [
        // ... other validation messages
        'required' => 'Le champ :attribute est obligatoire.',
        'email'    => 'Le champ :attribute doit être une adresse e-mail valide.',
        'min'      => [
            'string' => 'Le champ :attribute doit contenir au moins :min caractères.',
            // ... other types
        ],
		 'unique' => 'L\'adresse e-mail a déjà été utilisée.',
        // ... other validation messages
        'attributes' => [
            'name'     => 'nom',
            'email'    => 'adresse e-mail',
            'password' => 'mot de passe',
            // Add other attribute translations as needed
        ],
    ];