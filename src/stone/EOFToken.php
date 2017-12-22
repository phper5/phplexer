<?php
namespace diandi\stone;
class  EOFToken extends \diandi\stone\Token
{
    public function __construct()
    {
        parent::__construct(-1,-1);
        $this->value = 'eof';
    }
}