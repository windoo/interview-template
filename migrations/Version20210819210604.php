<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210819210604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, title, url, message, votes, created_at FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, title VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE BINARY, url VARCHAR(255) DEFAULT NULL COLLATE BINARY, message VARCHAR(255) DEFAULT NULL COLLATE BINARY, votes INTEGER DEFAULT 0 NOT NULL, created_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO post (id, title, url, message, votes, created_at) SELECT id, title, url, message, votes, created_at FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DA76ED395 ON post (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_5A8A6C8DA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, title, url, message, votes, created_at FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) DEFAULT \'\' NOT NULL, url VARCHAR(255) DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, votes INTEGER DEFAULT 0 NOT NULL, created_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO post (id, title, url, message, votes, created_at) SELECT id, title, url, message, votes, created_at FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
    }
}