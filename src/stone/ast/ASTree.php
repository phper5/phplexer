<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 11:51 AM
 */
namespace diandi\stone\ast;
abstract class ASTree
{

    abstract public function child(int $i);
    abstract public function location();
    abstract public function children();
    abstract public function numChildren();
}