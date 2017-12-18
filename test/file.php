<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/18/17
 * Time: 11:28 AM
 */
require __DIR__ . '/../vendor/autoload.php';
$file = '/data/lan';
$l = new \diandi\Lexer($file);
print_r($l->read());
print_r($l->peek(0));
print_r($l->peek(1));
//print_r($l->peek(2));

print_r($l->read());echo 'a';
print_r($l->peek(3));echo 'd';
print_r($l->peek(10));
echo 'end';