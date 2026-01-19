<?php

namespace App\Command;

use App\Constants\Lang;
use App\Constants\Role;
use App\Entity\Mandate;
use App\Entity\User;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;

#[AsCommand(
    name: 'app:account:create',
    description: 'Create main account.',
)]
class AccountCommand extends AbstractCommand
{
    public function __invoke(#[Argument('Root password')] string $password): int
    {
        $this->io->title('Main account creation');

        $mandate = new Mandate('NanoScript');
        $user = new User($mandate, 'szabolcs.cseh@gmail.com', Role::ROOT, Lang::DE->value);

        $user->passwordPlain = $password;
        $this->app->authProvider->hashUserPassword($user);

        $this->app->em->persist($user);
        $this->app->em->flush();

        $this->io->success('Done.');

        return Command::SUCCESS;
    }
}
