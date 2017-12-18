<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/14/17
 * Time: 3:33 PM
 */
namespace diandi\stone;
class Token
{
    //所在的行号
    private $lineNum;
    public function __construct(int $line)
    {
        $this->lineNum = $line;
    }
    public static function getEOFToken()
    {
        static $token = null;
        if ($token === null)
        {
            $token = new Token(-1);
        }
        return $token;
    }
}