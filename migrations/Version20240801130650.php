<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801130650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD sku VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product ADD stock_quantity INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD discount NUMERIC(5, 2) NOT NULL');
        $this->addSql('ALTER TABLE product ADD category VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product ADD rating DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE product ADD number_of_reviews INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD is_active BOOLEAN NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE product DROP sku');
        $this->addSql('ALTER TABLE product DROP stock_quantity');
        $this->addSql('ALTER TABLE product DROP discount');
        $this->addSql('ALTER TABLE product DROP category');
        $this->addSql('ALTER TABLE product DROP rating');
        $this->addSql('ALTER TABLE product DROP number_of_reviews');
        $this->addSql('ALTER TABLE product DROP is_active');
    }
}
