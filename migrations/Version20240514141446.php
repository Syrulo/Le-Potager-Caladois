<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514141446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_role (utilisateur_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_9EE8E650FB88E14F (utilisateur_id), INDEX IDX_9EE8E650D60322AC (role_id), PRIMARY KEY(utilisateur_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur_role ADD CONSTRAINT FK_9EE8E650FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_role ADD CONSTRAINT FK_9EE8E650D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur (email)');
        $this->addSql('ALTER TABLE utilisateur_details CHANGE prenom prenom VARCHAR(150) DEFAULT NULL, CHANGE nom nom VARCHAR(150) DEFAULT NULL, CHANGE tel tel VARCHAR(10) DEFAULT NULL, CHANGE adresse adresse VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_82DFC18F037AB0F ON utilisateur_details (tel)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur_role DROP FOREIGN KEY FK_9EE8E650FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_role DROP FOREIGN KEY FK_9EE8E650D60322AC');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE utilisateur_role');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur');
        $this->addSql('DROP INDEX UNIQ_82DFC18F037AB0F ON utilisateur_details');
        $this->addSql('ALTER TABLE utilisateur_details CHANGE prenom prenom VARCHAR(150) NOT NULL, CHANGE nom nom VARCHAR(150) NOT NULL, CHANGE tel tel VARCHAR(10) NOT NULL, CHANGE adresse adresse VARCHAR(255) NOT NULL');
    }
}
