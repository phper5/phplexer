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
    private  static  $regexPat = '/\s*((\/\/.*)|([0-9]+)|("(\\"|\\\\|\\n|[^"])*")|([A-Z_a-z][A-Z_a-z0-9]*)|(\n|{|}|==|<=|>=|&&|\|\||[\(\)=+\-\*\/;]))?/';
     //todo 仅支持+=/×；其他特殊字符有待完善
    public function __construct(string $file)
    {
        if(file_exists($file)){
            $this->fp = fopen($file,"r");
        }else{
            throw new \Exception($file."文件不存在");
        }
    }
    private function  getToken($code,&$matches,$lineNum,$pos)
    {
        if (in_array($code,$matches[2])) //注释
        {
            return null;
        }elseif (in_array($code,$matches[3])) //数字
        {
            return new \diandi\stone\token\NumToken($lineNum,$pos,$code);
        }elseif (in_array($code,$matches[4])) //字符串
        {
            return new \diandi\stone\token\StrToken($lineNum,$pos,$code);
        }elseif (in_array($code,$matches[6])) //变量
        {
            return new \diandi\stone\token\IdToken($lineNum,$pos,$code);
        }elseif (in_array($code,$matches[7])) //运算符 ;
        {
            return new \diandi\stone\token\IdToken($lineNum,$pos,$code);
        }
    }
    private function readLine()
    {
        if($line = fgets($this->fp))
        {
            $this->lineNum++;
//            $regexPat = '/\s*((\/\/.*)|([0-9]+)|("(\\"|\\\\|\\n|[^"])*")|([A-Z_a-z][A-Z_a-z0-9]*)|(\n|{|}|==|<=|>=|&&|\|\||[\(\)=+\-\*\/;]))?/';
//            $regexPat2= '/\s*((\/\/.*)|([0-9]+)|("(\\"|\\\\|\\n|[^"])*")|([A-Z_a-z][A-Z_a-z0-9]*)|({|}|==|<=|>=|&&|\|\||[\(\)=+\-\*\/;]))?/';
//            preg_match_all($regexPat,$line,$matches);
//
//            print_r($matches);
//            echo "ss".$matches[7][3]."ss";
//            exit;

            preg_match_all(self::$regexPat,$line,$matches);
            $lastPos = 0;
            foreach ($matches[0] as $code)
            {
               if (empty($code))
                {
                    continue;
                }
//                if ($code === "\n")
//                {
//
//                }
                $startPos = strpos($line,$code);
                $len = strlen($code);
                $line = substr($line,$startPos+$len);
                $lastPos = $lastPos+$startPos+$len;
                $token = $this->getToken($code,$matches,$this->lineNum,$lastPos-$len+1);
                //分析读到的数据写入queue
                if ($token instanceof  \diandi\stone\token\Token)
                {
                    $this->queue[]=$token;
                }
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
        return new \diandi\stone\token\EOFToken();
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
            return new \diandi\stone\token\EOFToken();
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