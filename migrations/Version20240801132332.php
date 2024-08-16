<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801132332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD is_featured BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE product ADD is_new_arrival BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE product ADD is_on_promotion BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE product ADD promotion_start_date TIMESTAMP(0) WITH TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE product ADD promotion_end_date TIMESTAMP(0) WITH TIME ZONE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE product DROP is_featured');
        $this->addSql('ALTER TABLE product DROP is_new_arrival');
        $this->addSql('ALTER TABLE product DROP is_on_promotion');
        $this->addSql('ALTER TABLE product DROP promotion_start_date');
        $this->addSql('ALTER TABLE product DROP promotion_end_date');
    }
}
