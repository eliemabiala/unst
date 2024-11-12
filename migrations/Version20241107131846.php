<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241107131846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3CA76ED395');
        $this->addSql('DROP INDEX IDX_43B9FE3CA76ED395 ON step');
        $this->addSql('ALTER TABLE step CHANGE title title VARCHAR(100) NOT NULL, CHANGE user_id documents_id INT NOT NULL');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C5F0F2752 FOREIGN KEY (documents_id) REFERENCES documents (id)');
        $this->addSql('CREATE INDEX IDX_43B9FE3C5F0F2752 ON step (documents_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3C5F0F2752');
        $this->addSql('DROP INDEX IDX_43B9FE3C5F0F2752 ON step');
        $this->addSql('ALTER TABLE step CHANGE title title VARCHAR(255) NOT NULL, CHANGE documents_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_43B9FE3CA76ED395 ON step (user_id)');
    }
}
