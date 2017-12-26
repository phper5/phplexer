<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 4:23 PM
 */

namespace diandi\stone\bnf\element;


use diandi\Lexer;
use diandi\stone\ast\ASTList;
use diandi\stone\Parser;

class Tree extends Element
{
    /**
     * @var Parser
     */
    protected $parse;
    public function __construct($parse)
    {
        $this->parse = $parse;
    }
    public function parse(Lexer $lexer, array &$list)
    {
        $list[]=$this->parse->parse($lexer);
    }
    public function match(Lexer $lexer)
    {
        return $this->parse->match($lexer);
    }

}