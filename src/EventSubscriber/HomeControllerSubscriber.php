<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class HomeControllerSubscriber implements EventSubscriberInterface
{
    private string $defaultLocale;

    public function __construct(string $defaultLocale = 'fr')
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            return;
        } else {
            $request->setLocale($request->getSession()->get(
                '_locale',
                $this->defaultLocale
            ));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            //'kernel.request' => 'onKernelRequest',
            KernelEvents::REQUEST => [['onKernelRequest', 20]]
        ];
    }
}
