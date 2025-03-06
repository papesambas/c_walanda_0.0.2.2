<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250306025241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parents (id INT AUTO_INCREMENT NOT NULL, pere_id INT NOT NULL, mere_id INT NOT NULL, INDEX IDX_FD501D6A3FD73900 (pere_id), INDEX IDX_FD501D6A39DEC40E (mere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parents ADD CONSTRAINT FK_FD501D6A3FD73900 FOREIGN KEY (pere_id) REFERENCES peres (id)');
        $this->addSql('ALTER TABLE parents ADD CONSTRAINT FK_FD501D6A39DEC40E FOREIGN KEY (mere_id) REFERENCES meres (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parents DROP FOREIGN KEY FK_FD501D6A3FD73900');
        $this->addSql('ALTER TABLE parents DROP FOREIGN KEY FK_FD501D6A39DEC40E');
        $this->addSql('DROP TABLE parents');
    }
}
