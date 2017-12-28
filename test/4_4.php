<?php
use diandi\Lexer;
use diandi\stone\ast\PrimaryExpr;
use diandi\stone\bnf\Operators;
use diandi\stone\token\EOFToken;
use diandi\stone\Parser;

require __DIR__ . '/../vendor/autoload.php';
$file = 'lan4_4';


$l = new \diandi\Lexer($file);
$basic = new \diandi\stone\BasicParser();
$reserved = [];
$reserved[] = ";";
$reserved[] = "}";
$reserved[] = new EOFToken();

$operators = new Operators();
$operators->add("=", 1, Operators::RIGHT);
$operators->add("==", 2, Operators::LEFT);
$operators->add(">", 2, Operators::LEFT);
$operators->add("<", 2, Operators::LEFT);
$operators->add("+", 3, Operators::LEFT);
$operators->add("-", 3, Operators::LEFT);
$operators->add("*", 4, Operators::LEFT);
$operators->add("/", 4, Operators::LEFT);
$operators->add("%", 4, Operators::LEFT);

$expr0 = Parser::rule();
$primary = Parser::rule(PrimaryExpr::class)->or(
    Parser::rule()->sep("(")->ast($expr0)->sep(")"),
    Parser::rule()->number(\diandi\stone\ast\NumberLiteral::class),
    Parser::rule()->identifier(\diandi\stone\ast\Name::class,$reserved),
    Parser::rule()->string(\diandi\stone\ast\StringLiteral::class)
);
$factor = Parser::rule()->or(
    Parser::rule(
        \diandi\stone\ast\NegativeExpr::class)->sep("-")->ast($primary),
        $primary
    );
$expr = $expr0->expression(\diandi\stone\ast\BinaryExpr::class, $factor, $operators);
while ( !($l->peek(0) instanceof  \diandi\stone\token\EOFToken)) {//读取下一个token不是结束
    $ast = $expr->parse($l);
    print_r("=> " . $ast->toString());
}
