<?php

namespace diandi\stone;
class NumToken extends \diandi\stone\Token
{

    static protected $type=self::TYPE_NUM;
    public function __construct(int $line,int $pos,int $val)
    {
        parent::__construct($line,$pos);
        $this->value = $val;
    }
    public function isNumber()
    {
        return true;
    }
    public function getNumber()
    {
        return $this->value;
    }
}