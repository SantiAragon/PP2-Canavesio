<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240727214324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_favorite_product DROP FOREIGN KEY FK_F30BE81EF6B75B26');
        $this->addSql('DROP INDEX IDX_F30BE81EF6B75B26 ON user_favorite_product');
        $this->addSql('ALTER TABLE user_favorite_product DROP machine_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_favorite_product ADD machine_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_favorite_product ADD CONSTRAINT FK_F30BE81EF6B75B26 FOREIGN KEY (machine_id) REFERENCES machine (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F30BE81EF6B75B26 ON user_favorite_product (machine_id)');
    }
}
