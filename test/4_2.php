<?php
use diandi\Lexer;
use diandi\stone\ast\PrimaryExpr;
use diandi\stone\bnf\Operators;
use diandi\stone\token\EOFToken;
use diandi\stone\Parser;

require __DIR__ . '/../vendor/autoload.php';
$file = 'lan4_2';
$str = 'ab1 c 3 dsf 34sdfd ';


$l = new \diandi\Lexer($file);
$basic = new \diandi\stone\BasicParser();

$expr0 = Parser::rule();
$program = Parser::rule()->number(\diandi\stone\ast\NumberLiteral::class);

while ( !($l->peek(0) instanceof  \diandi\stone\token\EOFToken)) {//读取下一个token不是结束
    $ast = $program->parse($l);
    print_r("=> " . $ast->toString());
}
