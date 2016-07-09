<?php
return [
    'fields' => [
        'field_id',
        'type',
        'external_id',
        'label',
        'status',
        'config~description',
    ],
    'types' => [
        'text' => [
            'input' => 'text',
        ],
        'number' => [
            'input' => 'text',
        ],
        'category' => [
            'input' => 'select',
//            'options_position'=>'config~settings~options',
            'options_fields' => [
                'id', 'text', 'status'
            ]
        ],
        'app' => [
            'input' => 'select',
        ],
        'date' => [
            'input' => 'text',
        ],
        'calculation' => [
            'input' => 'calculation',
        ],

    ],
    'connected_apps' => [
        // this is the reference app id
        '16194434' => [
            //parent app_id
            'connected_to' => '16073840',
            'app_id'=>'16194434',
            'app_secret'=>'90cb7fe8f4bf4f01b4c1cac0870198cf',
            'field_mapped_for'=>'data_format',
            //reference field in the reference app
            'connection_field' => [
                'external_id' => 'brief',
                'field_id' => 125564479,
            ],
            //mapped fields in the reference app
            'fields' => [
                'data_formats' => [
                    'app_type' => 'category',
                    'target_type' => 'label',
                    'external_id' => 'category',
                    'field_id' => 125563866,
                ],
                'data_format_value' => [
                    'app_type' => 'progress',
                    'target_type' => 'text',
                    'external_id' => 'percentage',
                    'field_id' => 125563867,
                ]
            ],
        ]
    ],

];