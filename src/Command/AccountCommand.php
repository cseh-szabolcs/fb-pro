<?php

namespace App\Command;

use App\App;
use App\Constants\Lang;
use App\Constants\Role;
use App\Entity\Mandate;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:account:create',
    description: 'Create main account.',
)]
class AccountCommand extends Command
{
    public function __construct(
        private readonly App $app,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('password', InputArgument::REQUIRED, 'Password which will be hashed.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Main account creation');

        $mandate = new Mandate('NanoScript');
        $user = new User($mandate, 'szabolcs.cseh@gmail.com', Role::ROOT->value, Lang::DE->value);

        $user->passwordPlain = $input->getArgument('password');
        $this->app->authProvider->hashUserPassword($user);

        $this->app->em->persist($user);
        $this->app->em->flush();

        $io->success('Done.');

        return Command::SUCCESS;
    }
}
