<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210820091726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_idea (user_id INTEGER NOT NULL, idea_id INTEGER NOT NULL, PRIMARY KEY(user_id, idea_id))');
        $this->addSql('CREATE INDEX IDX_700A868CA76ED395 ON user_idea (user_id)');
        $this->addSql('CREATE INDEX IDX_700A868C5B6FEF7D ON user_idea (idea_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_idea');
    }
}
