<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 2:26 PM
 */

namespace diandi\stone\ast;


class NegativeExpr extends ASTList
{
    public function operand()
    {
        return $this->child(0);
    }
    public function toString()
    {
        return '-'.$this->operand();
    }
}