<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250107123243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B5A26E0835B09BF7 ON passport (number_passport)');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_43B9FE3CA76ED395 ON step (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3CA76ED395');
        $this->addSql('DROP INDEX IDX_43B9FE3CA76ED395 ON step');
        $this->addSql('DROP INDEX UNIQ_B5A26E0835B09BF7 ON passport');
    }
}
