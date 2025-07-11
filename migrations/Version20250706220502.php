<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250706220502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE email_statuses (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE emails (id SERIAL NOT NULL, status_id INT NOT NULL, "from" VARCHAR(255) NOT NULL, "to" VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, body TEXT NOT NULL, hash VARCHAR(64) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, sent_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C81E852D1B862B8 ON emails (hash)');
        $this->addSql('CREATE INDEX IDX_4C81E8526BF700BD ON emails (status_id)');
        $this->addSql('ALTER TABLE emails ADD CONSTRAINT FK_4C81E8526BF700BD FOREIGN KEY (status_id) REFERENCES email_statuses (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql("INSERT INTO email_statuses (id, name) VALUES (1, 'pending')");
        $this->addSql("INSERT INTO email_statuses (id, name) VALUES (2, 'sent')");
        $this->addSql("INSERT INTO email_statuses (id, name) VALUES (3, 'failed')");
        $this->addSql("INSERT INTO email_statuses (id, name) VALUES (4, 'retry')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE emails DROP CONSTRAINT FK_4C81E8526BF700BD');
        $this->addSql('DROP TABLE email_statuses');
        $this->addSql('DROP TABLE emails');
    }
}
