<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:setup',
    description: 'Create Admin User',
)]
class SetupCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        # Check if admin user exists, create it if not
        if (empty($this->em->getRepository(User::class)->findOneBy(["username" => "admin"]))) {
            $admin = new User();
            $admin->setRoles(["ROLE_ADMIN"]);
            $admin->setUsername("admin");
            $hashedPassword = $this->userPasswordHasher->hashPassword($admin, "material");
            $admin->setPassword($hashedPassword);
            $this->em->persist($admin);
            $io->success("Created Admin user. Don't forget to change the default password!");
        } else {
            $io->success("Admin user exists already.");
        }

        $this->em->flush();
        $io->success("Finished Setup.");
        return Command::SUCCESS;
    }
}
