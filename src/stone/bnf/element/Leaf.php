<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 5:31 PM
 */

namespace diandi\stone\bnf\element;


use diandi\Lexer;
use diandi\stone\ast\ASTList;

class Leaf extends Element
{
    protected $tokens;
    public function __construct($pat)
    {
        $this->tokens = $pat;
    }

    protected function match(Lexer $lexer)
    {
        // TODO: Implement match() method.
    }

    protected function parse(Lexer $lexer, array &$list)
    {
        // TODO: Implement parse() method.
    }
}