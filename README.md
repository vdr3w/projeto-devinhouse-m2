![App Screenshot](https://github.com/vdr3w/projeto-devinhouse-m2/assets/84882983/bf5dec84-d33e-4b68-b129-16518129ab9f)
# API DEVinGYM

Este projeto consiste em uma API para a gestão de uma academia, utilizando Laravel 10 e PostgreSQL. A API permite o cadastro e gerenciamento de usuários, exercícios, estudantes e treinos, além de fornecer um painel de controle com informações relevantes.

## 🔧 Tecnologias utilizadas

O projeto foi desenvolvido utilizando:

PHP com framework Laravel 10
Banco de dados PostgreSQL

### Vídeo de apresentação: 
link

Seguem abaixo as depêndencias externas utilizadas:


| Plugin | Uso |
| ------ | ------ |
| Laravel | Framework PHP para desenvolvimento web |
| PostgreSQL | Sistema de gerenciamento de banco de dados |
| JWT | Autenticação via tokens JSON Web Tokens |

## 🧰 Técnicas e padrões utilizadas

A estrutura do projeto foi organizada em diferentes camadas, como models, controllers e routes, seguindo os princípios da programação orientada a objetos e padrões de design MVC.

| Local | Uso |
| ------ | ------ |
| /app/Models | Modelos da aplicação |
| /app/Http/Controllers | Controladores para gerenciar a lógica de negócios |
| /src/middlewares | Middlewares de validação do Token JWT |
| /routes | Definição das rotas da API |

### Modelagem da base de dados PostgreSQL

O projeto utilizou PostgreSQL para o gerenciamento de dados. 

❗❗❗❗❗❗❗❗❗(Inserir link ou imagem do modelo de dados, se disponível)

❗![App Screenshot](https://raw.githubusercontent.com/devmariano/project_files_repo/main/modelo_db.jpg)

### Organização de etapas e cronograma

O projeto foi planejado e executado conforme um cronograma definido. 

❗❗❗❗❗❗❗❗❗(Inserir link do cronograma, se disponível)


## 🚀 Como executar o projeto

- Clone o repositório ❗❗❗(inserir URL do repositório).
- Crie um banco de dados PostgreSQL chamado academia_api. ❗❗❗(inserir comando para criação do db).
- Configure as variáveis de ambiente no arquivo .env.
- Execute os comandos para instalar as dependências e iniciar o servidor:
  
```
composer install
php artisan serve
```

## 💻 Demonstração da API 

❗❗❗❗❗❗❗❗❗URL de demonstração da API: (inserir URL)

❗![App Screenshot](https://raw.githubusercontent.com/devmariano/project_files_repo/main/teste_rota.jpg)

## 🚑📗 Documentação da API

### 🚥 Endpoints - Rotas Usuários
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

#### S02 - Login de Usuário

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

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | Sucesso, retorna nome do usuário e token JWT|
|  `400` | Dados inválidos|
|  `401` | Credenciais inválidas|

##
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
### 🚥 Endpoints - Rotas Exercícios
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
### 🚥 Endpoints - Rotas Estudantes
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
    "email": "Drew@example.com",
    "date_birth": "1993-08-02",
    "cpf": "123.456.789-00",
    "contact": "21 987654321",
    "cep": "81560-420",
    "street": "Rua Butia",
    // ... outros campos opcionais
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
      "name": "Drew Vieira",
      "email": "drew@example.com",
      // ... outros detalhes do estudante
    }
    // ... mais estudantes
  ]

```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | Sucesso, retorna lista de estudantes|


##
### 🚥 Endpoints - Rotas Treinos
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
| `studentId` | `int` | **Obrigatório**. ID do estudante|

Exemplo de resposta:

```http
  {
    "student_id": 1,
    "student_name": "Drew Vieira",
    "workouts": {
      "SEGUNDA": ["Caminhada Contemplativa"],
      "TERÇA": [],
      "QUARTA": ["Natação na cama"],
      "QUINTA": [],
      "SEXTA": ["Corrida em Slowmotion"],
      "SÁBADO": [],
      "DOMINGO": []
    }
  }

```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | Sucesso, retorna treinos do estudante|
|  `404` | Estudante não encontrado|

##
#### S11 - Listagem de Medico pelo identificador

```http
  GET /api/medicos/:id
```
Não é necessario resquest body

Request exemplo:
`/api/medicos/1`
| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id` | `int` | **Obrigatório** número inteiro chave primaria|

Exemplo de resposta:

```http
{
	"id": 1,
    "nome_completo":"Roberto Farias",
    "genero":"MASCULINO",
    "data_nascimento":"1982-03-01",
    "cpf":"22023336066",
	"telefone":"21 984569813",
	"instituicao_ensino_formacao":"FAEC Med",
	"crm_uf":"76870690",
	"especializacao_clinica":"ORTOPEDIA",
	"estado_no_sistema": "ATIVO"
	"total_atendimentos": 1,
	"createdAt": "2023-04-19T12:00:46.855Z",
	"updatedAt": "2023-04-21T00:02:47.509Z"
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|
|  `404` | não encontrado registro com o código informado|

##
#### S12 - Exclusão de Medico

```http
  DELETE /api/medicos/:id
```
Não é necessario resquest body

Request exemplo:
`/api/medicos/1`
| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id` | `int` | **Obrigatório** número inteiro chave primaria|

Não há response no body em caso de sucesso


| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `204` | sucesso|
|  `404` | não encontrado registro com o código informado|

---
### 🚥 Endpoints - Rotas Enfermeiros
#### S13 - Cadastro de Enfermeiro

```http
  POST /api/enfermeiros
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id`      | `int` | **Autoincremental**. Chave primaria |
| `nome_completo` | `string` | **Obrigatório**. Nome do enfermeiro|
| `genero` | `string` | Genero do enfermeiro|
| `data_nascimento` | `date` | **Obrigatório** Data de nascimento do enfermeiro|
| `cpf` | `string` | **Obrigatório**. CPF do enfermeiro, único e válido|
| `telefone` | `string` | Telefone do enfermeiro|
| `instituicao_ensino_formacao` | `string` | **Obrigatório**. Instituição de formação|
| `cofen_uf` | `string` | **Obrigatório** Cadastro do COFEN/UF|


Request JSON exemplo
```http
  {
    "nome_completo":"Ana Leme",
    "genero":"FEMININO",
    "data_nascimento":"1987-02-01",
    "cpf":"99686191089",
    "telefone":"21 984569813",
    "instituicao_ensino_formacao":"Fac Enf MG",
    "cofen_uf":"8619108"
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `201` | sucesso|
|  `400` | dados inválidos|
|  `409` | CPF já cadastrado|
|  `500` | erro interno|

##

#### S14 - Atualização dos dados de Enfermeiros

```http
  PUT /api/enfermeiros/:id
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `nome_completo` | `string` | Nome do enfermeiro|
| `genero` | `string` | Genero do enfermeiro|
| `data_nascimento` | `date` | Data de nascimento do enfermeiro|
| `cpf` | `string` | CPF do enfermeiro, único e válido|
| `telefone` | `string` | Telefone do enfermeiro|
| `instituicao_ensino_formacao` | `string` | Instituição de formação|
| `cofen_uf` | `string` | Cadastro do COFEN/UF|



Request JSON exemplo
```http
/api/enfermeiros/1
```
```http
  {
	"telefone":"11 845698345",
	"instituicao_ensino_formacao": "Faculdade Pan",
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|
|  `400` | dados inválidos|
|  `404` | não encontrado registro com o código informado|
|  `500` | erro interno|


##
#### S15 - Listagem de Enfermeiros

```http
  GET /api/enfermeiros
```
Não é necessario resquest body


Exemplo de resposta:

```http
{
	"id": 1,
	"nome_completo":"Ana Leme",
   	"genero":"FEMININO",
   	"data_nascimento":"1987-02-01",
   	"cpf":"99686191089",
   	"telefone":"21 984569813",
   	"instituicao_ensino_formacao":"Fac Enf MG",
   	"cofen_uf":"8619108"
	"updatedAt": "2023-04-20T00:57:43.465Z",
	"createdAt": "2023-04-20T00:57:43.465Z"
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|

##
#### S16 - Listagem de Enfermeiro pelo identificador

```http
  GET /api/enfermeiros/:id
```
Não é necessario resquest body

Request exemplo:
`/api/enfermeiros/1`
| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id` | `int` | **Obrigatório** número inteiro chave primaria|

Exemplo de resposta:

```http
{
	"id": 1,
	"nome_completo":"Ana Leme",
   	"genero":"FEMININO",
   	"data_nascimento":"1987-02-01",
   	"cpf":"99686191089",
   	"telefone":"21 984569813",
   	"instituicao_ensino_formacao":"Fac Enf MG",
   	"cofen_uf":"8619108"
	"updatedAt": "2023-04-20T00:57:43.465Z",
	"createdAt": "2023-04-20T00:57:43.465Z"
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|
|  `404` | não encontrado registro com o código informado|

##
#### S17 - Exclusão de Enfermeiro

```http
  DELETE /api/enfermeiros/:id
```
Não é necessario resquest body

Request exemplo:
`/api/enfermeiros/1`
| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id` | `int` | **Obrigatório** número inteiro chave primaria|

Não há response no body em caso de sucesso


| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `204` | sucesso|
|  `404` | não encontrado registro com o código informado|

---

### 🚥 Endpoints - Atendimentos
#### S18- Realização de Atendimento Médico

```http
  POST /api/atendimentos
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id`      | `int` | **Autoincremental**. Chave primaria |
| `paciente_id` | `int| **Obrigatório**. Chave estrangeira do paciente |
| `medico_id` | `int| **Obrigatório**. Chave estrangeira do medico |


Request JSON exemplo
```http
  {
    "paciente_id":"2",
    "medico_id":"1"
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `201` | sucesso|
|  `400` | dados inválidos|
|  `404` | medico ou paciente não encontrados no sistema|
|  `500` | erro interno|

##

#### S19 - Listagem de Atendimentos ⭐(funcionalidade extra)

```http
  GET /api/atendimentos
```
Não é necessario resquest body

Opcionalmente podem ser utilizados no patch dois query params informando: medico_id ou paciente_id

Exemplo query params médico:
`/api/atendimentos?medico=1`  retorna todos atendimentos do médico especificado

Exemplo query params paciente:
`/api/atendimentos?paciente=1` retorna todos atendimentos do paciente especificado


| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id`      | `int` | Chave primaria |
| `paciente_id` | `int`| **querie params não obrigatorio**. Chave estrangeira do paciente |
| `medico_id` | `int`| **querie params não obrigatorio**. Chave estrangeira do medico |

Exemplo de resposta:

```http
[
	{
		"id": 1,
		"paciente_id": 13,
		"medico_id": 1,
		"createdAt": "2023-04-20T23:56:33.120Z",
		"updatedAt": "2023-04-20T23:56:33.120Z",
		"pacienteId": 13,
		"medicoId": 1
	},
	{
		"id": 2,
		"paciente_id": 14,
		"medico_id": 1,
		"createdAt": "2023-04-20T23:57:25.088Z",
		"updatedAt": "2023-04-20T23:57:25.088Z",
		"pacienteId": 14,
		"medicoId": 1
	}
]
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|
|  `404` | medico ou paciente não encontrados no sistema|
|  `500` | erro interno|


## Projeto Avaliativo do Módulo 1 :: LAB 365 
#### Curso WEB FullStack 2023

|        |                             |
|  :--------- | :---------------------------------- |
|  <img src="https://media.licdn.com/dms/image/C4D0BAQGcs8aDa4BZOQ/company-logo_200_200/0/1668186440015?e=1690416000&v=beta&t=YhQTfa9VLbEVw1XnROd2OsJUwGu-7Ia8eUoy18a3ve0" width="100%" height="100%"/> | [LAB365 ](https://lab365.tech/) - Espaço do SENAI para desenvolver habilidades do futuro.|





## Autor

|        |                             |
|  :--------- | :---------------------------------- |
|  <img src="https://avatars.githubusercontent.com/u/86934710?v=4" width="50%" height="50%"/> | Alexandre Mariano :: [@devmariano](https://www.github.com/devmariano)|

###
![Logo](https://raw.githubusercontent.com/devmariano/project_files_repo/main/labMedicine_logo6.jpg)

