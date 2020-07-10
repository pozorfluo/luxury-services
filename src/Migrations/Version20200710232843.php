<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200710232843 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE annotated_item (id INT AUTO_INCREMENT NOT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, admin_note_id INT DEFAULT NULL, job_sector_id INT DEFAULT NULL, company_name VARCHAR(255) NOT NULL, contact_name VARCHAR(255) NOT NULL, contact_position VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(32) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_C7440455E2D18ADC (admin_note_id), INDEX IDX_C744045519252776 (job_sector_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_sector (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job (id INT NOT NULL, client_id INT NOT NULL, admin_note_id INT DEFAULT NULL, job_sector_id INT NOT NULL, description LONGTEXT NOT NULL, is_active TINYINT(1) NOT NULL, title VARCHAR(255) NOT NULL, type VARCHAR(64) NOT NULL, location VARCHAR(255) DEFAULT NULL, closing_date DATE DEFAULT NULL, salary INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_FBD8E0F819EB6921 (client_id), UNIQUE INDEX UNIQ_FBD8E0F8E2D18ADC (admin_note_id), INDEX IDX_FBD8E0F819252776 (job_sector_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE application (profile_id INT NOT NULL, job_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_A45BDDC1CCFA12B8 (profile_id), INDEX IDX_A45BDDC1BE04EA9 (job_id), PRIMARY KEY(profile_id, job_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455E2D18ADC FOREIGN KEY (admin_note_id) REFERENCES admin_note (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045519252776 FOREIGN KEY (job_sector_id) REFERENCES job_sector (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455BF396750 FOREIGN KEY (id) REFERENCES annotated_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F819EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8E2D18ADC FOREIGN KEY (admin_note_id) REFERENCES admin_note (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F819252776 FOREIGN KEY (job_sector_id) REFERENCES job_sector (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8BF396750 FOREIGN KEY (id) REFERENCES annotated_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin_note CHANGE content content VARCHAR(512) DEFAULT NULL, CHANGE files files JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE profile ADD job_sector_id INT DEFAULT NULL, CHANGE id id INT NOT NULL, CHANGE admin_note_id admin_note_id INT DEFAULT NULL, CHANGE first_name first_name VARCHAR(64) DEFAULT NULL, CHANGE last_name last_name VARCHAR(64) DEFAULT NULL, CHANGE gender gender VARCHAR(64) DEFAULT NULL, CHANGE address address VARCHAR(255) DEFAULT NULL, CHANGE country country VARCHAR(64) DEFAULT NULL, CHANGE nationality nationality VARCHAR(255) DEFAULT NULL, CHANGE has_passport has_passport TINYINT(1) DEFAULT NULL, CHANGE passport_scan passport_scan VARCHAR(255) DEFAULT NULL, CHANGE curriculum_vitae curriculum_vitae VARCHAR(255) DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL, CHANGE current_location current_location VARCHAR(255) DEFAULT NULL, CHANGE date_of_birth date_of_birth DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE place_of_birth place_of_birth VARCHAR(64) DEFAULT NULL, CHANGE is_available is_available TINYINT(1) DEFAULT NULL, CHANGE experience experience VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:dateinterval)\', CHANGE description description VARCHAR(512) DEFAULT NULL, CHANGE deleted_at deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F19252776 FOREIGN KEY (job_sector_id) REFERENCES job_sector (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FBF396750 FOREIGN KEY (id) REFERENCES annotated_item (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_8157AA0F19252776 ON profile (job_sector_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455BF396750');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8BF396750');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FBF396750');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F819EB6921');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045519252776');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F819252776');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F19252776');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1BE04EA9');
        $this->addSql('DROP TABLE annotated_item');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE job_sector');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE application');
        $this->addSql('ALTER TABLE admin_note CHANGE content content VARCHAR(512) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE files files LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('DROP INDEX IDX_8157AA0F19252776 ON profile');
        $this->addSql('ALTER TABLE profile DROP job_sector_id, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE admin_note_id admin_note_id INT DEFAULT NULL, CHANGE first_name first_name VARCHAR(64) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE last_name last_name VARCHAR(64) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE gender gender VARCHAR(64) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE address address VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE country country VARCHAR(64) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE nationality nationality VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE has_passport has_passport TINYINT(1) DEFAULT \'NULL\', CHANGE passport_scan passport_scan VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE curriculum_vitae curriculum_vitae VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE picture picture VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE current_location current_location VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE date_of_birth date_of_birth DATE DEFAULT \'NULL\' COMMENT \'(DC2Type:date_immutable)\', CHANGE place_of_birth place_of_birth VARCHAR(64) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE is_available is_available TINYINT(1) DEFAULT \'NULL\', CHANGE experience experience VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:dateinterval)\', CHANGE description description VARCHAR(512) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE deleted_at deleted_at DATETIME DEFAULT \'NULL\'');
    }
}
