<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/14/17
 * Time: 3:33 PM
 */
namespace diandi\stone\token;
class Token
{
    //所在的行号
    private $lineNum;
    //所在的列
    private $pos;
    protected $value;
    static protected $type=self::TYPE_EOF;

    const TYPE_EOF = 0;
    const TYPE_STR = 1;
    const TYPE_NUM = 2;
    const TYPE_ID = 3;
    public function __construct(int $line,int $pos)
    {
        $this->lineNum = $line;
        $this->pos = $pos;
    }
    public function getText()
    {
        return $this->value;
    }
    public function getType()
    {
        return static::$type;
    }
    public function getLocation()
    {
        return "at line " + $this->lineNum." col "+$this->pos;
    }
    public function getNumber() {
        throw new \Exception("not number token");
    }
}