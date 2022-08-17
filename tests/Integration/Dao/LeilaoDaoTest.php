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
    private static $pdo;

    public static function setUpBeforeClass() : void
    {
        self::$pdo = new \PDO('sqlite::memory:');
        self::$pdo->exec(
            'create table leiloes (
                id integer primary key,
                descricao text,
                finalizado bool,
                dataInicio text
            );'
        );
    }

    protected function setUp() : void
    {
        self::$pdo->beginTransaction();
    }

    /**
     * @dataProvider leiloes
     */
    public function testBuscaLeiloesNaoFinalizados(array $leiloes)
    {
        $leilaoDao = new LeilaoDao(self::$pdo);
        foreach ($leiloes as $leilao) {
           $leilaoDao->salva($leilao);
        }

        $leiloes = $leilaoDao->recuperarNaoFinalizados();

        self::assertCount(1, $leiloes);
        self::assertContainsOnlyInstancesOf(Leilao::class, $leiloes);
        self::assertSame('Fiat 147 0KM', $leiloes[0]->recuperarDescricao());
        self::assertFalse($leiloes[0]->estaFinalizado());
    }

    
    /**
     * @dataProvider leiloes
     */
    public function testBuscaLeiloesFinalizados(array $leiloes)
    {
        $leilaoDao = new LeilaoDao(self::$pdo);
        foreach ($leiloes as $leilao) {
           $leilaoDao->salva($leilao);
        }

        $leiloes = $leilaoDao->recuperarFinalizados();

        self::assertCount(1, $leiloes);
        self::assertContainsOnlyInstancesOf(Leilao::class, $leiloes);
        self::assertSame('Variant 147 0KM', $leiloes[0]->recuperarDescricao());
        self::assertTrue($leiloes[0]->estaFinalizado());
    }

    protected function tearDown() : void
    {
        self::$pdo->rollBack();
    }

    public function leiloes()
    {
        $naofinalizado = new Leilao('Fiat 147 0KM');
        $finalizado = new Leilao('Variant 147 0KM');
        $finalizado->finaliza();

        return [
            [
                [$naofinalizado, $finalizado]
            ]
        ];
    }
}