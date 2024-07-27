<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240727210027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parts (id INT AUTO_INCREMENT NOT NULL, quantity INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parts_product (parts_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_549511184E81F03D (parts_id), INDEX IDX_549511184584665A (product_id), PRIMARY KEY(parts_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parts_product ADD CONSTRAINT FK_549511184E81F03D FOREIGN KEY (parts_id) REFERENCES parts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parts_product ADD CONSTRAINT FK_549511184584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parts_product DROP FOREIGN KEY FK_549511184E81F03D');
        $this->addSql('ALTER TABLE parts_product DROP FOREIGN KEY FK_549511184584665A');
        $this->addSql('DROP TABLE parts');
        $this->addSql('DROP TABLE parts_product');
    }
}
