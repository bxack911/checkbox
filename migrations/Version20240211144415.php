<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240211144415 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE book (id INT GENERATED BY DEFAULT AS IDENTITY NOT NULL, name VARCHAR(60) NOT NULL, description TEXT NOT NULL, publish_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, image_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CBE5A3313DA5256D ON book (image_id)');
        $this->addSql('CREATE TABLE media_object (id INT GENERATED BY DEFAULT AS IDENTITY NOT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3313DA5256D FOREIGN KEY (image_id) REFERENCES media_object (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A3313DA5256D');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE media_object');
    }
}
