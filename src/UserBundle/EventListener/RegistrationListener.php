<?php
/**
 * Created by PhpStorm.
 * User: daouda
 * Date: 18/03/2020
 * Time: 17:00
 */

namespace UserBundle\EventListener;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\UserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistrationListener implements EventSubscriberInterface
{
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_INITIALIZE => 'onRegistrationInitialize',
            FOSUserEvents::REGISTRATION_SUCCESS => ['onRegistrationSuccess', -10],
        );
    }

    public function onRegistrationInitialize(UserEvent $event)
    {
        $user = $event->getUser();
        $bytes = random_bytes(5);
        $prefix = bin2hex($bytes);
        $publicId = uniqid($prefix);
        $user->setUserPublicId($publicId);
    }

    public function onRegistrationSuccess(FormEvent $event)
    {
        $url = $this->router->generate('fosuser_index');
        $event->setResponse(new RedirectResponse($url));
    }

}