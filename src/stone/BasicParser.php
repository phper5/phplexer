<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 3:47 PM
 */
namespace diandi\stone;
use diandi\Lexer;
use diandi\stone\ast\PrimaryExpr;
use diandi\stone\bnf\Operators;
use diandi\stone\token\EOFToken;

class BasicParser
{
    private $reserved = [];
    private $operators;
    private $expr0 ;
    private $primary;
    private $program;
    public function __construct()
    {
        $this->operators = new Operators();
        $this->expr0 = Parser::rule();
        $this->primary = Parser::rule(PrimaryExpr::class);
        $this->program = Parser::rule();

        //初始数据
        $this->reserved[] = ";";
        $this->reserved[] = "}";
        $this->reserved[] = new EOFToken();

        $this->operators->add("=", 1, Operators.RIGHT);
        $this->operators->add("==", 2, Operators.LEFT);
        $this->operators->add(">", 2, Operators.LEFT);
        $this->operators->add("<", 2, Operators.LEFT);
        $this->operators->add("+", 3, Operators.LEFT);
        $this->operators->add("-", 3, Operators.LEFT);
        $this->operators->add("*", 4, Operators.LEFT);
        $this->operators->add("/", 4, Operators.LEFT);
        $this->operators->add("%", 4, Operators.LEFT);
    }
    public function parse(Lexer $lexer)
    {
        return $this->program->parse($lexer);
    }
}