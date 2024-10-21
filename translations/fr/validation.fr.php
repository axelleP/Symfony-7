<?php

declare(strict_types=1);

return [
    'not_blank' => 'Le champ est obligatoire.',
    'positive' => 'Le champ doit être un nombre positif.',
    'json' => 'Le champ doit être un Json valide.',
    'email' => 'Le champ doit être un email valide.',
    'decimal_max_2' => 'Le champ doit être un nombre avec un maximum de deux décimales.',
    'article' => [
        'name' => [
            'length' => 'Le nom ne doit pas dépasser 50 caractères.'
        ],
        'image' => [
            'format' => 'Veuillez uploader une image valide (JPEG, PNG ou GIF).'
        ]
    ],
    'user' => [
        'email' => [
            'length' => "L'email ne doit pas dépasser 180 caractères."
        ],
        'password' => [
            'format' => 'Le mot de passe doit contenir au moins : 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.'
        ],
        'username' => [
            'length' => 'Le nom utilisateur ne doit pas dépasser 50 caractères.'
        ]
    ]
];
