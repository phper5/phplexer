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
    protected $parser;
    public function __construct($parser)
    {
        $this->parser = $parser;
    }
    public function parse(Lexer $lexer, ASTList &$list)
    {
        $list[]=$this->parse->parser($lexer);
    }
    public function match(Lexer $lexer)
    {
        return $this->parser->match($lexer);
    }

}