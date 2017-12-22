<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 2:10 PM
 */

namespace diandi\stone\ast;


class BinaryExpr extends ASTList
{
    public function left()
    {
        return $this->child(0);
    }
    public function right()
    {
        return $this->child(2);
    }
    public function operator()
    {
        return ($this->child(1))->token()->getText();
    }
}