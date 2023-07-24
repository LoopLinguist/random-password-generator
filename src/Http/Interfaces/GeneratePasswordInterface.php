<?php

namespace LoopLinguist\RandomPasswordGenerator\Http\Interfaces;

interface GeneratePasswordInterface
{
    public function setProperty($option, $optionSettings);
    public function getProperty($option);

    public function setPropertyValue($option, $value);
    public function getPropertyValue($option);

    public function setParameter($parameter, $value);
    public function getParameter($parameter);

    public function randomInteger($min, $max);
    public function generatePassword(): string;
}
