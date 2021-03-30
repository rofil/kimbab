<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190626074637 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE journal (id INT AUTO_INCREMENT NOT NULL, uploader_id INT DEFAULT NULL, year_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, name_of_journal VARCHAR(255) NOT NULL, volume INT DEFAULT NULL, number INT DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, document VARCHAR(255) DEFAULT NULL, classification INT NOT NULL, abstract LONGTEXT NOT NULL, level INT NOT NULL, pages VARCHAR(255) DEFAULT NULL, issn VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C1A7E74D16678C77 (uploader_id), INDEX IDX_C1A7E74D40C1FEA7 (year_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE journal ADD CONSTRAINT FK_C1A7E74D16678C77 FOREIGN KEY (uploader_id) REFERENCES lecturer (id)');
        $this->addSql('ALTER TABLE journal ADD CONSTRAINT FK_C1A7E74D40C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('ALTER TABLE information CHANGE created_at created_at DATETIME DEFAULT \'2019-02-01\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'2019-02-01\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE journal');
        $this->addSql('ALTER TABLE information CHANGE created_at created_at DATETIME DEFAULT \'2019-02-01 00:00:00\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'2019-02-01 00:00:00\' NOT NULL');
    }
}
