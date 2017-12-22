<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 2:32 PM
 */

namespace diandi\stone\ast;


class PrimaryExpr extends  ASTLeaf
{
    public static function create($list)
    {
        return count($list)==1?$list[0]:new self($list);
    }
}