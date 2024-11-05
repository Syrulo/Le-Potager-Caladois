<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241030081203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE IF NOT EXISTS address (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(10) DEFAULT NULL, street VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(5) DEFAULT NULL, city VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXISTS category (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, image_name VARCHAR(255) NOT NULL, image_size INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXISTS producer (id INT AUTO_INCREMENT NOT NULL, visitor_id INT DEFAULT NULL, address_id INT NOT NULL, brand_name VARCHAR(255) DEFAULT NULL, contact_email VARCHAR(255) DEFAULT NULL, phone VARCHAR(10) DEFAULT NULL, image_name VARCHAR(255) NOT NULL, image_size INT NOT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL, description LONGTEXT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, INDEX IDX_976449DC70BEE6D (visitor_id), UNIQUE INDEX UNIQ_976449DCF5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXISTS product (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, producer_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, prix DOUBLE PRECISION NOT NULL, description LONGTEXT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL, slug VARCHAR(50) NOT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), INDEX IDX_D34A04AD89B658FE (producer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXISTS user (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, phone VARCHAR(10) DEFAULT NULL, discr VARCHAR(255) NOT NULL, INDEX IDX_8D93D649F5B7AF75 (address_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXISTS visitor (id INT NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXISTS messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE producer ADD CONSTRAINT FK_976449DC70BEE6D FOREIGN KEY (visitor_id) REFERENCES visitor (id)');
        $this->addSql('ALTER TABLE producer ADD CONSTRAINT FK_976449DCF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD89B658FE FOREIGN KEY (producer_id) REFERENCES producer (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE visitor ADD CONSTRAINT FK_CAE5E19FBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE producer DROP FOREIGN KEY FK_976449DC70BEE6D');
        $this->addSql('ALTER TABLE producer DROP FOREIGN KEY FK_976449DCF5B7AF75');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD89B658FE');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F5B7AF75');
        $this->addSql('ALTER TABLE visitor DROP FOREIGN KEY FK_CAE5E19FBF396750');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE producer');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE visitor');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
