<?php
namespace diandi\stone\token;
class  EOFToken extends \diandi\stone\token\Token
{
    public function __construct()
    {
        parent::__construct(-1,-1);
        $this->value = 'eof';
    }
}