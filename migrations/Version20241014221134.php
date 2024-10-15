<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241014221134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment ADD coach_id INT NOT NULL');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8443C105691 FOREIGN KEY (coach_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_FE38F8443C105691 ON appointment (coach_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F8443C105691');
        $this->addSql('DROP INDEX IDX_FE38F8443C105691 ON appointment');
        $this->addSql('ALTER TABLE appointment DROP coach_id');
    }
}
