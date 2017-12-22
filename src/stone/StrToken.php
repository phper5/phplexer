<?php

namespace diandi\stone;
class StrToken extends \diandi\stone\Token
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