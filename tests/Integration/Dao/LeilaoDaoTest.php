<?php

namespace Alura\Leilao\Tests\Integration\Dao;

use Alura\Leilao\Model\Leilao;
use PHPUnit\Framework\TestCase;
use Alura\Leilao\Dao\Leilao as LeilaoDao;
use Alura\Leilao\Infra\ConnectionCreator;

class LeilaoDaoTest extends TestCase
{
    /**
     * @var \PDO
     */
    private $pdo;
    protected function setUp() : void
    {
        $this->pdo = ConnectionCreator::getConnection();
        $this->pdo->beginTransaction();
    }

    public function testInsercaoEBuscaDevemFuncionar()
    {
        $leilao = new Leilao('Fiat 147 0KM');
        
        $leilaoDao = new LeilaoDao($this->pdo);

        $leilaoDao->salva($leilao);
        $leiloes = $leilaoDao->recuperarNaoFinalizados();

        self::assertCount(1, $leiloes);
        self::assertContainsOnlyInstancesOf(Leilao::class, $leiloes);
        self::assertSame('Fiat 147 0KM', $leiloes[0]->recuperarDescricao());
    }

    protected function tearDown() : void
    {
        $this->pdo->rollBack();
    }
}