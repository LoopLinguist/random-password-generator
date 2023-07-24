<?php

namespace LoopLinguist\RandomPasswordGenerator\Http\Container;

use InvalidArgumentException;
use LoopLinguist\RandomPasswordGenerator\Http\Abstracts\PropertyValueAbstract;
use LoopLinguist\RandomPasswordGenerator\Http\Constants\DataType;
use LoopLinguist\RandomPasswordGenerator\Http\Exception\NotIntegerException;

class IntegerProperty extends PropertyValueAbstract
{
    public function __construct(array $settings = array())
    {
        parent::__construct($settings);
    }

    public function setValue($value)
    {
        if (!is_integer($value)) {
            throw new NotIntegerException('Integer Expected.');
        }

        parent::setValue($value);
    }

    public function getType()
    {
        return DataType::INTEGER;
    }
}
