<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 5:01 PM
 */

namespace diandi\stone\bnf\element;


use diandi\Lexer;
use diandi\stone\ast\ASTList;
use diandi\stone\Factory;
use diandi\stone\ParseException;
use diandi\stone\token\Token;

abstract class AToken extends Element
{
    protected $factory;
    public function __construct($type)
    {
        if ($type == null)
        {
            $type = ASTList::class;
        }
        $this->factory = Factory::get($type,Token::class);
    }
    public function parse(Lexer $lexer, array &$list)
    {
        $token = $lexer->read();
        if ($this->test($token))
        {
            $leaf = ($this->factory)($token);
            $list[] = $leaf;
        }
        else{
            ParseException::throwByToken($token);
        }
    }
    public function match(Lexer $lexer)
    {
        return $this->test($lexer->peek(0));
    }
    protected abstract function test(Token $t);

}