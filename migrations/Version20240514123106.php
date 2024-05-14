<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514123106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur_details DROP FOREIGN KEY FK_82DFC18B981C689');
        $this->addSql('DROP INDEX UNIQ_82DFC18B981C689 ON utilisateur_details');
        $this->addSql('ALTER TABLE utilisateur_details CHANGE utilisateur_id_id utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur_details ADD CONSTRAINT FK_82DFC18FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_82DFC18FB88E14F ON utilisateur_details (utilisateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur_details DROP FOREIGN KEY FK_82DFC18FB88E14F');
        $this->addSql('DROP INDEX UNIQ_82DFC18FB88E14F ON utilisateur_details');
        $this->addSql('ALTER TABLE utilisateur_details CHANGE utilisateur_id utilisateur_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur_details ADD CONSTRAINT FK_82DFC18B981C689 FOREIGN KEY (utilisateur_id_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_82DFC18B981C689 ON utilisateur_details (utilisateur_id_id)');
    }
}
