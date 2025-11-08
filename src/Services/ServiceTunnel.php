<?php

declare(strict_types=1);

namespace App\Services;

use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Service\Attribute\Required;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Throwable;

#[AsEventListener]
final class ServiceTunnel  implements ServiceSubscriberInterface
{
    const Services = [
        SerializerInterface::class,
    ];

    private static ?ContainerInterface $container;

    /**
     * Is it dirty? Yes, but it works! :)
     *
     * @template T of object
     * @param class-string<T> $className
     * @return T
     * @throws Throwable
     */
    public static function get(string $className): object
    {
        assert(in_array($className, self::Services, true));

        return self::$container->get($className);
    }


    #[Required]
    public function setContainer(ContainerInterface $container): void
    {
        self::$container = $container;
    }

    public static function getSubscribedServices(): array
    {
        return array_combine(self::Services, self::Services);
    }
}
