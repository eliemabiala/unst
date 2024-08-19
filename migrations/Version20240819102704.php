<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240819102704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_FE38F844A76ED395 ON appointment (user_id)');
        $this->addSql('ALTER TABLE profile ADD passport_id INT NOT NULL');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FABF410D0 FOREIGN KEY (passport_id) REFERENCES passport (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8157AA0FABF410D0 ON profile (passport_id)');
        $this->addSql('ALTER TABLE user ADD profile_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649CCFA12B8 ON user (profile_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844A76ED395');
        $this->addSql('DROP INDEX IDX_FE38F844A76ED395 ON appointment');
        $this->addSql('ALTER TABLE appointment DROP user_id');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FABF410D0');
        $this->addSql('DROP INDEX UNIQ_8157AA0FABF410D0 ON profile');
        $this->addSql('ALTER TABLE profile DROP passport_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649CCFA12B8');
        $this->addSql('DROP INDEX UNIQ_8D93D649CCFA12B8 ON user');
        $this->addSql('ALTER TABLE user DROP profile_id');
    }
}
