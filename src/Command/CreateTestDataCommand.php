<?php

namespace App\Command;

use App\Entity\Item;
use App\Entity\Loan;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:createTestData',
    description: 'This command creates sample data for testing.',
)]
class CreateTestDataCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $userPasswordHasher,)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        # create test users
        $userRepository = $this->em->getRepository(User::class);
        $testUsers = [
            "testUser" => "ROLE_USER",
            "testValidator" => "ROLE_VALIDATOR",
            "testAdmin" => "ROLE_ADMIN",
            #"testManager", "testAuditor"
        ];

        foreach ($testUsers as $name => $role) {
            # check if user already exists
            if (empty($userRepository->findOneBy(["username" => $name]))) {
                $newUser = new User();
                $newUser->setRoles([$role]);
                $newUser->setUsername($name);
                $hashedPassword = $this->userPasswordHasher->hashPassword($newUser, $name);
                $newUser->setPassword($hashedPassword);
                $this->em->persist($newUser);
            }
        }
        $this->em->flush();
        $io->success('Successfully created the following users: '.implode(", ", array_keys($testUsers)));

        # create test items
        $itemRepository = $this->em->getRepository(Item::class);
        $testItems = [
            "testItem1" => [ "desc" => "Beschreibung testItem1", "id" => "ID1"],
            "testItem2" => [ "desc" => "Beschreibung testItem2", "id" => "ID2"],
            "testItem3" => [],
        ];
        foreach ($testItems as $name => $values) {
            if (empty($itemRepository->findOneBy(["name" => $name]))) {
                $newItem = new Item();
                $newItem->setName($name);
                $newItem->setDescription($values["desc"] ?? NULL);
                $newItem->setInventoryId($values["id"] ?? NULL);
                $this->em->persist($newItem);
            };
        }
        $this->em->flush();
        $io->success('Successfully created '.count($testItems).' items.');

        # create test loans
        $testLoans = [
            [ "items" => [$itemRepository->findOneBy(["inventoryId" => "ID1"])]],
            [ "items" => [
                $itemRepository->findOneBy(["inventoryId" => "ID1"]),
                $itemRepository->findOneBy(["inventoryId" => "ID2"]),
            ]],
        ];
        foreach ($testLoans as $name => $values) {
            $newLoan = new Loan();
            $newLoan->setStatus('requested');
            foreach ($values["items"] as $item) {
                $newLoan->addItem($item);
            }
            $newLoan->setStartDate(new \DateTime("now"));
            $newLoan->setEndDate(new \DateTime("+7 days"));
            $this->em->persist($newLoan);
        }
        $this->em->flush();
        $io->success('Successfully created '.count($testLoans).' loans.');

        $this->em->flush();
        $io->success('Test data has been created.');
        return Command::SUCCESS;
    }
}
