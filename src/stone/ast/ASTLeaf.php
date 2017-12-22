<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 12:25 PM
 */

namespace diandi\stone\ast;


class ASTLeaf extends ASTree
{
    protected $token;
    protected $children = [];
    public function __construct(\diandi\stone\token\Token $token)
    {
        $this->token = $token;
    }
    public function toString()
    {
        return $this->token->getText();
    }
    public function location()
    {
        return $this->token->getLocation();
    }
    public function token() :\diandi\stone\token\Token
    {
        return $this->token();
    }
    public function child(int $i)
    {
        throw new \Exception('IndexOutOfBoundsException');
    }
    public function children()
    {
        return [];
    }
    public function numChildren()
    {
        return 0;
    }

}