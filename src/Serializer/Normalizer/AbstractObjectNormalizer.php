<?php

namespace App\Serializer\Normalizer;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractObjectNormalizer
{
    protected readonly ?ObjectNormalizer $objectNormalizer;

    #[Required]
    public function injectDecoratedNormalizer(
        #[Autowire(service: 'serializer.normalizer.object')] ObjectNormalizer $objectNormalizer,
    ): void
    {
        $this->objectNormalizer = $objectNormalizer;
    }
}
