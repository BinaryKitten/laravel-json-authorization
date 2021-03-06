<?php

namespace Voice\JsonAuthorization\Database\Seeds;

use Illuminate\Database\Seeder;
use Voice\JsonAuthorization\App\AuthorizableSetType;

class AuthorizableSetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'        => 'virtual-role',
                'description' => "Virtual role which doesn't and shouldn't exist in authentication service. Attached automatically to every user.",
            ],
            [
                'name'        => 'roles',
                'description' => 'Authentication service roles',
            ],
            [
                'name'        => 'groups',
                'description' => 'Authentication service groups',
            ],
            [
                'name'        => 'id',
                'description' => 'Authentication service ID',
            ],
        ];

        AuthorizableSetType::insert($data);
    }
}
