<?php

namespace LoopLinguist\RandomPasswordGenerator\Http\Container;

use InvalidArgumentException;
use LoopLinguist\RandomPasswordGenerator\Http\Abstracts\PropertyValueAbstract;
use LoopLinguist\RandomPasswordGenerator\Http\Constants\DataType;
use LoopLinguist\RandomPasswordGenerator\Http\Exception\NotStringException;

class StringProperty extends PropertyValueAbstract
{
    public function __construct(array $settings = array())
    {
        parent::__construct($settings);
    }

    public function setValue($value)
    {
        if (!is_string($value)) {
            throw new NotStringException('String Expected.');
        }

        parent::setValue($value);
    }

    public function getType()
    {
        return DataType::STRING;
    }
}
