
# Instruções sobre o Código

Este projeto segue os princípios de *SOLID* e utiliza *Inversão de Dependência* para maior flexibilidade e manutenibilidade. Abaixo está uma visão geral do fluxo e arquitetura do sistema.

## Fluxo das Requisições

Toda interação do *frontend* com o sistema ocorre via *Fetch API*, que envia as requisições ao arquivo index.php no servidor. Esse arquivo é responsável por inicializar o fluxo do sistema.

### Etapas do Fluxo

1. *Requisição*: O frontend realiza uma requisição para o servidor.
2. *Index.php*: As requisições são direcionadas para o index.php, onde a classe HandleRequestController é instanciada:
   php
   $handleRequest = new \Andre\GestaoDeEstoque\Controllers\HandleRequestController($container);
   
3. *Container*: A classe HandleRequestController depende do $container, que é configurado no arquivo Configurator.php, por meio de uma função estática. O index.php usa essa configuração para passar o container para o controlador.
4. *Processamento*: O método processRequest() do HandleRequestController é chamado, validando o tipo de requisição e preparando os dados adequados ($data) para processar.
5. *Ação*: Cada requisição contém uma ação específica. Se a ação for válida, o fluxo entra em um bloco try/catch, onde o método get() do ServiceContainer é chamado. Esse método localiza a ação correta no container e instancia as classes necessárias.
6. *Execução*: O fluxo segue a seguinte sequência:
   
   Request > index.php > processRequest() > get() > Action > execute()
   
   Cada Action implementa uma interface que possui o método execute(), responsável por chamar o método apropriado da Controller, continuando a execução do sistema.

## Conceitos Aplicados

### Inversão de Dependência

Este código faz uso extensivo do princípio de *Inversão de Dependência, onde as classes não dependem diretamente umas das outras, mas sim do **Service Container*. Isso reduz o acoplamento entre as classes e aumenta a flexibilidade do sistema.

### Lazy Loading

O *Service Container* também implementa o conceito de *Lazy Loading*. Ou seja, somente as classes necessárias para processar uma requisição específica são instanciadas no momento da execução, otimizando o uso de recursos do sistema.
