<?php

namespace LoopLinguist\RandomPasswordGenerator\Http\Abstracts;

use LoopLinguist\RandomPasswordGenerator\Http\Interfaces\GeneratePasswordInterface;
use LoopLinguist\RandomPasswordGenerator\Http\Abstracts\PropertyValueAbstract;
use LoopLinguist\RandomPasswordGenerator\Http\Exception\InvalidPropertyException;
use LoopLinguist\RandomPasswordGenerator\Http\Exception\InvalidPropertyTypeException;

abstract class GeneratePasswordAbstract implements GeneratePasswordInterface
{
    private $properties = [];
    private $parameters = [];

    public function setProperty($property, $propertySettings)
    {
        $type = isset($propertySettings['type']) ? $propertySettings['type'] : '';

        $this->properties[$property] = PropertyValueAbstract::createFromType($type, $propertySettings);

        if ($this->properties[$property] === null) {
            throw new InvalidPropertyTypeException('Invalid Property Type');
        }

        return $this;
    }


    public function getProperty($property)
    {
        if (!isset($this->properties[$property])) {
            return;
        }

        return $this->properties[$property];
    }

    public function setPropertyValue($property, $value)
    {
        if (!isset($this->properties[$property])) {
            throw new InvalidPropertyException('Invalid Property');
        }

        $this->properties[$property]->setValue($value);

        return $this;
    }

    public function getPropertyValue($property)
    {
        if (!isset($this->properties[$property])) {
            throw new InvalidPropertyException('Invalid Property');
        }

        return $this->properties[$property]->getValue();
    }



    /** Parameter */
    public function setParameter($parameter, $value)
    {
        $this->parameters[$parameter] = $value;
        return $this;
    }


    public function getParameter($parameter, $default = null)
    {
        if (!isset($this->parameters[$parameter])) {
            return $default;
        }
        return $this->parameters[$parameter];
    }


    public function randomInteger($min, $max)
    {
        return random_int($min, $max);
    }

    public function generatePassword(): string
    {
        return $this->generatePassword();
    }

    public function shufflePassword($password)
    {
        $passwordArray = str_split($password);
        shuffle($passwordArray);
        return implode('', $passwordArray);
    }
}
