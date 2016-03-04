<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 02/03/16
 * Time: 11:11
 */

namespace AppBundle\EventListener;


use AppBundle\Service\TokenService;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestListener
{
    /**
     * @var TokenService
     */
    protected $tokenService;

    /**
     * RequestListener constructor.
     * @param TokenService $tokenService
     */
    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @param GetResponseEvent $event
     * @throws \Exception
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        if(null === $tokenExtracted = $this
            ->tokenService
            ->extractJwtTokenFromRequest($event->getRequest())
        ) {
            throw new \Exception('The JWT Token is missing');
        }

        if(!$this
            ->tokenService
            ->isTokenValid($tokenExtracted)
        ) {
            throw new \Exception('Bad token format send');
        }

        if(!$this->tokenService->isTokenAuthorizedAndSetTokenStorageIfYes($tokenExtracted)) {
            throw new \Exception('You are not allowed to access API with this JWT Token');
        }
    }
}