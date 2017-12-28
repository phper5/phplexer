<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 4:49 PM
 */

namespace diandi\stone\bnf\element;


use diandi\Lexer;
use diandi\stone\ast\ASTList;
use diandi\stone\Parser;

class Repeat extends Element
{
    protected $parser;
    protected $onlyOnce;
    public function __construct(Parser $parser,bool $once)
    {
        $this->parser = $parser;
        $this->onlyOnce = $once;
    }
    public function parse(Lexer $lexer, array &$list)
    {
        while ($this->parser->match($lexer))
        {
            $t = $this->parser->parse($lexer);
            if (get_class($t)!=ASTList::class || $t->numChildren()>0)
            {
                $list[] = $t;
            }
            if ($this->onlyOnce)
            {
                break;
            }
        }
    }
    public function match(Lexer $lexer)
    {
        return $this->parser->match($lexer);
    }
}