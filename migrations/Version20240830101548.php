<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240830101548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE step ADD documents_id INT NOT NULL');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C5F0F2752 FOREIGN KEY (documents_id) REFERENCES documents (id)');
        $this->addSql('CREATE INDEX IDX_43B9FE3C5F0F2752 ON step (documents_id)');
        $this->addSql('ALTER TABLE user ADD documents_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495F0F2752 FOREIGN KEY (documents_id) REFERENCES documents (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6495F0F2752 ON user (documents_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495F0F2752');
        $this->addSql('DROP INDEX IDX_8D93D6495F0F2752 ON user');
        $this->addSql('ALTER TABLE user DROP documents_id');
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3C5F0F2752');
        $this->addSql('DROP INDEX IDX_43B9FE3C5F0F2752 ON step');
        $this->addSql('ALTER TABLE step DROP documents_id');
    }
}
