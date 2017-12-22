<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 4:36 PM
 */

namespace diandi\stone\bnf\element;


use diandi\Lexer;
use diandi\stone\ast\ASTList;

class OrTree extends Element
{
    protected $parsers = [];
    public function __construct(array $p)
    {
        $this->parsers = $p;
    }
    public function parse(Lexer $lexer, ASTList &$list)
    {
        if ($p = $this->choose($lexer))
        {
            $list[]=$p->parse($lexer);
        }
        else{
            throw new \Exception('ParseException'.$lexer->peek(0));
        }

    }
    public function match(Lexer $lexer)
    {
        return $this->choose($lexer) != null;
    }

    protected  function choose(Lexer $lexer)
    {
        foreach ($this->parsers as $p)
        {
            if ($p->match($lexer))
            {
                return $p;
            }
        }
        return null;
    }
    protected function insert(Lexer $lexer)
    {
        array_splice($this->parsers, 0, 0, $lexer);
    }
}