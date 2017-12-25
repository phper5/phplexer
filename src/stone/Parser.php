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
use diandi\stone\bnf\element\Skip;
use diandi\stone\bnf\element\Tree;

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
            $e = $this->elements[0];
            return $e->match($lexer);
        }
    }
    public function parse(Lexer $lexer)
    {
        $result = [];
        foreach ($this->elements as $ele)
        {
            $ele->parse($lexer,$result);
        }
        return ($this->factory)($result);
    }
    /**
     * 向语法规则中添加未包含于抽象语法树的终结符 与pat匹配的标识符
     *
     * @return Parser
     */
    public function sep(array $pat) {
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
}