<?php

namespace LoopLinguist\RandomPasswordGenerator\Http\Abstracts;

use LoopLinguist\RandomPasswordGenerator\Http\Interfaces\PropertyValueInterface;
use LoopLinguist\RandomPasswordGenerator\Http\Constants\DataType;
use LoopLinguist\RandomPasswordGenerator\Http\Container\BooleanProperty;
use LoopLinguist\RandomPasswordGenerator\Http\Container\IntegerProperty;
use LoopLinguist\RandomPasswordGenerator\Http\Container\StringProperty;

abstract class PropertyValueAbstract implements PropertyValueInterface
{

    private $value = null;

    public function __construct(array $settings = array())
    {
        if (isset($settings['default'])) {
            $this->value = $settings['default'];
        }
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public static function createFromType($dataType, array $settings = array())
    {
        switch ($dataType) {
            case DataType::STRING:
                return new StringProperty($settings);

            case DataType::INTEGER:
                return new IntegerProperty($settings);

            case DataType::BOOLEAN:
                return new BooleanProperty($settings);
        }

        return;
    }
}
