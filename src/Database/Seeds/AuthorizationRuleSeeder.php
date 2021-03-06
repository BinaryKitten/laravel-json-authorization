<?php

namespace Voice\JsonAuthorization\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Voice\JsonAuthorization\App\AuthorizableModel;
use Voice\JsonAuthorization\App\AuthorizationRule;

class AuthorizationRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Config::get('asseco-authorization.universal_role');

        $authorizableModels = AuthorizableModel::all();

        foreach ($authorizableModels as $authorizableModel) {

            $rules = $this->generateRules();

            AuthorizationRule::create([
                'authorizable_set_type_id' => 1,
                'authorizable_set_value'   => $role,
                'authorizable_model_id'    => $authorizableModel->id,
                'rules'                    => json_encode($rules),
            ]);
        }
    }

    protected function generateRules()
    {
        $rules = [];
        $rights = [
            'read', 'create', 'update', 'delete'
        ];

        $counter = rand(1, 4);

        for ($i = 0; $i < $counter; $i++) {

            $right = $rights[$i];

            if ($right === 'read') {
                $randRight = rand(1, 2);

                if ($randRight === 1) {
                    $rule = "*";
                } else {
                    $ids = $this->getRandomNumbers();

                    $rule = [
                        'search' => [
                            'id' => '=' . implode(";", $ids),
                        ]
                    ];
                }
            } else {
                $ids = $this->getRandomNumbers();

                $rule = [
                    'search' => [
                        'id' => '=' . implode(";", $ids),
                    ]
                ];
            }

            $rules[$rights[$i]] = $rule;
        }

        return $rules;
    }


    protected function getRandomNumbers()
    {
        $counter = rand(1, 4);

        $random = [];
        for ($i = 0; $i < $counter; $i++) {
            $random[$i] = rand(0, 50);
        }

        return $random;
    }

}
