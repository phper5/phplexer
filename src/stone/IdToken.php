<?php

namespace diandi\stone;
class IdToken extends \diandi\stone\Token
{

    static protected $type=self::TYPE_ID;
    public function __construct(int $line,int $pos,string $val)
    {
        parent::__construct($line,$pos);
        $this->value = $val;
    }
    public function isIdentifier()
    {
        return true;
    }
}