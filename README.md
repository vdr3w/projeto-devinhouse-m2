![App Screenshot](https://github.com/vdr3w/projeto-devinhouse-m2/assets/84882983/bf5dec84-d33e-4b68-b129-16518129ab9f)
# DEVinGYM API

Este projeto é uma API para gerenciamento de uma academia, desenvolvida com Laravel 10 e PostgreSQL. A API facilita o cadastro e a administração de usuários, exercícios, estudantes e treinos, além de prover um dashboard com informações úteis.

## 🏋️‍♂️ Tecnologias utilizadas

O projeto foi desenvolvido utilizando:

- PHP com Laravel 10
- Banco de dados PostgreSQL

### Vídeo Demonstrativo: 
link

Principais dependências externas:

| Plugin | Utilização |
| ------ | ---------- |
| Laravel | Framework PHP para desenvolvimento web |
| PostgreSQL | Sistema de gerenciamento de banco de dados |
| JWT | Autenticação via tokens JSON Web Tokens |

## 💡 Padrões e Técnicas Utilizadas

O projeto segue uma estrutura de camadas, dividido em models, controllers e routes, aderindo aos princípios da Programação Orientada a Objetos e ao padrão MVC.

| Diretório | Função |
| --------- | ------ |
| /app/Models | Modelos da aplicação |
| /app/Http/Controllers | Controladores para a lógica de negócios |
| /src/middlewares | Middlewares para validação do Token JWT |
| /routes | Definição das rotas da API |

### Modelagem do Banco de Dados PostgreSQL

Utilização do PostgreSQL para gerenciamento de dados. 

❗❗❗❗❗❗❗❗❗(Inserir link ou imagem do modelo de dados, se disponível)

❗![App Screenshot](https://raw.githubusercontent.com/devmariano/project_files_repo/main/modelo_db.jpg)

### Cronograma e Organização

Planejamento e execução do projeto de acordo com um cronograma estabelecido. 

❗❗❗❗❗❗❗❗❗(Inserir link do cronograma, se disponível)

## 🏃‍♂️ Instruções para Execução do Projeto

- Clone o repositório ❗❗❗(inserir URL do repositório).
- Crie um banco de dados PostgreSQL chamado academia_api. ❗❗❗(inserir comando para criação do db).
- Configure o arquivo .env com as variáveis de ambiente.
- Execute os comandos para instalação e inicialização do servidor:
  
```
composer install
php artisan serve
```

## 🖥️ Demonstração da API 

❗❗❗❗❗❗❗❗❗URL de demonstração da API: (inserir URL)

❗![App Screenshot](https://raw.githubusercontent.com/devmariano/project_files_repo/main/teste_rota.jpg)

## 📚 Documentação da API

### 🚥 Endpoints - 🏅 Rotas Usuários
#### S01 - Cadastro de usuário 

```http
    POST /api/users
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id`      | `int` | **Autoincremental**. Chave primaria |
| `name` | `string` | **Obrigatório**. Nome do usuário, máximo 255 caracteres|
| `email` | `string` | **Obrigatório**. Email do usuário, único, válido e máximo 255 caracteres|
| `password` | `string` | **Obrigatório**. Senha do usuário, mínimo 8 caracteres e máximo 32 caracteres|
| `date_birth` | `date` | **Obrigatório** Data de nascimento do usuário|
| `cpf` | `string` | **Obrigatório**  CPF do usuário, único, válido e com 14 caracteres|
| `plan_id` | `string` | **Obrigatório**. ID do plano selecionado, deve existir na tabela plans|


Request JSON exemplo
```http
  {
    "name": "Drew Vieira",
    "email": "drew@example.com",
    "password": "senha123",
    "date_birth": "1990-01-01",
    "cpf": "123.456.789-00",
    "plan_id": 1
  }

```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `201` | Sucesso|
|  `400` | Dados Inválidos|
|  `409` | Conflito de CPF ou Email|

##

### 🚥 Endpoints - 🏋️‍♂️ Rotas de Login 
#### S02 - Login

```http
   POST /api/login
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `email` | `string` |  **Obrigatório**. Email do usuário|
| `password` | `string` | **Obrigatório**. Senha do usuário|


Request JSON exemplo
```http
  {
    "email": "drew@example.com",
    "password": "senha123"
  }
```

Resposta JSON exemplo
```http
  {
    "name": "Drew Vieira",
    "token": "eyJ0eXAiOiJK...U2tPZGpxPpC8kx7m5n6QsPQ5VgTA"
  }
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | Sucesso, retorna nome do usuário e token JWT|
|  `400` | Dados inválidos|
|  `401` | Credenciais inválidas|

##
### 🚥 Endpoints - 🚴 Rotas de Dashboard
#### S03 - Dashboard

```http
  GET /api/dashboard
```

Não é necessário enviar parâmetros no body da requisição para este endpoint. A autenticação é realizada via token JWT.

Resposta JSON exemplo (depende dos dados do usuário autenticado)
```http
  {
    "registered_students": 11,
    "registered_exercises": 5,
    "current_user_plan": "Prata",
    "remaining_students": 9
  }

```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | Sucesso, retorna dados do dashboard do usuário|
|  `500` | Erro interno|

##
### 🚥 Endpoints - 🏊‍♀️ Rotas de Exercícios
#### S04 - Cadastro de Exercícios

```http
   POST /api/exercises
```
| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `description` | `string` |  **Obrigatório**. Descrição do exercício, máximo 255 caracteres|

Request JSON exemplo
```http
  {
    "description": "Levantamento de peso"
  }
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `201` | Sucesso, exercício cadastrado|
|  `400` | Dados inválidos|
|  `409` | Exercício já cadastrado para o usuário|

##
#### S05 - Listagem de Exercícios

```http
  GET /api/exercises
```
Não é necessário enviar parâmetros no body da requisição. Ele vai listar os exercicios do usuario logado.

Exemplo de response:
```http
  [
    {
      "id": 1,
      "description": "Levantamento de peso",
      "user_id": 1
    },
    {
      "id": 2,
      "description": "Supino",
      "user_id": 1
    }
    // ... mais exercícios
  ]

```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | Sucesso, retorna lista de exercícios|

##
#### S06 - Deleção de Exercícios

```http
    DELETE /api/exercises/:id
```
| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id` | `int` |  **Obrigatório**. ID do exercício|

Não há response no body em caso de sucesso.

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `204` | Sucesso, exercício deletado|
|  `403` | Ação não permitida|
|  `404` | Exercício não encontrado|

---
### 🚥 Endpoints - 🤸 Rotas de Estudantes
#### S07 - Cadastro de Estudante

```http
  POST /api/students
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id`      | `int` | **Autoincremental**. Chave primaria |
| `name` | `string` | **Obrigatório**. Nome do estudante|
| `email` | `string` | **Obrigatório**. Email do estudante, único|
| `date_birth` | `date` | **Obrigatório** Data de nascimento|
| `cpf` | `string` | **Obrigatório**. CPF do estudante, único|
| `contact` | `string` | **Obrigatório**. Contato do estudante|
| `cep` | `string` | CEP do estudante (opcional)|
| `street` | `string` | Rua do estudante (opcional)|
| `... outros campos opcionais	` |  | |


Request JSON exemplo
```http
  {
    "name": "Drew Vieira",
    "email": "drew@example.com",
    "date_birth": "1993-08-02",
    "cpf": "123.456.789-00",
    "contact": "21987654321",
    "cep": "22020-010",
    "street": "Rua De Curitiba",
    "state": "PR",
    "neighborhood": "Centro",
    "city": "Curitiba",
    "number": "100",
    "complement": "Sobrado"
  }
```

Resposta JSON exemplo (depende dos dados do usuário autenticado)
```http
  {
    "id": 1,
    "name": "Drew Silva",
    "email": "drew@example.com",
    "date_birth": "1993-08-02",
    "cpf": "123.456.789-00",
    "contact": "(21) 98765-4321",
    "address": {
      "cep": "22020-010",
      "street": "Rua De Curitiba",
      "state": "PR",
      "neighborhood": "Centro",
      "city": "Curitiba",
      "number": "100",
      "complement": "Sobrado"
    }
  }

```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `201` | Sucesso, estudante cadastrado|
|  `400` | Dados inválidos|
|  `403` | Limite de cadastro atingido|

##

#### S08 - Listagem de Estudantes

```http
  GET /api/students
```

Não é necessário enviar parâmetros no body da requisição. Ele vai retornar apenas os estudantes registrados pelo usuario logado.

Exemplo de Response:
```http
  [
    {
      "id": 1,
      "name": "Maria Silva",
      "email": "maria@example.com",
      "date_birth": "1995-05-21",
      "cpf": "123.456.789-00",
      "contact": "(21) 98765-4321",
      "address": {
        "cep": "22.020-010",
        "street": "Rua dos Estudantes",
        "state": "RJ",
        "neighborhood": "Centro",
        "city": "Rio de Janeiro",
        "number": "100",
        "complement": "Apto 101"
      },
      "user_id": 2,
      "deleted_at": null
    },
    {
      "id": 2,
      "name": "Drew Vieira",
      "email": "drew@example.com",
      "date_birth": "1993-08-15",
      "cpf": "987.654.321-00",
      "contact": "(41) 99876-5432",
      "address": {
        "cep": "80.020-030",
        "street": "Avenida Sete de Setembro",
        "state": "PR",
        "neighborhood": "Centro",
        "city": "Curitiba",
        "number": "200",
        "complement": "Bloco B"
      },
      "user_id": 2,
      "deleted_at": null
    }
  ]
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | Sucesso, retorna lista de estudantes|


##
### 🚥 Endpoints - 🚣 Rotas de Treinos
#### S09 -  Cadastro de Treino

```http
  POST /api/workouts
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id` | `int` | **Obrigatório**. número inteiro chave primaria|
| `student_id` | `int` | **Obrigatório**.  ID do estudante|
| `exercise_id` | `int` | **Obrigatório**.  ID do exercício|
| `repetitions` | `int` | **Obrigatório**. Número de repetições|
| `weight` | `numeric` | **Obrigatório**. Peso usado no exercício|
| `break_time` | `int` | **Obrigatório**. Tempo de descanso (em segundos)|
| `day` | `int` | **Obrigatório**. Dia da semana (enum: SEGUNDA, TERÇA, QUARTA, QUINTA, SEXTA, SÁBADO, DOMINGO)|
| `observataions` | `int` | Observações sobre o treino|
| `time` | `int` | **Obrigatório**. Duração do exercício (em minutos)|



Request JSON exemplo
```http
  {
    "student_id": 1,
    "exercise_id": 2,
    "repetitions": 10,
    "weight": 20.5,
    "break_time": 60,
    "day": "SEGUNDA",
    "observations": "Focar na postura",
    "time": 30
  }
```

Exemplo de Response:
```http
    {
        "student_id": 5,
        "exercise_id": 1,
        "repetitions": 130,
        "weight": 15.5,
        "break_time": 5,
        "day": "QUARTA",
        "observations": "Beber mais agua",
        "time": 60,
        "updated_at": "2023-12-20T08:27:22.000000Z",
        "created_at": "2023-12-20T08:27:22.000000Z",
        "id": 7
    }
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `201` | Sucesso, treino cadastrado|
|  `400` | Dados inválidos|
|  `409` | Treino para o mesmo dia já cadastrado|

##
#### S10 - Listagem de Treinos por Estudante

```http
  GET /api/students/:studentId/workouts
```
| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `studentId` | `int` | **Obrigatório**. ID do estudante que vai na url|

Exemplo de resposta:

```http
{
    "student_id": 5,
    "student_name": "Drew Vieira",
    "workouts": {
        "SEGUNDA": [],
        "TERÇA": [
            "Treino de Pernas"
        ],
        "QUARTA": [
            "Aerobico"
        ],
        "QUINTA": [],
        "SEXTA": [
            "Rosca direta"
        ],
        "SÁBADO": [
            "Supino"
        ],
        "DOMINGO": [
            "Caminhada Contemplativa"
        ]
    }
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | Sucesso, retorna treinos do estudante|
|  `404` | Estudante não encontrado|

##
#### S11 -  Exportação de PDF dos Treinos do Estudante

```http
  GET /api/students/:id_do_estudante/export
```
Request exemplo:
| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id_do_estudante` | `int` | **Obrigatório**. ID do estudante|

Não há response no body em caso de sucesso, o PDF é enviado como download.

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | Sucesso, PDF dos treinos enviado|
|  `404` | Estudante não encontrado|

##
🏆 Projeto Avaliativo do Módulo 2 :: DEVINHOUSE
#### DEVinHouse[Zucchetti] - Módulo 2

|        |                             |
|  :--------- | :---------------------------------- |
|  <img src="https://media.licdn.com/dms/image/C4D0BAQGcs8aDa4BZOQ/company-logo_200_200/0/1668186440015?e=1690416000&v=beta&t=YhQTfa9VLbEVw1XnROd2OsJUwGu-7Ia8eUoy18a3ve0" width="100%" height="100%"/> | [LAB365 ](https://lab365.tech/) - Espaço do SENAI para desenvolver habilidades do futuro.|





## Autor

|        |                             |
|  :--------- | :---------------------------------- |
|  <img src="https://avatars.githubusercontent.com/u/86934710?v=4" width="50%" height="50%"/> | Alexandre Mariano :: [@devmariano](https://www.github.com/devmariano)|

###
![Logo](https://raw.githubusercontent.com/devmariano/project_files_repo/main/labMedicine_logo6.jpg)

