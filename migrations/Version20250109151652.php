<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250109151652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE loan_item (loan_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', item_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_CEB65F6ACE73868F (loan_id), INDEX IDX_CEB65F6A126F525E (item_id), PRIMARY KEY(loan_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE loan_item ADD CONSTRAINT FK_CEB65F6ACE73868F FOREIGN KEY (loan_id) REFERENCES loan (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE loan_item ADD CONSTRAINT FK_CEB65F6A126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loan_item DROP FOREIGN KEY FK_CEB65F6ACE73868F');
        $this->addSql('ALTER TABLE loan_item DROP FOREIGN KEY FK_CEB65F6A126F525E');
        $this->addSql('DROP TABLE loan_item');
    }
}
