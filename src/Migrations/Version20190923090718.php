<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190923090718 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE researches_lecturers (id INT AUTO_INCREMENT NOT NULL, research_id INT NOT NULL, lecturer_id INT DEFAULT NULL, INDEX IDX_9B4785837909E1ED (research_id), INDEX IDX_9B478583BA2D8762 (lecturer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE researches_lecturers ADD CONSTRAINT FK_9B4785837909E1ED FOREIGN KEY (research_id) REFERENCES research (id)');
        $this->addSql('ALTER TABLE researches_lecturers ADD CONSTRAINT FK_9B478583BA2D8762 FOREIGN KEY (lecturer_id) REFERENCES lecturer (id)');
        $this->addSql('ALTER TABLE information CHANGE created_at created_at DATETIME DEFAULT \'2019-02-01\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'2019-02-01\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE researches_lecturers');
        $this->addSql('ALTER TABLE information CHANGE created_at created_at DATETIME DEFAULT \'2019-02-01 00:00:00\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'2019-02-01 00:00:00\' NOT NULL');
    }
}
