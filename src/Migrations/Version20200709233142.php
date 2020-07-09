<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200709233142 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE admin_note (id INT AUTO_INCREMENT NOT NULL, content VARCHAR(512) DEFAULT NULL, files JSON DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, admin_note_id INT DEFAULT NULL, first_name VARCHAR(64) DEFAULT NULL, last_name VARCHAR(64) DEFAULT NULL, gender VARCHAR(64) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, country VARCHAR(64) DEFAULT NULL, nationality VARCHAR(255) DEFAULT NULL, has_passport TINYINT(1) DEFAULT NULL, passport_scan VARCHAR(255) DEFAULT NULL, curriculum_vitae VARCHAR(255) DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, current_location VARCHAR(255) DEFAULT NULL, date_of_birth DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', place_of_birth VARCHAR(64) DEFAULT NULL, is_available TINYINT(1) DEFAULT NULL, experience VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:dateinterval)\', description VARCHAR(512) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8157AA0FE2D18ADC (admin_note_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FE2D18ADC FOREIGN KEY (admin_note_id) REFERENCES admin_note (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FE2D18ADC');
        $this->addSql('DROP TABLE admin_note');
        $this->addSql('DROP TABLE profile');
    }
}
