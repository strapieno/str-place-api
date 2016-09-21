<?php

return [
    'router' => [
        'routes' => [
            'api-rest' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/rest'
                ],
                'child_routes' => [
                    'place' => [
                        'type' => 'Segment',
                        'may_terminate' => true,
                        'options' => [
                            'route' => '/place[/:place_id]',
                            'defaults' => [
                                'controller' => 'Strapieno\Place\Api\V1\Rest\Controller'
                            ],
                            'constraints' => [
                                'place_id' => '[0-9a-f]{24}'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
    'matryoshka-apigility' => [
        'matryoshka-connected' => [
                'Strapieno\Place\Api\V1\Rest\ConnectedResource' => [
                    'model' => 'Strapieno\Place\Model\PlaceModelService',
                    'prototype_strategy' => 'Matryoshka\Model\Object\PrototypeStrategy\ServiceLocatorStrategy',
                    'collection_criteria' => 'Strapieno\Place\Model\Criteria\PlaceCollectionCriteria',
                    'entity_criteria' => 'Strapieno\Model\Criteria\NotIsolatedActiveRecordCriteria',
                    'hydrator' => 'PlaceApiHydrator'
            ]
        ]
    ],
    'zf-rest' => [
        'Strapieno\Place\Api\V1\Rest\Controller' => [
            'service_name' => 'place',
            'listener' => 'Strapieno\Place\Api\V1\Rest\ConnectedResource',
            'route_name' => 'api-rest/place',
            'route_identifier_name' => 'place_id',
            'collection_name' => 'places',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [

            ],
            'page_size' => 10,
            'page_size_param' => 'page_size',
            'collection_class' => 'Zend\Paginator\Paginator', // FIXME function?
        ]
    ],
    'zf-content-negotiation' => [
        'accept_whitelist' => [
            'Strapieno\Place\Api\V1\Rest\Controller' => [
                'application/hal+json',
                'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Strapieno\Place\Api\V1\Rest\Controller' => [
                'application/json'
            ],
        ],
    ],
     'zf-hal' => [
        // map each class (by name) to their metadata mappings
        'metadata_map' => [
            'Strapieno\Place\Model\Entity\PlaceEntity' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api-rest/place',
                'route_identifier_name' => 'place_id',
                'hydrator' => 'PlaceApiHydrator',
            ],
            'Strapieno\Place\Model\Entity\ClubPriveEntity' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api-rest/place',
                'route_identifier_name' => 'place_id',
                'hydrator' => 'PlaceApiHydrator',
            ],
        ],
    ],
    'zf-content-validation' => [
        'Strapieno\Place\Api\V1\Rest\Controller' => [
            'input_filter' => 'Strapieno\Place\Model\InputFilter\DefaultInputFilter',
            'POST' => 'Strapieno\Place\Api\InputFilter\PostInputFilter'
        ]
    ],
    'strapieno_input_filter_specs' => [
        'Strapieno\Place\Api\InputFilter\PostGeoCoordiateInputFilter' => [
            'merge' => 'Strapieno\Place\Model\InputFilter\DefaultGeoCoordiateInputFilter',
            'latitude' => [
                'name' => 'latitude',
                'require' => true,
                'allow_empty' => false
            ],
            'longitude' => [
                'name' => 'longitude',
                'require' => true,
                'allow_empty' => false
            ]
        ],
        'Strapieno\Place\Api\InputFilter\PostPostalAddressInputFilter' => [
            'merge' => 'Strapieno\Place\Model\InputFilter\DefaultPostalAddressInputFilter',
            'address_locality' => [
                'name' => 'address_locality',
                'require' => true,
                'allow_empty' => false
            ],
            'address_region' => [
                'name' => 'address_region',
                'require' => true,
                'allow_empty' => false
            ],

            'postal_code' => [
                'name' => 'postal_code',
                'require' => true,
                'allow_empty' => false
            ],

            'street_address' => [
                'name' => 'street_address',
                'require' => true,
                'allow_empty' => false
            ],

            'address_country' => [
                'name' => 'address_country',
                'require' => true,
                'allow_empty' => false
            ],
        ],

        'Strapieno\Place\Api\InputFilter\PostInputFilter' => [
            'merge' => 'Strapieno\Place\Model\InputFilter\DefaultInputFilter',
            'user_id' => [
                'require' => true,
                'allow_empty' => false

            ],
            'name' => [
                'name' => 'name',
                'require' => true,
                'allow_empty' => false
            ],
            'type' => [
                'name' => 'type',
                'require' => true,
                'allow_empty' => false
            ],
            'geo_coordinate' => [
                'name' => 'geo_coordinate',
                'type' => 'Strapieno\Place\Api\InputFilter\PostGeoCoordiateInputFilter'

            ],
            'postal_address' => [
                'name' => 'postal_address',
                'type' => 'Strapieno\Place\Api\InputFilter\PostPostalAddressInputFilter'
            ],
        ],
    ]
];
