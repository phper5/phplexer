<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 12:40 PM
 */

namespace diandi\stone\ast;


class ASTList extends \diandi\stone\ast\ASTree
{
    public function __construct($list)
    {
        $this->children = $list;
    }
    public function child(int $i)
    {
        return ($this->children[$i])->toString();
    }
    public function toString()
    {
        $str = [];
        foreach ($this->children() as $child)
        {
            $str []= $child->toString();
        }
        $str = implode(' ',$str);
        $str = '('.$str.')';
        return $str;
    }
    public function location()
    {
        foreach ($this->children() as $child)
        {
            if ($s = $child->location())
            {
                return $s;
            }
        }
        return null ;
    }

    public function children()
    {
        return $this->children;//children.iterator();
    }

    public function numChildren()
    {
        return count($this->children);
    }


}