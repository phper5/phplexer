<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/26/17
 * Time: 11:47 AM
 */

namespace diandi\stone;


use diandi\stone\token\EOFToken;
use diandi\stone\token\Token;
use Throwable;

class ParseException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static  function throwByToken($token)
    {
        throw self::throwByMsgAndToken('',$token);
    }
    public static function throwByMsgAndToken($msg,$token)
    {
        echo "syntax error around " . self::location($token) . ". " . $msg;exit;
        throw new \Exception("syntax error around " . self::location($token) . ". " . $msg);
    }
    public static function location(Token $token)
    {
        if ($token instanceof  EOFToken)
        {
            return "the last line";
        }
        else{
            return "\"" . $token->getText() . "\"  " . $token->getLocation();
        }
    }
}