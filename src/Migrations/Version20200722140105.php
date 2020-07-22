<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200722140105 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE admin_note CHANGE content content VARCHAR(512) DEFAULT NULL, CHANGE files files JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE client CHANGE admin_note_id admin_note_id INT DEFAULT NULL, CHANGE job_sector_id job_sector_id INT DEFAULT NULL, CHANGE contact_position contact_position VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE phone phone VARCHAR(32) DEFAULT NULL');
        $this->addSql('ALTER TABLE job CHANGE admin_note_id admin_note_id INT DEFAULT NULL, CHANGE location location VARCHAR(255) DEFAULT NULL, CHANGE closing_date closing_date DATE DEFAULT NULL, CHANGE salary salary INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile CHANGE admin_note_id admin_note_id INT DEFAULT NULL, CHANGE job_sector_id job_sector_id INT DEFAULT NULL, CHANGE first_name first_name VARCHAR(64) DEFAULT NULL, CHANGE last_name last_name VARCHAR(64) DEFAULT NULL, CHANGE gender gender VARCHAR(64) DEFAULT NULL, CHANGE address address VARCHAR(255) DEFAULT NULL, CHANGE country country VARCHAR(64) DEFAULT NULL, CHANGE nationality nationality VARCHAR(255) DEFAULT NULL, CHANGE has_passport has_passport TINYINT(1) DEFAULT NULL, CHANGE passport_scan passport_scan VARCHAR(255) DEFAULT NULL, CHANGE curriculum_vitae curriculum_vitae VARCHAR(255) DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL, CHANGE current_location current_location VARCHAR(255) DEFAULT NULL, CHANGE date_of_birth date_of_birth DATE DEFAULT NULL, CHANGE place_of_birth place_of_birth VARCHAR(64) DEFAULT NULL, CHANGE is_available is_available TINYINT(1) DEFAULT NULL, CHANGE experience experience VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:dateinterval)\', CHANGE description description VARCHAR(512) DEFAULT NULL, CHANGE deleted_at deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE admin_note CHANGE content content VARCHAR(512) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE files files LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE client CHANGE admin_note_id admin_note_id INT DEFAULT NULL, CHANGE job_sector_id job_sector_id INT DEFAULT NULL, CHANGE contact_position contact_position VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE phone phone VARCHAR(32) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE job CHANGE admin_note_id admin_note_id INT DEFAULT NULL, CHANGE location location VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE closing_date closing_date DATE DEFAULT \'NULL\', CHANGE salary salary INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile CHANGE admin_note_id admin_note_id INT DEFAULT NULL, CHANGE job_sector_id job_sector_id INT DEFAULT NULL, CHANGE first_name first_name VARCHAR(64) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE last_name last_name VARCHAR(64) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE gender gender VARCHAR(64) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE address address VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE country country VARCHAR(64) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE nationality nationality VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE has_passport has_passport TINYINT(1) DEFAULT \'NULL\', CHANGE passport_scan passport_scan VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE curriculum_vitae curriculum_vitae VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE picture picture VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE current_location current_location VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE date_of_birth date_of_birth DATE DEFAULT \'NULL\', CHANGE place_of_birth place_of_birth VARCHAR(64) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE is_available is_available TINYINT(1) DEFAULT \'NULL\', CHANGE experience experience VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:dateinterval)\', CHANGE description description VARCHAR(512) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE deleted_at deleted_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
