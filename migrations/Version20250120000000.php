<?php

declare(strict_types=1);

namespace Pobj\Api\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250120000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adiciona colunas data_realizado e id_familia na tabela f_pontos e cria índices';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE f_pontos ADD COLUMN data_realizado DATE NULL AFTER realizado');
        $this->addSql('ALTER TABLE f_pontos ADD COLUMN id_familia INT NULL AFTER id_indicador');
        $this->addSql('CREATE INDEX idx_fp_data_realizado ON f_pontos (data_realizado)');
        $this->addSql('CREATE INDEX idx_fp_id_familia ON f_pontos (id_familia)');
        $this->addSql('CREATE INDEX idx_fp_familia_indicador ON f_pontos (id_familia, id_indicador)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX idx_fp_familia_indicador ON f_pontos');
        $this->addSql('DROP INDEX idx_fp_id_familia ON f_pontos');
        $this->addSql('DROP INDEX idx_fp_data_realizado ON f_pontos');
        $this->addSql('ALTER TABLE f_pontos DROP COLUMN id_familia');
        $this->addSql('ALTER TABLE f_pontos DROP COLUMN data_realizado');
    }
}

