<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190628001028 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE additional_output_lecturer (id INT AUTO_INCREMENT NOT NULL, lecturer_id INT DEFAULT NULL, additional_output_id INT DEFAULT NULL, order_number INT DEFAULT NULL, INDEX IDX_3E3E09EABA2D8762 (lecturer_id), INDEX IDX_3E3E09EAB103DEDD (additional_output_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE additional_output_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE additional_output (id INT AUTO_INCREMENT NOT NULL, uploader_id INT DEFAULT NULL, year_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, document VARCHAR(255) DEFAULT NULL, INDEX IDX_9D7CE6DF16678C77 (uploader_id), INDEX IDX_9D7CE6DF40C1FEA7 (year_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE additional_output_lecturer ADD CONSTRAINT FK_3E3E09EABA2D8762 FOREIGN KEY (lecturer_id) REFERENCES lecturer (id)');
        $this->addSql('ALTER TABLE additional_output_lecturer ADD CONSTRAINT FK_3E3E09EAB103DEDD FOREIGN KEY (additional_output_id) REFERENCES additional_output (id)');
        $this->addSql('ALTER TABLE additional_output ADD CONSTRAINT FK_9D7CE6DF16678C77 FOREIGN KEY (uploader_id) REFERENCES lecturer (id)');
        $this->addSql('ALTER TABLE additional_output ADD CONSTRAINT FK_9D7CE6DF40C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('ALTER TABLE information CHANGE created_at created_at DATETIME DEFAULT \'2019-02-01\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'2019-02-01\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE additional_output_lecturer DROP FOREIGN KEY FK_3E3E09EAB103DEDD');
        $this->addSql('DROP TABLE additional_output_lecturer');
        $this->addSql('DROP TABLE additional_output_category');
        $this->addSql('DROP TABLE additional_output');
        $this->addSql('ALTER TABLE information CHANGE created_at created_at DATETIME DEFAULT \'2019-02-01 00:00:00\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'2019-02-01 00:00:00\' NOT NULL');
    }
}
