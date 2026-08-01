<?php

/*
|--------------------------------------------------------------------------
| Messages de validation — sous-ensemble utilisé par les formulaires du site
|--------------------------------------------------------------------------
*/

return [

    'required' => 'Le champ :attribute est obligatoire.',
    'email' => 'Le champ :attribute doit être une adresse courriel valide.',
    'string' => 'Le champ :attribute doit être du texte.',
    'numeric' => 'Le champ :attribute doit être un nombre.',
    'integer' => 'Le champ :attribute doit être un nombre entier.',
    'date' => 'Le champ :attribute doit être une date valide.',
    'in' => 'Le champ :attribute sélectionné est invalide.',
    'after_or_equal' => 'Le champ :attribute doit être une date postérieure ou égale à :date.',

    'min' => [
        'numeric' => 'Le champ :attribute doit être au minimum de :min.',
        'string' => 'Le champ :attribute doit contenir au moins :min caractères.',
    ],

    'max' => [
        'numeric' => 'Le champ :attribute ne peut pas dépasser :max.',
        'string' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
    ],

    'attributes' => [
        'name' => 'nom',
        'email' => 'adresse courriel',
        'phone' => 'numéro de téléphone',
        'company' => 'nom de l\'entreprise',
        'message' => 'message',
        'origin' => 'origine',
        'destination' => 'destination',
        'method' => 'méthode d\'expédition',
        'shipment_type' => 'type d\'expédition',
        'weight' => 'poids',
        'length' => 'longueur',
        'width' => 'largeur',
        'height' => 'hauteur',
        'pickup_date' => 'date de retrait',
        'notes' => 'notes complémentaires',
    ],
];
