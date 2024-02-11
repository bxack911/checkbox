<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240211174313 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE author ADD book_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE author ADD CONSTRAINT FK_BDAFD8C816A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_BDAFD8C816A2B381 ON author (book_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE author DROP CONSTRAINT FK_BDAFD8C816A2B381');
        $this->addSql('DROP INDEX IDX_BDAFD8C816A2B381');
        $this->addSql('ALTER TABLE author DROP book_id');
    }
}
