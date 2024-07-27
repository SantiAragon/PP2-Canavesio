<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240727212936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE machine (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, quantity INT NOT NULL, brand VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price NUMERIC(10, 2) DEFAULT NULL, image LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_parts_machine ADD machine_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_parts_machine ADD CONSTRAINT FK_4837D6C3F6B75B26 FOREIGN KEY (machine_id) REFERENCES machine (id)');
        $this->addSql('CREATE INDEX IDX_4837D6C3F6B75B26 ON product_parts_machine (machine_id)');
        $this->addSql('ALTER TABLE user_favorite_product ADD machine_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_favorite_product ADD CONSTRAINT FK_F30BE81EF6B75B26 FOREIGN KEY (machine_id) REFERENCES machine (id)');
        $this->addSql('CREATE INDEX IDX_F30BE81EF6B75B26 ON user_favorite_product (machine_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_parts_machine DROP FOREIGN KEY FK_4837D6C3F6B75B26');
        $this->addSql('ALTER TABLE user_favorite_product DROP FOREIGN KEY FK_F30BE81EF6B75B26');
        $this->addSql('DROP TABLE machine');
        $this->addSql('DROP INDEX IDX_4837D6C3F6B75B26 ON product_parts_machine');
        $this->addSql('ALTER TABLE product_parts_machine DROP machine_id');
        $this->addSql('DROP INDEX IDX_F30BE81EF6B75B26 ON user_favorite_product');
        $this->addSql('ALTER TABLE user_favorite_product DROP machine_id');
    }
}
