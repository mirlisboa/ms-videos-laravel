# Curso Full Cycle.

## Módulo - Microsserviço: Catálogo de Vídeos com Laravel (Backend)

**Aluno:** Mirela Lisboa Sobreira
**Professor:** Luiz Carlos

### 1º Desafio:

Criar recurso Category e Genre.

Para acessar os recursos utilize as seguintes urls:
+ /api/v1/categories (get) --> exibi todas as categorias
+ /api/v1/categories/{category} (get) --> exibe a categoria solicitada
+ /api/v1/categories (post) --> Cadastra uma nova categoria
+ /api/v1/categories/{category} (put) --> Atualiza uma categoria existente
+ /api/v1/categories/{category} (delete) -> Apaga uma categoria.

+ /api/v1/genres (get) --> exibi todos os gêneros
+ /api/v1/genres/{genre} (get) --> exibe o gênero solicitado
+ /api/v1/genres (post) --> Cadastra um novo gênero
+ /api/v1/genres/{genre} (put) --> Atualiza um gênero existente
+ /api/v1/genres/{genre} (delete) -> Apaga um gênero



**Orientações**
+ Antes de executar o docker copie o conteúdo do arquivo .env-example para .env e modifique os parametros como desejar, porém como foi configurado para que o banco só aceite acessos com senha, não deixe de adicionar uma senha ao usuário.
```bash
cp .env-example .env
```