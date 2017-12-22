<?php

namespace diandi\stone\token;
class StrToken extends \diandi\stone\token\Token
{

    static protected $type=self::TYPE_STR;
    public function __construct(int $line,int $pos,string $val)
    {
        parent::__construct($line,$pos);
        $this->value = $val;
    }
    public function isString()
    {
        return true;
    }

}