<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the permissions tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'Superadministrador' => [
            'Usuários'          => 'c,r,u,d',
            'Níveis de Acessos' => 'c,r,u,d',
        ],
        'Cliente' => [
            //
        ],
        'Administrador' => [
            'Usuários'          => 'c,r,u,d',
            'Níveis de Acessos' => 'c,r,u,d',
        ],
    ],

    'permissions_map' => [
        'c' => 'Cadastrar',
        'r' => 'Visualizar',
        'u' => 'Editar',
        'd' => 'Deletar'
    ]
];
