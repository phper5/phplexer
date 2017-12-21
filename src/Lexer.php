<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/14/17
 * Time: 2:55 PM
 */
namespace diandi;
class Lexer
{
    private $fp;
    private $lineNum = 0;
    private $queue = [];
    private $hasMore = true;
                                  //   注释 2  |数字 3   |字符串(4) 5?             |变量(6)                     |+=*/ == >= <= && || ;(7)
    private  static  $regexPat = '/\s*((\/\/.*)|([0-9]+)|("(\\"|\\\\|\\n|[^"])*")|([A-Z_a-z][A-Z_a-z0-9]*)|(==|<=|>=|&&|\|\||[=+\-\*\/;]))?/';
     //todo 仅支持+=/×；其他特殊字符有待完善
    public function __construct(string $file)
    {
        if(file_exists($file)){
            $this->fp = fopen($file,"r");
        }else{
            throw new \Exception($file."文件不存在");
        }
    }
    private function  getToken($code,&$matches)
    {
        if (in_array($code,$matches[2])) //注释
        {
            return '2'.$code;
        }elseif (in_array($code,$matches[3])) //数字
        {
            return '3'.$code;
        }elseif (in_array($code,$matches[4])) //字符串
        {
            return '4'.$code;
        }elseif (in_array($code,$matches[6])) //变量
        {
            return '5'.$code;
        }elseif (in_array($code,$matches[7])) //运算符 ;
        {
            return '7'.$code;
        }
    }
    private function readLine()
    {
        if($line = fgets($this->fp))
        {
            $this->lineNum++;
            preg_match_all(self::$regexPat,$line,$matches);print_r($matches);
            $pos = 0;
            $posEnd = strlen($line);
            while($pos < $posEnd)
            {
                //cong match开始找
            }
            foreach ($matches[1] as $code)
            {
                if (empty($code))
                {
                    continue;
                }
                $token = $this->getToken($code,$matches,$this->lineNum);
                //分析读到的数据写入queue
                $this->queue[]=$token;
            }
            return true;
        }
        $this->hasMore = false;
        fclose($this->fp);
        $this->fp = null;
        return false;
    }

    /**
     * 读取下一个token
     * @return mixed
     */
    public function read()
    {
        if ($this->fillQueue(0))
        {
            return array_shift($this->queue);
        }
        return \diandi\stone\Token::getEOFToken();
    }

    /**
     * 读取第i个token
     * @param int $i
     * @return mixed|string
     */
    public function peek(int $i)
    {
        if ($this->fillQueue($i))
            return $this->queue[$i];
        else
            return \diandi\stone\Token::getEOFToken();
    }
    public function fillQueue(int $i)
    {
        while ($i >= count($this->queue))
            if ($this->hasMore)
                $this->readLine();
            else
                return false;
        return true;
    }
    public function __destruct()
    {
        if ($this->fp){
            fclose($this->fp);
        }
    }
}