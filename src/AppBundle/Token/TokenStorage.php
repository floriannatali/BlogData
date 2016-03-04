<?php
namespace AppBundle\Token;
use Lcobucci\JWT\Token;

/**
 * Class TokenStorage
 * @package Sportnco\TokenManagerBundle\Token
 */
class TokenStorage
{
    /**
     * @var Token
     */
    private $token;

    /**
     * @return Token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param Token $token
     */
    public function setToken(Token $token)
    {
        $this->token = $token;
    }
}
