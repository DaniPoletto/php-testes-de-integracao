# Testes de integração com [PHP Unit 9](https://phpunit.de)

### Especificações do Projeto
- Os usuários podem dar lances em um leilão
- Um leiloeiro avalia o leilão informando qual o maior valor de lance, qual o menor valor e os 3 maiores lances
- Um usuário não pode dar dois lances consecutivos
- Um usuário só pode dar no máximo 5 lances
- Testes devem ser criados para verificar essas especificações
- Leilões com mais de uma semana devem ser finalizados

### Testes de intergação
Testam integração entre várias classes/módulos e sistema externo (banco, api)

### Diferença entre Equals e Same
- Equals ==
- Same ====

### Contém apenas intancias de um tipo
```
self::assertContainsOnlyInstancesOf(Leilao::class, $leiloes);
```

