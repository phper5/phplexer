<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 2:29 PM
 */

namespace diandi\stone\ast;


class NumberLiteral extends ASTLeaf
{
    public function value()
    {
        return $this->token()->getNumber();
    }
}