<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801134603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe_product_parts DROP FOREIGN KEY FK_58E9CA644E81F03D');
        $this->addSql('ALTER TABLE recipe_product_parts DROP FOREIGN KEY FK_58E9CA64CFAE039');
        $this->addSql('DROP TABLE recipe_product_parts');
        $this->addSql('ALTER TABLE recipe_product ADD parts JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recipe_product_parts (recipe_product_id INT NOT NULL, parts_id INT NOT NULL, INDEX IDX_58E9CA644E81F03D (parts_id), INDEX IDX_58E9CA64CFAE039 (recipe_product_id), PRIMARY KEY(recipe_product_id, parts_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE recipe_product_parts ADD CONSTRAINT FK_58E9CA644E81F03D FOREIGN KEY (parts_id) REFERENCES parts (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_product_parts ADD CONSTRAINT FK_58E9CA64CFAE039 FOREIGN KEY (recipe_product_id) REFERENCES recipe_product (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_product DROP parts');
    }
}
