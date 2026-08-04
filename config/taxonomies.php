<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Simple Taxonomies (flat entities with shared CRUD)
    |--------------------------------------------------------------------------
    |
    | Add new discovery attributes here to enable admin CRUD with minimal code.
    | Each entry maps to a model class and optional field flags.
    |
    */

    'occasions' => [
        'label' => 'Occasions',
        'label_singular' => 'Occasion',
        'model' => App\Models\Occasion::class,
        'fields' => ['icon' => true, 'image' => true],
    ],

    'recipients' => [
        'label' => 'Recipients',
        'label_singular' => 'Recipient',
        'model' => App\Models\Recipient::class,
        'fields' => ['image' => true],
    ],

    'styles' => [
        'label' => 'Styles',
        'label_singular' => 'Style',
        'model' => App\Models\Style::class,
        'fields' => [],
    ],

    'materials' => [
        'label' => 'Materials',
        'label_singular' => 'Material',
        'model' => App\Models\Material::class,
        'fields' => [],
    ],

];
