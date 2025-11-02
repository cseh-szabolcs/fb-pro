<?php

namespace App\Doctrine\Contracts;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(name: 'doctrine.orm.entity_listener')]
interface EntityListenerInterface {}
