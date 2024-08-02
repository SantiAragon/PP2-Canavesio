<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801140509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe_machine_product DROP FOREIGN KEY FK_BC41C1714584665A');
        $this->addSql('ALTER TABLE recipe_machine_product DROP FOREIGN KEY FK_BC41C171BFC9DD45');
        $this->addSql('ALTER TABLE recipe_machine_parts DROP FOREIGN KEY FK_D03A724B4E81F03D');
        $this->addSql('ALTER TABLE recipe_machine_parts DROP FOREIGN KEY FK_D03A724BBFC9DD45');
        $this->addSql('DROP TABLE recipe_machine_product');
        $this->addSql('DROP TABLE recipe_machine_parts');
        $this->addSql('ALTER TABLE recipe_machine ADD parts JSON NOT NULL, ADD products JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recipe_machine_product (recipe_machine_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_BC41C171BFC9DD45 (recipe_machine_id), INDEX IDX_BC41C1714584665A (product_id), PRIMARY KEY(recipe_machine_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE recipe_machine_parts (recipe_machine_id INT NOT NULL, parts_id INT NOT NULL, INDEX IDX_D03A724BBFC9DD45 (recipe_machine_id), INDEX IDX_D03A724B4E81F03D (parts_id), PRIMARY KEY(recipe_machine_id, parts_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE recipe_machine_product ADD CONSTRAINT FK_BC41C1714584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_machine_product ADD CONSTRAINT FK_BC41C171BFC9DD45 FOREIGN KEY (recipe_machine_id) REFERENCES recipe_machine (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_machine_parts ADD CONSTRAINT FK_D03A724B4E81F03D FOREIGN KEY (parts_id) REFERENCES parts (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_machine_parts ADD CONSTRAINT FK_D03A724BBFC9DD45 FOREIGN KEY (recipe_machine_id) REFERENCES recipe_machine (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_machine DROP parts, DROP products');
    }
}
