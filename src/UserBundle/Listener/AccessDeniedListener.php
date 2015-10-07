<?php
namespace UserBundle\Listener;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent,
    Symfony\Component\Security\Core\Exception\AccessDeniedException,
    Symfony\Component\HttpFoundation\RequestStack,
    Symfony\Component\HttpFoundation\RedirectResponse,
    Symfony\Component\HttpFoundation\Session\Session,
    Symfony\Component\Routing\Router,
    Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface as AccessInterface;

class AccessDeniedListener
{ 
    protected $_request;
    public function __construct(Session $session, Router $router, RequestStack $requestStack)
    {
        $this->_session = $session;
        $this->_router = $router;
        $this->_request = $requestStack;
    }
    public function onAccessDeniedException(GetResponseForExceptionEvent $event)
    {
        if ($event->getException()->getMessage() == 'Access Denied')
        {
            $this->_session->setFlash('error', 'Access Denied. You do not have permission to access this page.');
    
            if ($this->_request->headers->get('referer'))
            {
                    $route = $this->_request->headers->get('referer');
            } else {
                    $route = $this->_router->generate('homepage');
            }
    
            $event->setResponse(new RedirectResponse($route));
             return $this->redirect(
                $this->generateUrl('homepage')
            );
        }
    }
}