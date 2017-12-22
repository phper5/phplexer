<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 2:36 PM
 */

namespace diandi\stone\ast;


class WhileStmnt extends ASTList
{
    public function condition()
    {
        return $this->child(0);
    }
    public function body()
    {
        return $this->child(1);
    }
    public function toString()
    {
        return "(while " . $this->condition() . " " . $this->body() . ")";
    }
}