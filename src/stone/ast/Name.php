<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 2:24 PM
 */

namespace diandi\stone\ast;


class Name extends ASTLeaf
{

    public function name()
    {
        return $this->token()->getText();
    }
}