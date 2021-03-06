# Curso Full Cycle.

## Módulo - Microsserviço: Catálogo de Vídeos com Laravel (Backend)

**Aluno:** Mirela Lisboa Sobreira

**Professor:** Luiz Carlos

#### Orientações Gerais

Antes de executar o docker copie o conteúdo do arquivo **_.env-example_** para **_.env_** e modifique os parametros como desejar, porém como foi configurado para que o banco só aceite acessos com senha, não deixe de adicionar uma senha ao usuário.
```bash
cp .env.example .env
```

### 1º Desafio: recursos Category e Genre.

Para acessar os recursos utilize as seguintes urls:


| URL                             | Verbo         | Descrição                         |
|:--------------------------------|:--------------|:----------------------------------|
| /api/v1/categories              | GET           | exibe todas as categorias         |
| /api/v1/categories/{category}   | GET           | exibe a categoria solicitada      |
| /api/v1/categories              | POST          | cadastra uma nova categoria       |
| /api/v1/categories/{category}   | PUT           | atualiza uma categoria existente  |
| /api/v1/categories/{category}   | DELETE        | apaga uma categoria               |
| /api/v1/genres                  | GET           | exibi todos os gêneros            |
| /api/v1/genres/{genre}          | GET           | exibe o gênero solicitado         |
| /api/v1/genres                  | POST          | cadastra um novo gênero           |
| /api/v1/genres/{genre}          | PUT           | atualiza um gênero existente      |
| /api/v1/genres/{genre}          | DELETE        | apaga um gênero                   |


### 2º Desafio: Testes de integração em categorias e gêneros

Copie o arquivo **_.env_**, já com as modificações feitas como descrito no tópico **Orientações Gerais**, para **_.env.testing_** e modifique a variável **DB_DATABASE** para *msvldb_test*.
```bash
cp .env .env.testing
```

Agora é só executar o comando do Artisan para testar a aplicação:
```bash
php artisan test
```