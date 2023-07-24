<?php

namespace LoopLinguist\RandomPasswordGenerator\Http\Container;

use LoopLinguist\RandomPasswordGenerator\Http\Abstracts\PropertyValueAbstract;
use LoopLinguist\RandomPasswordGenerator\Http\Exception\NotBooleanException;
use LoopLinguist\RandomPasswordGenerator\Http\Constants\DataType;

class BooleanProperty extends PropertyValueAbstract
{

    public function setValue($value)
    {
        if (!is_bool($value)) {
            throw new NotBooleanException('Boolean Expected.');
        }

        parent::setValue($value);
    }

    public function getType()
    {
        return DataType::BOOLEAN;
    }
}
