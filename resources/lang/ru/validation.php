<?php

return [
    'required' => 'validation.:attribute.required',
    'email' => 'validation.email',
    'string' => 'validation.:attribute.string',
    'lowercase' => 'validation.:attribute.lowercase',
    'max' => [
        'string' => 'validation.:attribute.max',
    ],
    'min' => [
        'string' => 'validation.:attribute.min',
    ],
    'confirmed' => 'validation.:attribute.confirmed',
    'unique' => 'validation.:attribute.unique',
];
