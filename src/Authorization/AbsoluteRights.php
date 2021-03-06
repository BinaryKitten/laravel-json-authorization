<?php

namespace Voice\JsonAuthorization\Authorization;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class AbsoluteRights
{
    protected array $absoluteRights;

    public function __construct()
    {
        $this->absoluteRights = Config::get('asseco-authorization.absolute_rights');
    }

    public function check(CachedRuleCollection $authorizationRules): bool
    {
        foreach ($this->absoluteRights as $absoluteRightType => $absoluteRightValues) {

            $userRules = $authorizationRules->where('type', $absoluteRightType);

            if ($userRules->isEmpty()) {
                continue;
            }

            $absoluteRightValues = Arr::wrap($absoluteRightValues);

            foreach ($absoluteRightValues as $absoluteRightValue) {
                if ($userRules->pluck('value')->contains($absoluteRightValue)) {
                    return true;
                }
            }
        }

        return false;
    }
}
