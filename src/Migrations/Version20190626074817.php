<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190626074817 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE journal_lecturer (id INT AUTO_INCREMENT NOT NULL, lecturer_id INT DEFAULT NULL, journal_id INT DEFAULT NULL, order_number INT DEFAULT NULL, INDEX IDX_C47FFCFFBA2D8762 (lecturer_id), INDEX IDX_C47FFCFF478E8802 (journal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE journal_lecturer ADD CONSTRAINT FK_C47FFCFFBA2D8762 FOREIGN KEY (lecturer_id) REFERENCES lecturer (id)');
        $this->addSql('ALTER TABLE journal_lecturer ADD CONSTRAINT FK_C47FFCFF478E8802 FOREIGN KEY (journal_id) REFERENCES journal (id)');
        $this->addSql('ALTER TABLE information CHANGE created_at created_at DATETIME DEFAULT \'2019-02-01\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'2019-02-01\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE journal_lecturer');
        $this->addSql('ALTER TABLE information CHANGE created_at created_at DATETIME DEFAULT \'2019-02-01 00:00:00\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'2019-02-01 00:00:00\' NOT NULL');
    }
}
