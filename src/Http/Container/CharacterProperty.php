<?php

namespace LoopLinguist\RandomPasswordGenerator\Http\Container;

class CharacterProperty
{
    private $characters;

    public function __construct($characters)
    {
        $this->characters = $characters;
    }

    public function getCharacters()
    {
        return $this->characters;
    }
}
