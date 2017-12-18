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
    private  static $regexPat = "\\s*((//.*)|([0-9]+)|(\"(\\\\\"|\\\\\\\\|\\\\n|[^\"])*\")|[A-Z_a-z][A-Z_a-z0-9]*|==|<=|>=|&&|\\|\\||\\p{Punct})?";
    public function __construct(string $file)
    {
        if(file_exists($file)){
            $this->fp = fopen($file,"r");
        }else{
            throw new \Exception($file."文件不存在");
        }
    }
    private function readLine()
    {
        if($line = fgets($this->fp))
        {
            $this->lineNum++;
            //分析读到的数据写入queue
            $this->queue[]=$line;
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