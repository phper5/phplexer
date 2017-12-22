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
            if (method_exists($object,'create'))
            {
                $this->factory = function ($arg) use ($object)
                {
                    return call_user_func([$object,'create'],$arg);
                };
            }
            else{
                $this->factory = function ($arg) use ($object)
                {
                    $class = get_class($object);
                    return new $class();
                };
            }
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
        foreach ($this->elements as $e)
        {
            $e->parse($lexer,$result);
        }
        return ($this->factory)($result);
    }
}