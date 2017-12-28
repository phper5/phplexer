<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 3:54 PM
 */

namespace diandi\stone\bnf;


class Precedence
{
    /**
     * @var int 优先级
     */
    private $val;
    /**
     * @var bool 方向
     */
    private $leftAssoc;
    public function __construct(int $val,bool $leftAssoc)
    {
        $this->val = $val;
        $this->leftAssoc = $leftAssoc;
    }
    public function getValue()
    {
        return $this->val;
    }
    public function isLeftAssoc()
    {
        return $this->leftAssoc;
    }

}