<?php

namespace CursoBundle\Listener
;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DoctrineExtensionListener implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    public function onKernelRequest(GetResponseEvent $event)
    {
        $doctrine = $this->container->get('doctrine');
        $doctrine->getEntityManager()->getConfiguration()->addFilter(
            'soft-deleteable',
            'Gedmo\SoftDeleteable\Filter\SoftDeleteableFilter'
        );
        $em = $doctrine->getEntityManager();
        $em->getFilters()->enable('soft-deleteable');
    }
}
