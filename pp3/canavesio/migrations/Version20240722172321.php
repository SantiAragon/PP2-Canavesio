<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240722172321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, quantity INT DEFAULT NULL, price NUMERIC(10, 2) DEFAULT NULL, description VARCHAR(255) NOT NULL, brand VARCHAR(255) NOT NULL, image LONGBLOB NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart_product_order ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE cart_product_order ADD CONSTRAINT FK_606DBEAA4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_606DBEAA4584665A ON cart_product_order (product_id)');
        $this->addSql('ALTER TABLE user_favorite_product ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_favorite_product ADD CONSTRAINT FK_F30BE81E4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_F30BE81E4584665A ON user_favorite_product (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart_product_order DROP FOREIGN KEY FK_606DBEAA4584665A');
        $this->addSql('ALTER TABLE user_favorite_product DROP FOREIGN KEY FK_F30BE81E4584665A');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP INDEX IDX_606DBEAA4584665A ON cart_product_order');
        $this->addSql('ALTER TABLE cart_product_order DROP product_id');
        $this->addSql('DROP INDEX IDX_F30BE81E4584665A ON user_favorite_product');
        $this->addSql('ALTER TABLE user_favorite_product DROP product_id');
    }
}
