<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 3:49 PM
 */
namespace diandi\stone\bnf;
class Operators
{
    //定义左右的方向的常量
    public const LEFT = true;
    public const RIGHT = false;
    public static $map = [];

    /**
     * @param string $name  运算符  +
     * @param int $prec     优先级  1
     * @param bool $leftAssoc  方向  Operators.LEFT or Operators.RIGHT
     */
    public function add(string  $name, int $prec, bool $leftAssoc)
    {
        self::$map[$name] = new Precedence($prec,$leftAssoc);
    }

}