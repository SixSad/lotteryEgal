<?php

namespace App\Rules;

use App\Helpers\SessionHelper;
use App\Models\User;
use Egal\Validation\Rules\Rule as EgalRule;

class OwnerRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        return SessionHelper::getId() === $value;
    }

    public function message(): string
    {
        return parent::message();
    }

}
