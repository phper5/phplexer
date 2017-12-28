<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 5:33 PM
 */

namespace diandi\stone\bnf\element;


use diandi\Lexer;
use diandi\stone\ast\ASTLeaf;
use diandi\stone\ast\ASTList;
use diandi\stone\ast\ASTree;
use diandi\stone\bnf\Operators;
use diandi\stone\bnf\Precedence;
use diandi\stone\Factory;
use diandi\stone\Parser;
use diandi\stone\token\Token;

class Expr extends Element
{
    protected $factory;
    protected $operators;
    protected $factor;
    public function __construct($class,Parser $parser,Operators $operators)
    {
        $this->operators = $operators;
        $this->factor = $parser;
        $this->factory = Factory::get($class,null);//list
        if (!$this->factory)
        {
            $this->factory = function ($arg) {
                if (count($arg)  == 1)
                {
                    return $arg[0];
                }else{
                    return new ASTList($arg);
                }
            };
        }
    }

    public function match(Lexer $lexer)
    {
        return $this->factor->match($lexer);
    }

    public function parse(Lexer $lexer, array &$list)
    {
        $right = $this->factor->parse($lexer);
        /**
         * @var $prec  Precedence
         */
        while ($prec = $this->nextOperator($lexer))
        {
            $right = $this->doShift($lexer, $right, $prec->getValue());
        }
        $list[] = $right;
    }
    private function doShift(Lexer $lexer,ASTree $left,int $prec)
    {
        $list = [];
        $list[] = $left;
        $list[] = new ASTLeaf($lexer->read());
        $right = $this->factor->parse($lexer);
        while (($next = $this->nextOperator($lexer))
            && $this->rightIsExpr($prec, $next))
        {
            $right = $this->doShift($lexer, $right, $next->getValue());
        }
        $list[] = $right;
        return ($this->factory)($list);

    }
    private  function rightIsExpr(int $prec,Precedence $precedence)
    {
        if ($precedence->isLeftAssoc())
        {
            return $prec < $precedence->getValue();
        }
        else{
            return $prec <= $precedence->getValue();
        }
    }
    private function nextOperator(Lexer $lexer)
    {
        /**
         * @var $t Token
         */
        $t = $lexer->peek(0);
        if ($t->getType() == Token::TYPE_ID)
        {
            return $this->operators->get($t->getText());
        }
        return null;
    }
}