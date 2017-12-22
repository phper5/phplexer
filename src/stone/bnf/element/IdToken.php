<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 5:17 PM
 */

namespace diandi\stone\bnf\element;


use diandi\stone\token\Token;

class IdToken extends  AToken
{
    protected $reserved;
    public function __construct($type,$r)
    {
        parent::__construct($type);
        $this->reserved = $r != null ? $r : [];
    }
    protected function test(Token $t)
    {
        return ($t->getType() == Token::TYPE_ID) && !$this->reserved.contains($t->getText());
    }

}