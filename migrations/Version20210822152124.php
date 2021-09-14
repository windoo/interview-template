<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210822152124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE idea (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, suggester_id INTEGER NOT NULL, proposal VARCHAR(255) NOT NULL, create_at DATETIME NOT NULL, in_favor INTEGER NOT NULL, against INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_A8BCA4570913F08 ON idea (suggester_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE TABLE user_idea (user_id INTEGER NOT NULL, idea_id INTEGER NOT NULL, PRIMARY KEY(user_id, idea_id))');
        $this->addSql('CREATE INDEX IDX_700A868CA76ED395 ON user_idea (user_id)');
        $this->addSql('CREATE INDEX IDX_700A868C5B6FEF7D ON user_idea (idea_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE idea');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_idea');
    }
}
