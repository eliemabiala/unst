<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241110083013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE step ADD user_id INT DEFAULT NULL, DROP email');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_43B9FE3CA76ED395 ON step (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3CA76ED395');
        $this->addSql('DROP INDEX IDX_43B9FE3CA76ED395 ON step');
        $this->addSql('ALTER TABLE step ADD email VARCHAR(180) DEFAULT NULL, DROP user_id');
    }
}
