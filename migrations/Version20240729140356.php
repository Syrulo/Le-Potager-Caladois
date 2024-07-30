<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240729140356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE producteur CHANGE nom nom VARCHAR(180) DEFAULT NULL, CHANGE tel tel VARCHAR(10) DEFAULT NULL, CHANGE adresse adresse VARCHAR(255) DEFAULT NULL, CHANGE ville ville VARCHAR(80) DEFAULT NULL, CHANGE code_postal code_postal INT DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE producteur CHANGE nom nom VARCHAR(180) NOT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE tel tel VARCHAR(10) NOT NULL, CHANGE adresse adresse VARCHAR(255) NOT NULL, CHANGE ville ville VARCHAR(80) NOT NULL, CHANGE code_postal code_postal INT NOT NULL');
    }
}
