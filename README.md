# Testes de integração com [PHP Unit 9](https://phpunit.de)

### Especificações do Projeto
- [x] Os usuários podem dar lances em um leilão
- [x] Um leiloeiro avalia o leilão informando qual o maior valor de lance, qual o menor valor e os 3 maiores lances
- [x] Um usuário não pode dar dois lances consecutivos
- [x] Um usuário só pode dar no máximo 5 lances
- [x] Testes devem ser criados para verificar essas especificações
- [x] Leilões com mais de uma semana devem ser finalizados

### Testes de intergação
Testam integração entre várias classes/módulos e sistema externo (banco, api)

### Diferença entre Equals e Same
- Equals ==
- Same ===

### Contém apenas instancias de um tipo
```
self::assertContainsOnlyInstancesOf(Leilao::class, $leiloes);
```

### Performance
- [x] Utilizar um banco de dados em memória
- [x] Uitlizar transações
- [x] Utilizar um banco de teste (MySql)
- [x] Não fazer testes em produção

### Asserts intermediários
Quebram o padrão AAA, mas podem ser interessantes em alguns casos.

### Rodar apenas uma suite de testes
```
vendor\bin\phpunit --testsuite="integration"
```

### Testes API
- [x] Se está disponível
- [x] Se o código de resposta HTTP enviado é o correto
- [x] Se o corpo da requisição retorna o conteúdo correto

#### Subir o servidor pra uso na API
```
php -S localhost:8080
```

#### Retornar leilões não finalizados
URL: http://localhost:8080/rest.php

Verbo: GET

Não é necessário passar nenhum paramêtro.

```
Frameworks como Symfony já possuem ferramentas para testes em API.
```

### Testes no Postman
Na aba Tests é possível fazer alguns testes:

```
pm.test("Código de status da resposta deve ser 200", () => {
    pm.response.to.have.status(200);
});

pm.test("Resposta deve estar em Json", () => {
    pm.response.to.be.json;
});

pm.test('Resposta deve estar no formato de leilao', () => {
    const schema = {
        required : ['descricao', 'estaFinalizado'],
        properties : {
            descricao : {
                type : "string",
            }, 
            estaFinalizado : {
                type: "boolean"
            }
        }
    };

    const leiloes = pm.response.json();
    leiloes.forEach(leilao => {
        pm.expect(tv4.validate(leilao, schema)).to.be.true;
        pm.expect(leilao.estaFinalizado).to.be.false;
    });
});
```
