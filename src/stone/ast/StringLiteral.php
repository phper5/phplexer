<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 2:35 PM
 */

namespace diandi\stone\ast;


class StringLiteral extends ASTLeaf
{
    public function value()
    {
        return $this->token()->getText();
    }
}