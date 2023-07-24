<?php

namespace LoopLinguist\RandomPasswordGenerator;

use LoopLinguist\RandomPasswordGenerator\Http\Constants\Property;
use LoopLinguist\RandomPasswordGenerator\Http\Constants\DataType;
use LoopLinguist\RandomPasswordGenerator\Http\Abstracts\GeneratePasswordAbstract;
use LoopLinguist\RandomPasswordGenerator\Http\Container\CharacterProperty;
use LoopLinguist\RandomPasswordGenerator\Http\Exception\NotPropertyException;
use LoopLinguist\RandomPasswordGenerator\Http\Exception\RangeErrorException;
use LoopLinguist\RandomPasswordGenerator\Http\Exception\NotIntegerException;

class GeneratePassword extends GeneratePasswordAbstract
{

    protected $password = '';
    protected $passwordLengthMinumum = 8;
    protected $passwordLength = 0;
    protected $defaultPasswordLength = 0;
    protected $type = 'default';

    protected $typeLength = 0;
    protected $customLength = 0;

    protected $lengthUpperCase = 1;
    protected $lengthLowerCase = 1;
    protected $lengthNumber = 1;
    protected $lengthSymbol = 1;

    protected $forcegenerate = false;


    protected $upperCaseRequired = false;
    protected $lowerCaseRequired = false;
    protected $numberRequired = false;
    protected $symbolRequired = false;

    public function __construct()
    {
        $this
            ->setProperty(Property::UPPER_CASE, array('type' => DataType::BOOLEAN, 'default' =>  config('random-password-generator.upper_case')))
            ->setProperty(Property::LOWER_CASE, array('type' => DataType::BOOLEAN, 'default' => config('random-password-generator.lower_case')))
            ->setProperty(Property::NUMBERS, array('type' => DataType::BOOLEAN, 'default' => config('random-password-generator.number')))
            ->setProperty(Property::SYMBOLS, array('type' => DataType::BOOLEAN, 'default' => config('random-password-generator.symbols')))
            ->setProperty(Property::AVOID_SIMILAR, array('type' => DataType::BOOLEAN, 'default' => config('random-password-generator.avoid_similar')))
            ->setProperty(Property::LENGTH, array('type' => DataType::INTEGER, 'default' => config('random-password-generator.password_length')))
            ->setParameter(Property::UPPER_CASE, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ')
            ->setParameter(Property::LOWER_CASE, 'abcdefghijklmnopqrstuvwxyz')
            ->setParameter(Property::NUMBERS, '0123456789')
            ->setParameter(Property::SYMBOLS,  config('random-password-generator.symbols_list'))
            ->setParameter(Property::AVOID_SIMILAR, 'iIl1Oo0');

        $this->forcegenerate = config('random-password-generator.force_generate');
        $this->passwordLengthMinumum = config('random-password-generator.password_length_minimum');
        $this->defaultPasswordLength = config('random-password-generator.password_length');
    }



    public function getCharacterList()
    {
        $characters = '';

        if (($this->type == 'default' && $this->getPropertyValue(Property::UPPER_CASE)) || $this->type == Property::UPPER_CASE) {
            $characters .= $this->getParameter(Property::UPPER_CASE, '');
        }

        if (($this->type == 'default' && $this->getPropertyValue(Property::LOWER_CASE)) || $this->type == Property::LOWER_CASE) {
            $characters .= $this->getParameter(Property::LOWER_CASE, '');
        }

        if (($this->type == 'default' && $this->getPropertyValue(Property::NUMBERS)) || $this->type == Property::NUMBERS) {
            $characters .= $this->getParameter(Property::NUMBERS, '');
        }

        if (($this->type == 'default' && $this->getPropertyValue(Property::SYMBOLS)) || $this->type == Property::SYMBOLS) {
            $characters .= $this->getParameter(Property::SYMBOLS, '');
        }

        if ($this->getPropertyValue(Property::AVOID_SIMILAR)) {
            $removeCharacters = \str_split($this->getParameter(Property::AVOID_SIMILAR, ''));
            $characters = \str_replace($removeCharacters, '', $characters);
        }

        if (!$characters) {
            throw new NotPropertyException('Password generation strategy is not set.');
        }

        return new CharacterProperty($characters);
    }


    public function generatePassword(): string
    {
        if ($this->defaultPasswordLength < 1 || $this->defaultPasswordLength > 255) {
            throw new RangeErrorException('Out of Range.');
        }
        if ((($this->customLength > 0) && (($this->lengthSymbol + $this->lengthNumber + $this->lengthUpperCase + $this->lengthLowerCase) > $this->getLength()) && !$this->forcegenerate)) {
            throw new RangeErrorException('Out of Range.');
        }

        if ($this->symbolRequired) {
            $this->type = Property::SYMBOLS;
            $this->typeLength = $this->lengthSymbol;
            self::onConditionGeneratePassword();
        }

        if ($this->numberRequired) {
            $this->type = Property::NUMBERS;
            $this->typeLength = $this->lengthNumber;
            self::onConditionGeneratePassword();
        }

        if ($this->upperCaseRequired) {
            $this->type = Property::UPPER_CASE;
            $this->typeLength = $this->lengthUpperCase;
            self::onConditionGeneratePassword();
        }

        if ($this->lowerCaseRequired) {
            $this->type = Property::LOWER_CASE;
            $this->typeLength = $this->lengthLowerCase;
            self::onConditionGeneratePassword();
        }

        $this->type = 'default';
        $characterList = $this->getCharacterList()->getCharacters();
        $characters = \strlen($characterList);
        $length = $this->getLength() - $this->passwordLength;
        for ($i = 0; $i < $length; ++$i) {
            $this->password .= $characterList[$this->randomInteger(0, $characters - 1)];
        }

        return $this->shufflePassword($this->password);
    }

    private function onConditionGeneratePassword(): string
    {
        $characterList = $this->getCharacterList()->getCharacters();
        $characters = \strlen($characterList);
        for ($i = 0; $i < $this->typeLength; ++$i) {
            $this->password .= $characterList[$this->randomInteger(0, $characters - 1)];
            $this->passwordLength++;
        }
        return $this->password;
    }


    /** Password Length Master */

    public function getLength()
    {
        return $this->getPropertyValue(Property::LENGTH);
    }

    public function setLength($characterCount)
    {
        if (!is_int($characterCount) || $characterCount < 1) {
            throw new NotIntegerException('Expected positive integer');
        }

        if ($characterCount < $this->passwordLengthMinumum) {
            throw new RangeErrorException('Out of Range.');
        }

        $this->customLength = $characterCount;
        $this->setPropertyValue(Property::LENGTH, $characterCount);
        return $this;
    }


    public function removeUppercase()
    {
        $this->setPropertyValue(Property::UPPER_CASE, false);
        return $this;
    }


    public function removeLowercase()
    {
        $this->setPropertyValue(Property::LOWER_CASE, false);
        return $this;
    }


    public function removeNumbers()
    {
        $this->setPropertyValue(Property::NUMBERS, false);
        return $this;
    }


    public function removeSymbols()
    {

        $this->setPropertyValue(Property::SYMBOLS, false);
        return $this;
    }


    public function removeAvoidSimilar()
    {
        $this->setPropertyValue(Property::AVOID_SIMILAR, false);
        return $this;
    }


    public function upperCaseRequired($characterCount = 1)
    {
        if (!is_int($characterCount) || $characterCount < 1) {
            throw new NotIntegerException('Expected positive integer');
        }
        $this->upperCaseRequired = true;
        $this->lengthUpperCase = $characterCount;
        return $this;
    }

    public function lowerCaseRequired($characterCount = 1)
    {
        if (!is_int($characterCount) || $characterCount < 1) {
            throw new NotIntegerException('Expected positive integer');
        }
        $this->lowerCaseRequired = true;
        $this->lengthLowerCase = $characterCount;
        return $this;
    }

    public function numbersRequired($characterCount = 1)
    {
        if (!is_int($characterCount) || $characterCount < 1) {
            throw new NotIntegerException('Expected positive integer');
        }
        $this->numberRequired = true;
        $this->lengthNumber = $characterCount;
        return $this;
    }

    public function symbolsRequired($characterCount = 1)
    {
        if (!is_int($characterCount) || $characterCount < 1) {
            throw new NotIntegerException('Expected positive integer');
        }
        $this->symbolRequired = true;
        $this->lengthSymbol = $characterCount;
        return $this;
    }
}
