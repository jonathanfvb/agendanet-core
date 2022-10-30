# Agendanet Core
Aplicação para agendamento de consultas que visa demonstrar o desenvolvimento de um código desacoplado de framework.
O código central da aplicação é agnóstico quanto ao framework.
O papel do framework na aplicação tem o caráter de prover as configurações básicas da aplicação, bem como a interface
de roteamento e injeção de dependências.
Como exemplo, a aplicação foi testada com os frameworks:
* Slim
* Lumen

## Pré-requisito
* Docker
* Docker Compose

## Testando a aplicação com o framework Slim
Realize checkout no branch da aplicação
```
git checkout slim
```
E então siga com o processo de execução da aplicação conforme descrito mais abaixo neste documento

## Testando a aplicação com o framework Lumen
Realize checkout no branch da aplicação
```
git checkout lumen
```
E então siga com o processo de execução da aplicação conforme descrito mais abaixo neste documento

## Execução da Aplicação
Caso a aplicação já esteja rodando execute o comando para pará-la
```
make down
```

Para subir o container da aplicação execute o comando
```
make up
```

Depois instale as dependências
```
make install
```

Após isso acesse a aplicação
```
http://localhost:8090
```

# Executando os testes unitários
Para executar os testes unitário execute o comando
```
make tests
```
