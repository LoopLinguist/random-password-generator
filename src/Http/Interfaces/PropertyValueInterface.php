<?php

namespace LoopLinguist\RandomPasswordGenerator\Http\Interfaces;

interface PropertyValueInterface
{

    public function __construct(array $settings);

    public function getType();

    public function getValue();

    public function setValue($value);
}
