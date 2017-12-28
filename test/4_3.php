<?php
use diandi\Lexer;
use diandi\stone\ast\PrimaryExpr;
use diandi\stone\bnf\Operators;
use diandi\stone\token\EOFToken;
use diandi\stone\Parser;

require __DIR__ . '/../vendor/autoload.php';
$file = 'lan4_3';


$l = new \diandi\Lexer($file);
$basic = new \diandi\stone\BasicParser();
$reserved = [];
$reserved[] = ";";
$reserved[] = "}";
$reserved[] = new EOFToken();


$expr0 = Parser::rule();
$program = Parser::rule(PrimaryExpr::class)->or(
    Parser::rule()->sep("(")->ast($expr0)->sep(")"),
    Parser::rule()->number(\diandi\stone\ast\NumberLiteral::class),
    Parser::rule()->identifier(\diandi\stone\ast\Name::class,$reserved),
    Parser::rule()->string(\diandi\stone\ast\StringLiteral::class)
);

while ( !($l->peek(0) instanceof  \diandi\stone\token\EOFToken)) {//读取下一个token不是结束
    $ast = $program->parse($l);
    print_r("=> " . $ast->toString());
}
