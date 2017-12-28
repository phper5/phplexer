<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/22/17
 * Time: 4:08 PM
 */

namespace diandi\stone;


use diandi\Lexer;
use diandi\stone\ast\ASTList;
use diandi\stone\ast\ASTree;
use diandi\stone\bnf\element\Expr;
use diandi\stone\bnf\element\IdToken;
use diandi\stone\bnf\element\OrTree;
use diandi\stone\bnf\element\Skip;
use diandi\stone\bnf\element\StrToken;
use diandi\stone\bnf\element\Tree;
use diandi\stone\bnf\Operators;


class Parser
{
    protected $elements = [];
    protected $factory;
    public function __construct($data)
    {

        if ($data == null ||  is_subclass_of($data,ASTree::class) )
        {
            return $this->reset($data);
        }
        elseif($data instanceof Parser)
        {
            $this->elements = $data->elements;
            $this->factory = $data->factory;
        }else{
            //to do throw
        }

    }


    public static function rule($class = null)
    {
        return new self($class);
    }
    public function reset($object)
    {
        $this->elements = [];
        if ($object != null)
        {
            $this->factory = Factory::get($object,null);
        }
        else{
            $this->factory = function ($arg){
                if (count($arg)==1)
                {
                    return $arg[0];
                }else{
                    return new ASTList($arg);
                }
            };
        }
        return $this;

    }
    public function match(Lexer $lexer)
    {
        if (count($this->elements) == 0)
        {
            return true;
        }else{
            $element = $this->elements[0];
            return $element->match($lexer);
        }
    }
    public function parse(Lexer $lexer)
    {
        $result = [];
        foreach ($this->elements as $element)
        {
            $element->parse($lexer,$result);
        }
        return ($this->factory)($result);
    }
    /**
     * 向语法规则中添加未包含于抽象语法树的终结符 与pat匹配的标识符
     *
     * @return Parser
     */
    public function sep() {
        $pat = func_get_args();
        $this->elements[] = new Skip($pat);
        return $this;
    }
    /**
     * 向语法规则中添加非终结符 $p
     *
     * @return Parser
     */
    public function ast(Parser $p) {
        $this->elements[] = new Tree($p);
        return $this;
    }
    /**
     * 向语法规则中添加终结符 整型字面量
     *
     * @return Parser
     */
    public function number($clazz) {
        $this->elements[] = new \diandi\stone\bnf\element\NumToken($clazz);
        return $this;
    }
    /**
     * 向语法规则中添加若干个由or关系链接的非终结符 p
     *
     * @return Parser
     */
    public function or() {
        $p = func_get_args();
        $this->elements[] = new OrTree($p);
        return $this;
    }
    /**
     * 向语法规则中添加终结符 除保留字r之外的标识符
     *
     * @return Parser
     */
    public function identifier($class,&$reserved)
    {
        $this->elements[] = new IdToken($class,$reserved);
        return $this;
    }

    /**
     * 向语法规则中添加终结符 字符串字面量
     *
     * @return Parser
     */
    public function string($class)
    {
        $this->elements[] = new StrToken($class);
        return $this;
    }
    /**
     * 向语法规则中添加双目运算符 subexp 因子 operators运算符
     *
     * @return Parser
     */
    public  function expression($class,Parser $subexp,Operators $operators)
    {
        $this->elements[] = new Expr($class, $subexp, $operators);
        return $this;
    }
}