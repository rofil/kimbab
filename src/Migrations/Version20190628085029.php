<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190628085029 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lecturer DROP FOREIGN KEY FK_14CF5146680CAB68');
        $this->addSql('ALTER TABLE program DROP FOREIGN KEY FK_92ED7784680CAB68');
        $this->addSql('CREATE TABLE units (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, abbreviation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contract (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, partner VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, total DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE faculty');
        $this->addSql('DROP INDEX IDX_14CF5146680CAB68 ON lecturer');
        $this->addSql('ALTER TABLE lecturer CHANGE faculty_id unit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lecturer ADD CONSTRAINT FK_14CF5146F8BD700D FOREIGN KEY (unit_id) REFERENCES units (id)');
        $this->addSql('CREATE INDEX IDX_14CF5146F8BD700D ON lecturer (unit_id)');
        $this->addSql('ALTER TABLE information CHANGE created_at created_at DATETIME DEFAULT \'2019-02-01\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'2019-02-01\' NOT NULL');
        $this->addSql('DROP INDEX IDX_92ED7784680CAB68 ON program');
        $this->addSql('ALTER TABLE program CHANGE faculty_id unit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED7784F8BD700D FOREIGN KEY (unit_id) REFERENCES units (id)');
        $this->addSql('CREATE INDEX IDX_92ED7784F8BD700D ON program (unit_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lecturer DROP FOREIGN KEY FK_14CF5146F8BD700D');
        $this->addSql('ALTER TABLE program DROP FOREIGN KEY FK_92ED7784F8BD700D');
        $this->addSql('CREATE TABLE faculty (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, abbreviation VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE units');
        $this->addSql('DROP TABLE contract');
        $this->addSql('ALTER TABLE information CHANGE created_at created_at DATETIME DEFAULT \'2019-02-01 00:00:00\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'2019-02-01 00:00:00\' NOT NULL');
        $this->addSql('DROP INDEX IDX_14CF5146F8BD700D ON lecturer');
        $this->addSql('ALTER TABLE lecturer CHANGE unit_id faculty_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lecturer ADD CONSTRAINT FK_14CF5146680CAB68 FOREIGN KEY (faculty_id) REFERENCES faculty (id)');
        $this->addSql('CREATE INDEX IDX_14CF5146680CAB68 ON lecturer (faculty_id)');
        $this->addSql('DROP INDEX IDX_92ED7784F8BD700D ON program');
        $this->addSql('ALTER TABLE program CHANGE unit_id faculty_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED7784680CAB68 FOREIGN KEY (faculty_id) REFERENCES faculty (id)');
        $this->addSql('CREATE INDEX IDX_92ED7784680CAB68 ON program (faculty_id)');
    }
}
