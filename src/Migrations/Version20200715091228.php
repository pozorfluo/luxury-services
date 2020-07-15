<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200715091228 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, admin_note_id INT DEFAULT NULL, job_sector_id INT NOT NULL, description LONGTEXT NOT NULL, is_active TINYINT(1) NOT NULL, title VARCHAR(255) NOT NULL, type VARCHAR(64) NOT NULL, location VARCHAR(255) DEFAULT NULL, closing_date DATE DEFAULT NULL, salary INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_FBD8E0F819EB6921 (client_id), UNIQUE INDEX UNIQ_FBD8E0F8E2D18ADC (admin_note_id), INDEX IDX_FBD8E0F819252776 (job_sector_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE application (profile_id INT NOT NULL, job_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_A45BDDC1CCFA12B8 (profile_id), INDEX IDX_A45BDDC1BE04EA9 (job_id), PRIMARY KEY(profile_id, job_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, admin_note_id INT DEFAULT NULL, job_sector_id INT DEFAULT NULL, company_name VARCHAR(255) NOT NULL, contact_name VARCHAR(255) NOT NULL, contact_position VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(32) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_C7440455E2D18ADC (admin_note_id), INDEX IDX_C744045519252776 (job_sector_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin_note (id INT AUTO_INCREMENT NOT NULL, content VARCHAR(512) DEFAULT NULL, files JSON DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, admin_note_id INT DEFAULT NULL, job_sector_id INT DEFAULT NULL, first_name VARCHAR(64) DEFAULT NULL, last_name VARCHAR(64) DEFAULT NULL, gender VARCHAR(64) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, country VARCHAR(64) DEFAULT NULL, nationality VARCHAR(255) DEFAULT NULL, has_passport TINYINT(1) DEFAULT NULL, passport_scan VARCHAR(255) DEFAULT NULL, curriculum_vitae VARCHAR(255) DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, current_location VARCHAR(255) DEFAULT NULL, date_of_birth DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', place_of_birth VARCHAR(64) DEFAULT NULL, is_available TINYINT(1) DEFAULT NULL, experience VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:dateinterval)\', description VARCHAR(512) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8157AA0FE2D18ADC (admin_note_id), INDEX IDX_8157AA0F19252776 (job_sector_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_sector (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F819EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8E2D18ADC FOREIGN KEY (admin_note_id) REFERENCES admin_note (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F819252776 FOREIGN KEY (job_sector_id) REFERENCES job_sector (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455E2D18ADC FOREIGN KEY (admin_note_id) REFERENCES admin_note (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045519252776 FOREIGN KEY (job_sector_id) REFERENCES job_sector (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FE2D18ADC FOREIGN KEY (admin_note_id) REFERENCES admin_note (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F19252776 FOREIGN KEY (job_sector_id) REFERENCES job_sector (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1BE04EA9');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F819EB6921');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8E2D18ADC');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455E2D18ADC');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FE2D18ADC');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1CCFA12B8');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F819252776');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045519252776');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F19252776');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE application');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE admin_note');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE job_sector');
    }
}
