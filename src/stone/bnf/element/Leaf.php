<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 5:31 PM
 */

namespace diandi\stone\bnf\element;


use diandi\Lexer;
use diandi\stone\ast\ASTLeaf;
use diandi\stone\ast\ASTList;
use diandi\stone\ParseException;
use diandi\stone\token\Token;

class Leaf extends Element
{
    protected $tokens = [];
    public function __construct(array $pat)
    {
        $this->tokens = $pat;
    }

    protected function match(Lexer $lexer)
    {
        // var Token
        $token = $lexer->peek();
        if ($token->getType() == Token::TYPE_ID)
        {
            foreach ($this->tokens as $t)
            {
                if ($t == $t->getText())
                {
                    return true;
                }
            }
        }
        return false;
    }

    public function parse(Lexer $lexer, array &$list)
    {

        $token = $lexer->read();
        if ($token->getType() == Token::TYPE_ID)
        {
            foreach ($this->tokens as $t)
            {
                if ($t == $token->getText())
                {
                    $this->find($list,$token);
                    return ;
                }
            }
        }
        if (count($this->tokens)>0)
        {
            ParseException::throwByMsgAndToken($this->tokens[0]." expected.",$token);
        }
        else{
            ParseException::throwByToken($token);
        }
    }
    public function find(array &$list, Token $token)
    {
        $list[] = new ASTLeaf($token);
    }
}