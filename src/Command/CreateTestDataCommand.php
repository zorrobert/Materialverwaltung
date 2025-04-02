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

        # creating users
        $io->info("Creating sample users...");
        $userRepository = $this->em->getRepository(User::class);
        $users = [
            'fredi' => [
                'firstName' => 'Frederick',
                'lastName' => 'Paduch',
                'password' => 'fredi',
                'roles' => [ 'ROLE_ADMIN' ],
            ],
            'mikail' => [
                'firstName' => 'Mikail',
                'lastName' => 'Durmus',
                'password' => 'mikail',
                'street' => 'Regnitzstraße',
                'streetNumber' => '13a',
                'phone' => '+49 160 95147783',
                'city'  => 'Forchheim',
                'zipCode' => '91301',
                'email' => 'm.durmus@softway.de',
                'birthday' => new \DateTimeImmutable('08-10-2001'),
                'roles' => [ 'ROLE_ADMIN' ],
            ],
            'oli' => [
                'firstName' => 'Oliver',
                'lastName' => 'Klein',
                'password' => 'oli',
                'roles' => [ 'ROLE_ADMIN' ],
            ],
            'robert' => [
                'firstName' => 'Robert',
                'lastName' => 'Lotz',
                'password' => 'robert',
                'roles' => [ 'ROLE_ADMIN' ],
                'birthday' => new \DateTimeImmutable('1-4-2021'),
            ],
            'testAdmin' => [
                'roles' => [ 'ROLE_ADMIN' ],
            ],
            'testValidator' => [
                'roles' => [ 'ROLE_VALIDATOR' ],
            ],
            'testUser' => [
                'roles' => [ 'ROLE_USER' ],
            ],
        ];
        foreach ($users as $username => $properties) {
            $user = $userRepository->findOneBy(['username' => $username]) ?? new User();
            $user->setUsername($username);

            # get user info from array, set defaults if empty
            $password = $properties['password'] ?? 'material';
            $user->setPassword($this->userPasswordHasher->hashPassword($user, $password));
            $user->setRoles($properties['roles'] ?? [ 'ROLE_USER' ]);
            # personal data
            $user->setFirstName($properties['firstName'] ?? 'Max');
            $user->setLastName($properties['lastName'] ?? 'Mustermann');
            if (array_key_exists('birthday', $properties)) {
                $user->setBirthday($properties['birthday']); # ?? new \DateTimeImmutable('now')
            }
            # contact data
            if (array_key_exists('phone', $properties)) {
                $user->setPhone($properties['phone']); # ?? '+49 42'
            }
            $user->setEmail($properties['email'] ?? 'muster@mail.de');
            # location data
            $user->setCity($properties['city'] ?? 'Musterstadt');
            $user->setStreet($properties['street'] ?? 'Musterstraße');
            $user->setStreetNumber($properties['streetNumber'] ?? '42');
            $user->setZipcode($properties['zipCode'] ?? '04242');

            $this->em->persist($user);
        }
        //dd('exit dev');
        $this->em->flush();
        $io->success('Successfully created the following users: '.implode(", ", array_keys($users)));

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
            $newLoan->setUser($userRepository->findOneBy(["username" => "testAdmin"]));
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
