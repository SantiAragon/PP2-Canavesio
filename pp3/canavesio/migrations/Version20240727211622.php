<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240727211622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_parts_machine (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, parts_id INT DEFAULT NULL, quantity INT DEFAULT NULL, INDEX IDX_4837D6C34584665A (product_id), INDEX IDX_4837D6C34E81F03D (parts_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_parts_machine ADD CONSTRAINT FK_4837D6C34584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_parts_machine ADD CONSTRAINT FK_4837D6C34E81F03D FOREIGN KEY (parts_id) REFERENCES parts (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_parts_machine DROP FOREIGN KEY FK_4837D6C34584665A');
        $this->addSql('ALTER TABLE product_parts_machine DROP FOREIGN KEY FK_4837D6C34E81F03D');
        $this->addSql('DROP TABLE product_parts_machine');
    }
}
