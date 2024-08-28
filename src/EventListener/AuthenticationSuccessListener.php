<?php

namespace App\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class AuthenticationSuccessListener
{
    private $logger;
    private $serializer;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event): void
    {
        $user = $event->getUser();

        if (!$user instanceof User) {
            $this->logger->error('User is not an instance of App\Entity\User');
            return;
        }

        $data = $event->getData();
        $data['user'] = [
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
        ];
        $event->setData($data);

        $this->logger->info('User information added to JWT payload', ['user' => $data['user']]);
    }
}

