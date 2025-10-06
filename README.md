# **Documentação Técnica - Projeto Pokedex com Laravel**

## **1. Visão Geral**

O projeto é uma aplicação web que permite aos usuários criar times de Pokémon, gerenciar suas equipes e visualizar informações detalhadas sobre diferentes Pokémon. O sistema utiliza Laravel como framework backend e JavaScript vanilla para interações frontend.

## **2. Estrutura do Projeto**

### 2.1 Modelos (Models)

-   **User**
    -   Utiliza UUID como chave primária ✅
    -   Atributos: name, sobrenome, email, password ✅
    -   Relacionamento: hasOne com Trainer✅
-   **Trainer**
    -   Atributos: user_id, trainer_name ✅
    -   Relacionamentos:
        -   belongsTo com User ✅
        -   hasMany com Team ✅
-   **Team**
    -   Utiliza UUID como chave primária ✅
    -   Atributos: team_name, trainer_id ✅
    -   Relacionamentos:
        -   belongsTo com Trainer ✅
        -   belongsToMany com Pokemon (através de pokemon_team) ✅

### 2.2 Controladores

### AuthController

-   `loginForm()`: Exibe formulário de login ✅
-   `login()`: Processa autenticação (email ou nome) ✅
-   `dashboard()`: Redireciona para dashboard ✅
-   `logout()`: Encerra sessão ✅

### PokemonController

-   `pokedex()`: Lista Pokémon (acesso público) ✅
-   `pokedexDashboard()`: Lista Pokémon (requer autenticação) ✅
-   `listar()`: Lista Pokémon com filtros e ordenação ✅
-   `especificacao()`: Exibe detalhes de um Pokémon específico ✅

### TeamController

-   index(): Lista times do treinador ✅
-   `create()`: Formulário de criação de time ✅
-   `store()`: Salva novo time ✅
-   `show()`: Exibe detalhes do time ✅
-   `edit()`: Formulário de edição ✅
-   `update()`: Atualiza time existente ✅
-   `destroy()`: Remove time ✅
-   `authorizeTeam()`: Verifica permissão de acesso ✅

### 2.3 Rotas

### Autenticação

```
<?php
GET  /register -> UserController@create
POST /register -> UserController@store
GET  /login   -> AuthController@loginForm
POST /login   -> AuthController@login
POST /logout  -> AuthController@logout
```

### Pokémon

```php
<?php
GET /pokedex      -> PokemonController@pokedex
GET /dashboard    -> PokemonController@pokedexDashboard
GET /listar-pokemon -> PokemonController@listar
GET /especificacao -> PokemonController@especificacao
```

### Times

```php
?php
GET    /teams              -> TeamController@index
GET    /teams-create       -> TeamController@create
POST   /teams             -> TeamController@store
GET    /teams/{team}      -> TeamController@show
GET    /teams/{team}/edit -> TeamController@edit
PUT    /teams/{team}      -> TeamController@update
DELETE /teams/{team}      -> TeamController@destroy
```

### 2.4 JavaScript (Frontend)

### team.js

Gerencia interações da interface de times:

-   Gerenciamento de slots de Pokémon ✅
-   Adição/remoção de Pokémon nos slots ✅
-   Filtros AJAX para busca de Pokémon ✅
-   Feedback visual (animações e notificações) ✅
-   Confirmação de exclusão de time ✅

Funcionalidades principais:

-   togglePokemon(): Adiciona/remove Pokémon do slot ✅
-   updateStatus(): Atualiza contador de Pokémon no time ✅
-   flashSlot(): Feedback visual na alteração de slots ✅
-   Integração com SweetAlert2 para confirmações ✅

### especificacao.js

Gerencia a visualização de Pokémon:

-   Alternância entre sprites normal/shiny ✅
-   Carregamento de imagens da PokeAPI ✅

## **3. Características Técnicas**

### 3.1 Segurança

-   Autenticação de usuários ✅
-   Proteção contra CSRF ✅
-   Verificação de propriedade de times ✅
-   Validação de dados em requisições ✅

### 3.2 Frontend

-   JavaScript vanilla sem frameworks ✅
-   Interações AJAX para filtros ✅
-   Feedback visual com SweetAlert2 ✅
-   Manipulação dinâmica do DOM ✅

### 3.3 Backend

-   Laravel como framework PHP ✅
-   Eloquent ORM para banco de dados ✅
-   Sistema de rotas RESTful ✅
-   Middleware de autenticação ✅

### 3.4 Banco de Dados

-   Migrations para estrutura de tabelas ✅
-   Relacionamentos complexos entre entidades ✅
-   UUID para identificadores únicos ✅
-   Tabela pivot para relação Pokémon-Time ✅

## **4. Particularidades do Sistema**

1. **Gestão de Times**
    - Limite de 6 Pokémon por time ✅
    - Ordenação de slots mantida ✅
    - Validação de propriedade ✅
2. **Interface de Usuário**
    - Feedback visual em tempo real ✅
    - Filtros dinâmicos com AJAX ✅
    - Confirmações de ações importantes ✅
3. **Pokémon**
    - Visualização normal/shiny ✅
    - Filtros por tipo e nome ✅
    - Ordenação por diferentes atributos ✅
4. **Segurança**
    - Autenticação robusta ✅
    - Proteção de rotas ✅
    - Validação de dados ✅
