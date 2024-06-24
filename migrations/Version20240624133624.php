<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240624133624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE producteur ADD image_name VARCHAR(255) NOT NULL, ADD image_size INT NOT NULL');
        $this->addSql('ALTER TABLE producteur RENAME INDEX uniq_7edbee10e7927c74 TO UNIQ_IDENTIFIER_EMAIL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE producteur DROP image_name, DROP image_size');
        $this->addSql('ALTER TABLE producteur RENAME INDEX uniq_identifier_email TO UNIQ_7EDBEE10E7927C74');
    }
}
