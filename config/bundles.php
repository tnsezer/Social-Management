<?php

use FOS\RestBundle\FOSRestBundle;
use FriendsOfBehat\SymfonyExtension\Bundle\FriendsOfBehatSymfonyExtensionBundle;
use JMS\SerializerBundle\JMSSerializerBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;

return [
    FrameworkBundle::class  => ['all' => true],
    TwigBundle::class  => ['all' => true],

    MonologBundle::class  => ['all' => true],

    Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => true],

    FOSRestBundle::class  => ['all' => true],
    JMSSerializerBundle::class  => ['all' => true],

    FriendsOfBehatSymfonyExtensionBundle::class => ['test' => true]
];

