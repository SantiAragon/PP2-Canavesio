<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240730230029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recipe_machine (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_machine_parts (recipe_machine_id INT NOT NULL, parts_id INT NOT NULL, INDEX IDX_D03A724BBFC9DD45 (recipe_machine_id), INDEX IDX_D03A724B4E81F03D (parts_id), PRIMARY KEY(recipe_machine_id, parts_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_machine_product (recipe_machine_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_BC41C171BFC9DD45 (recipe_machine_id), INDEX IDX_BC41C1714584665A (product_id), PRIMARY KEY(recipe_machine_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_product_parts (recipe_product_id INT NOT NULL, parts_id INT NOT NULL, INDEX IDX_58E9CA64CFAE039 (recipe_product_id), INDEX IDX_58E9CA644E81F03D (parts_id), PRIMARY KEY(recipe_product_id, parts_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipe_machine_parts ADD CONSTRAINT FK_D03A724BBFC9DD45 FOREIGN KEY (recipe_machine_id) REFERENCES recipe_machine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_machine_parts ADD CONSTRAINT FK_D03A724B4E81F03D FOREIGN KEY (parts_id) REFERENCES parts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_machine_product ADD CONSTRAINT FK_BC41C171BFC9DD45 FOREIGN KEY (recipe_machine_id) REFERENCES recipe_machine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_machine_product ADD CONSTRAINT FK_BC41C1714584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_product_parts ADD CONSTRAINT FK_58E9CA64CFAE039 FOREIGN KEY (recipe_product_id) REFERENCES recipe_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_product_parts ADD CONSTRAINT FK_58E9CA644E81F03D FOREIGN KEY (parts_id) REFERENCES parts (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe_machine_parts DROP FOREIGN KEY FK_D03A724BBFC9DD45');
        $this->addSql('ALTER TABLE recipe_machine_parts DROP FOREIGN KEY FK_D03A724B4E81F03D');
        $this->addSql('ALTER TABLE recipe_machine_product DROP FOREIGN KEY FK_BC41C171BFC9DD45');
        $this->addSql('ALTER TABLE recipe_machine_product DROP FOREIGN KEY FK_BC41C1714584665A');
        $this->addSql('ALTER TABLE recipe_product_parts DROP FOREIGN KEY FK_58E9CA64CFAE039');
        $this->addSql('ALTER TABLE recipe_product_parts DROP FOREIGN KEY FK_58E9CA644E81F03D');
        $this->addSql('DROP TABLE recipe_machine');
        $this->addSql('DROP TABLE recipe_machine_parts');
        $this->addSql('DROP TABLE recipe_machine_product');
        $this->addSql('DROP TABLE recipe_product');
        $this->addSql('DROP TABLE recipe_product_parts');
    }
}
