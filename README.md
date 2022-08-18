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

### Performance
- Utilizar um banco de dados em memória
- Uitlizar transações
- Utilizar um banco de teste (MySql)
- Não fazer testes em produção

### Asserts intermediários
Quebram o padrão AAA, mas podem ser interessantes em alguns casos.

### Rodar apenas uma suite de testes
```
vendor\bin\phpunit --testsuite="integration"
```

### Testes API
- Se está disponível
- Se o código de resposta HTTP enviado é o correto
- Se o corpo da requisição retorna o conteúdo correto

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
