<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241104093335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Modifie le champ visitor_id de la table producer';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE producer DROP INDEX IDX_976449DC70BEE6D, ADD UNIQUE INDEX UNIQ_976449DC70BEE6D (visitor_id)');
        $this->addSql('ALTER TABLE producer CHANGE visitor_id visitor_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE producer DROP INDEX UNIQ_976449DC70BEE6D, ADD INDEX IDX_976449DC70BEE6D (visitor_id)');
        $this->addSql('ALTER TABLE producer CHANGE visitor_id visitor_id INT DEFAULT NULL');
    }
}
