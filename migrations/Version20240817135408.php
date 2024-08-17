<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240817135408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment CHANGE date_update date_update DATE DEFAULT NULL, CHANGE creation_date creation_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE passport ADD date_expiration DATE DEFAULT NULL, ADD nationalite VARCHAR(100) DEFAULT NULL, DROP date_expira, DROP nationalité, CHANGE number_passport number_passport VARCHAR(100) NOT NULL, CHANGE profession profession VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE profile CHANGE date_creation date_creation DATE DEFAULT NULL, CHANGE date_inscrit date_inscrit DATE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment CHANGE date_update date_update VARCHAR(100) NOT NULL, CHANGE creation_date creation_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE passport ADD date_expira BIGINT NOT NULL, ADD nationalité VARCHAR(100) NOT NULL, DROP date_expiration, DROP nationalite, CHANGE number_passport number_passport BIGINT NOT NULL, CHANGE profession profession VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE profile CHANGE date_creation date_creation BIGINT NOT NULL, CHANGE date_inscrit date_inscrit BIGINT NOT NULL');
    }
}
