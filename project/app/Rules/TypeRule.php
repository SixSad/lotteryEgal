<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;

class TypeRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        if (empty($parameters)) {
            return false;
        }

        return gettype($value) === $parameters[0];
    }

    public function message(): string
    {
        return parent::message(); // TODO
    }

}
