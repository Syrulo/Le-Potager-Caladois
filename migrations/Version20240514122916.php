<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514122916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur_details ADD utilisateur_id_id INT NOT NULL, DROP ville, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE prenom prenom VARCHAR(150) NOT NULL, CHANGE nom nom VARCHAR(150) NOT NULL, CHANGE tel tel VARCHAR(10) NOT NULL, CHANGE adresse adresse VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur_details ADD CONSTRAINT FK_82DFC18B981C689 FOREIGN KEY (utilisateur_id_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_82DFC18B981C689 ON utilisateur_details (utilisateur_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur_details DROP FOREIGN KEY FK_82DFC18B981C689');
        $this->addSql('DROP INDEX UNIQ_82DFC18B981C689 ON utilisateur_details');
        $this->addSql('ALTER TABLE utilisateur_details ADD ville VARCHAR(180) DEFAULT NULL, DROP utilisateur_id_id, CHANGE id id VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) DEFAULT NULL, CHANGE nom nom VARCHAR(150) DEFAULT NULL, CHANGE tel tel VARCHAR(10) DEFAULT NULL, CHANGE adresse adresse VARCHAR(255) DEFAULT NULL');
    }
}
