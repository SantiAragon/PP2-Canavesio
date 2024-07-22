<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240722170354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart_product_order ADD orders_id INT NOT NULL');
        $this->addSql('ALTER TABLE cart_product_order ADD CONSTRAINT FK_606DBEAACFFE9AD6 FOREIGN KEY (orders_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_606DBEAACFFE9AD6 ON cart_product_order (orders_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart_product_order DROP FOREIGN KEY FK_606DBEAACFFE9AD6');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP INDEX IDX_606DBEAACFFE9AD6 ON cart_product_order');
        $this->addSql('ALTER TABLE cart_product_order DROP orders_id');
    }
}
