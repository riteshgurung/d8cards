<?php

namespace Drupal\day_21_replacing_hook_init;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class ResponseSubscriber implements EventSubscriberInterface {

  private $currentUser;

  public function __construct($current_user) {
    $this->currentUser = $current_user;
  }

  public static function create(ContainerInterface $container) {
    return new static($container->get('current_user'));
  }

  public static function getSubscribedEvents() {
    return [
      KernelEvents::RESPONSE => 'onResponse'
    ];
  }


  public function onResponse(FilterResponseEvent $event) {

    if ($this->currentUser->isAnonymous()) {
      $response = $event->getResponse();
      $response->headers->set('Access-Control-Allow-Origin', '*');
    }

  }




}