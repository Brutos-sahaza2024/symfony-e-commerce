<?php

namespace App\EventListener;

use App\Service\NavbarService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class TwigGlobalListener implements EventSubscriberInterface
{
    private $twig;
    private $navbarService;

    public function __construct(Environment $twig, NavbarService $navbarService)
    {
        $this->twig = $twig;
        $this->navbarService = $navbarService;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $this->twig->addGlobal('navbar_data', $this->navbarService->getNavbarData());
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}