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
        $factory = '';//to do
    }
    protected function parse(Lexer $lexer, ASTList &$list)
    {
        $token = $lexer->read();
        if ($this->test($token))
        {
            //ASTree leaf = factory.make(t);
            //res.add(leaf);
        }
        else{
            throw new \Exception('ParseException');
        }
    }
    public function match(Lexer $lexer)
    {
        return $this->test($lexer->peek(0));
    }
    protected abstract function test(Token $t);

}