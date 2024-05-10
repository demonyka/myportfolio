<?php

return [
    'required' => 'validation.:attribute.required',
    'email' => 'validation.email.incorrect',
    'string' => 'validation.:attribute.string',
    'lowercase' => 'validation.:attribute.lowercase',
    'max' => [
        'string' => 'validation.:attribute.max',
        'file' => 'validation.:attribute.max_file',
        'array' => 'validation.:attribute.max_array'
    ],
    'min' => [
        'string' => 'validation.:attribute.min',
    ],
    'confirmed' => 'validation.:attribute.confirmed',
    'unique' => 'validation.:attribute.unique',
    'regex' => 'validation.:attribute.regex',
    'not_in' => 'validation.:attribute.not_in',
    'mimes' => 'validation.:attribute.mimes',
    'before' => 'validation.:attribute.before',
    'after' => 'validation.:attribute.after',
    'before_or_equal' => 'validation.:attribute.before_or_equal'
];
