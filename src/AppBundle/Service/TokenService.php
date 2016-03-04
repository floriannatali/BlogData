<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 02/03/16
 * Time: 11:09
 */

namespace AppBundle\Service;

use AppBundle\Token\TokenStorage;
use Lcobucci\JWT\Parser;
use Symfony\Component\HttpFoundation\Request;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Signer\Key;

class TokenService
{

    /**
     * @var Parser
     */
    protected $jwtParser;

    /**
     * @var Sha256
     */
    protected $jwtSigner;

    /**
     * @var Key
     */
    protected $jwtKey;

    /**
     * @var TokenStorage
     */
    protected $tokenStorage;

    /**
     * TokenService constructor.
     * @param Parser $jwtParser
     * @param Sha256 $jwtSigner
     * @param Key $jwtKey
     */
    public function __construct(Parser $jwtParser, Sha256 $jwtSigner, Key $jwtKey, TokenStorage $tokenStorage)
    {
        $this->jwtParser = $jwtParser;
        $this->jwtSigner = $jwtSigner;
        $this->jwtKey = $jwtKey;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param $token
     * @return bool
     * @throws \Exception
     */
    public function isTokenAuthorizedAndSetTokenStorageIfYes($token) {
        try{
            $token = $this->jwtParser->parse((string) $token); // Parses from a string
            $verified = $token->verify($this->jwtSigner, $this->jwtKey);
            if($verified){
                $this->tokenStorage->setToken($token);
            }
            return $verified;

        }catch (\Exception $ex) {
            throw new \Exception('Impossible to parse jwt token, please verify its encoding');
        }
    }

    /**
     *
     * @param $token
     * @return bool
     */
    public function isTokenValid($token) {
        $token = explode('.',$token);
        return count($token) == 3;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function extractJwtTokenFromRequest(Request $request)
    {
        if($request->headers->has('Authorization'))  {
            //should return 'Bearer ajwttoken'
            $tmpToken = explode(' ',$request->headers->get('Authorization'));
            if(count($tmpToken) == 2 && $tmpToken[0] == 'Bearer')
            {
                return $tmpToken[1];
            }
        }

        return null;
    }


}