<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 2:18 PM
 */

namespace diandi\stone\ast;


class IfStmnt extends ASTList
{
    public function condition()
    {
        return $this->child(0);
    }
    public function thenBlock()
    {
        return $this->child(1);
    }
    public function elseBlock()
    {
        return $this->numChildren()>2?$this->child(2):null;
    }
    public function toString()
    {
        return '( if '.$this->condition().' '.$this->thenBlock()."
                  else ".$this->elseBlock()
            .' )';
    }
}