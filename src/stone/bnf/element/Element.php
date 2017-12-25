<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 4:22 PM
 */

namespace diandi\stone\bnf\element;


use diandi\Lexer;
use diandi\stone\ast\ASTList;

abstract class Element
{
    protected abstract function match(Lexer $lexer);
    protected abstract function parse(Lexer $lexer,array &$list);
}