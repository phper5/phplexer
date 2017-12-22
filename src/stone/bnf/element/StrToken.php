<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 5:26 PM
 */

namespace diandi\stone\bnf\element;


use diandi\stone\token\Token;

class StrToken extends AToken
{
    protected function test(Token $t)
    {
        return $t->getType()==Token::TYPE_STR;
    }

}