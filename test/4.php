<?php
require __DIR__ . '/../vendor/autoload.php';
$file = 'lan4';
$str = 'ab1 c 3 dsf 34sdfd ';


$l = new \diandi\Lexer($file);
$basic = new \diandi\stone\BasicParser();

while ( !($l->peek(0) instanceof  \diandi\stone\token\EOFToken)) {//读取下一个token不是结束
    $ast = $basic->parse($l);
    print_r("=> " . $ast->toString());
}
