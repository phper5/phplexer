<?php
use diandi\Lexer;
use diandi\stone\ast\PrimaryExpr;
use diandi\stone\bnf\Operators;
use diandi\stone\token\EOFToken;
use diandi\stone\Parser;

require __DIR__ . '/../vendor/autoload.php';
$file = 'lan4_5';


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

$statement0 = Parser::rule();
$block = Parser::rule(\diandi\stone\ast\BlockStmnt::class)->sep("{")->option($statement0)
->repeat(Parser::rule()->sep(";", new EOFToken())->option($statement0))->sep("}");
$simple = Parser::rule(PrimaryExpr::class)->ast($expr);
$statement = $statement0->or(Parser::rule(\diandi\stone\ast\IfStmnt::class)->sep("if")->ast($expr)
->ast($block)->option(Parser::rule()->sep("else")->ast($block)),
    Parser::rule(\diandi\stone\ast\WhileStmnt::class)->sep("while")->ast($expr)->ast($block), $simple);

$program = Parser::rule()->or($statement, Parser::rule(\diandi\stone\ast\NullStmnt::class))->sep(";",
    new EOFToken());
while ( !($l->peek(0) instanceof  \diandi\stone\token\EOFToken)) {//读取下一个token不是结束
    $ast = $program->parse($l);
    print_r("=> " . $ast->toString());
    echo "\n";
}
//@todo 对$block 在java进行测试 确定$expr0