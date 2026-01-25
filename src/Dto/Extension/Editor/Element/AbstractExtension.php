<?php

namespace App\Dto\Extension\Editor\Element;

use App\Contracts\OutputExtensionInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Serializer\Attribute\Groups;

#[AutoconfigureTag(name: 'app.dto_extension.editor.element')]
abstract class AbstractExtension implements OutputExtensionInterface
{
    #[Groups(['editor'])]
    public function getSupportedTypes(): ?array
    {
        $types = $this->supportedTypes();

        return empty($types) ? null : $types;
    }

    protected abstract function supportedTypes(): ?array;
}
