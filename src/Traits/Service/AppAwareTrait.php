<?php

namespace App\Traits\Service;

use App\App;
use Symfony\Contracts\Service\Attribute\Required;

trait AppAwareTrait
{
    protected readonly App $app;

    #[Required]
    public function setApp(App $app): void
    {
        $this->app = $app;
    }
}
