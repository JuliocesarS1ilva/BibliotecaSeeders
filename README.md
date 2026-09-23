
# Biblioteca Seeder — Povoamento de Banco de Dados com Laravel

## 1. Introdução

Este projeto foi desenvolvido com o objetivo de aplicar, na prática, os conceitos de povoamento de banco de dados utilizando **Seeders no Laravel**.

A atividade consiste na criação de Seeders para realizar a inserção de uma quantidade significativa de dados, executar o povoamento do banco, verificar os relacionamentos e a integridade das informações e, posteriormente, exportar a base de dados preenchida no formato `.sql`.

---

## 2. Tecnologias utilizadas

As principais tecnologias e ferramentas utilizadas no desenvolvimento do projeto foram:

* Laravel
* PHP
* MySQL
* phpMyAdmin
* Git
* GitHub

---

## 3. Estrutura do banco de dados

O banco de dados utilizado no projeto é denominado `biblioteca_seeder`.

Foram utilizadas as seguintes tabelas principais:

* `users` — usuários da biblioteca;
* `categories` — categorias dos livros;
* `books` — livros cadastrados;
* `loans` — empréstimos realizados.

Os principais relacionamentos entre as tabelas são representados abaixo:

```text
users
  │
  │ user_id
  ↓
loans
  ↑
  │ book_id
  │
books
  │
  │ category_id
  ↓
categories
```

Dessa maneira, cada empréstimo está associado a um usuário e a um livro, enquanto cada livro está relacionado a uma determinada categoria.

---

## 4. Criação dos Seeders

Os Seeders foram criados utilizando a interface de linha de comando do Artisan.

Como exemplo, foi utilizado o seguinte comando:

```bash
php artisan make:seeder CategorySeeder
```

[Criação do CategorySeeder](https://github.com/MrLusky/Biblioteca-Seeder/blob/main/docs/images/01-criacao-seeder.png)

Também foram criados os seguintes Seeders:

* `UserSeeder`
* `CategorySeeder`
* `BookSeeder`
* `LoanSeeder`

---

## 5. Implementação dos Seeders

Os dados foram inseridos dentro do método `run()` de cada Seeder, utilizando o método `DB::table()->insert()`.

Como exemplo, o `CategorySeeder` foi configurado para inserir quatro categorias no banco de dados.

<img width="334" height="426" alt="image" src="https://github.com/user-attachments/assets/4885482f-d948-451e-9681-a32e689e035a" />

Os demais Seeders foram responsáveis pela inserção de usuários, livros e empréstimos, mantendo os relacionamentos existentes entre as tabelas.

---

## 6. Configuração do DatabaseSeeder

Para permitir a execução de todos os Seeders de forma organizada, eles foram registrados no arquivo `DatabaseSeeder.php`.

A ordem de execução foi definida da seguinte forma:

```php
$this->call([
    UserSeeder::class,
    CategorySeeder::class,
    BookSeeder::class,
    LoanSeeder::class,
]);
```

Essa ordem garante que os registros necessários para as chaves estrangeiras sejam criados antes dos registros que dependem deles.

<img width="325" height="249" alt="image" src="https://github.com/user-attachments/assets/c5fa179d-ffc2-4d3a-b410-34ca526f4f1c" />


---

## 7. Execução do povoamento

Depois da criação e configuração dos Seeders, o povoamento do banco de dados foi realizado através do seguinte comando:

```bash
php artisan db:seed
```

<img width="810" height="180" alt="image" src="https://github.com/user-attachments/assets/a629de5f-932e-49b6-bf6a-b8a3e5ad06af" />


A execução foi concluída sem erros, indicando que os dados foram inseridos corretamente no banco de dados.

---

## 8. Verificação dos dados

Após a execução dos Seeders, os dados inseridos foram verificados utilizando o **phpMyAdmin**.

A tabela `books`, por exemplo, apresentou os registros inseridos pelo `BookSeeder`.

<img width="472" height="174" alt="image" src="https://github.com/user-attachments/assets/99eddbdf-8307-4e26-9531-af6896cd1c1a" />


---

## 9. Verificação dos relacionamentos

Para verificar se os relacionamentos entre as tabelas estavam funcionando corretamente, foram realizadas consultas SQL utilizando `INNER JOIN`.

### 9.1 Livros e categorias

Foi utilizada a seguinte consulta:

```sql
SELECT
    books.id,
    books.title,
    books.author,
    categories.name AS category
FROM books
INNER JOIN categories
    ON books.category_id = categories.id;
```

O resultado permitiu verificar que cada livro está corretamente associado à sua respectiva categoria.

<img width="372" height="95" alt="image" src="https://github.com/user-attachments/assets/003c2016-2186-4e86-ae20-d379d44fab93" />


### 9.2 Empréstimos, usuários e livros

Também foi realizada uma consulta relacionando os empréstimos aos respectivos usuários e livros:

```sql
SELECT
    loans.id,
    users.name AS user,
    books.title AS book,
    loans.loan_date,
    loans.return_date
FROM loans
INNER JOIN users
    ON loans.user_id = users.id
INNER JOIN books
    ON loans.book_id = books.id;
```

Essa consulta permitiu verificar que os empréstimos estão corretamente associados aos usuários e aos livros correspondentes.

<img width="250" height="27" alt="image" src="https://github.com/user-attachments/assets/9b0eee87-c0e7-4e57-bf35-9e32ae9a301f" />

---

## 10. Verificação das chaves estrangeiras

Também foi realizada uma consulta ao banco de dados com o objetivo de verificar as chaves estrangeiras existentes.

```sql
SELECT
    TABLE_NAME,
    COLUMN_NAME,
    CONSTRAINT_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM information_schema.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = 'biblioteca_seeder'
AND REFERENCED_TABLE_NAME IS NOT NULL;
```

O resultado confirmou os seguintes relacionamentos:

* `books.category_id` → `categories.id`;
* `loans.user_id` → `users.id`;
* `loans.book_id` → `books.id`.

<img width="368" height="53" alt="image" src="https://github.com/user-attachments/assets/c0f63414-a259-4d17-899a-cf4b9907b1d6" />


---

## 11. Teste de integridade referencial

Para verificar o funcionamento das regras de integridade referencial, foi realizada uma tentativa de inserir um empréstimo utilizando identificadores que não existem nas tabelas correspondentes.

```sql
INSERT INTO loans
(user_id, book_id, loan_date, created_at, updated_at)
VALUES
(999, 999, '2026-09-22', NOW(), NOW());
```

A operação foi rejeitada pelo banco de dados devido às restrições impostas pelas chaves estrangeiras.

Isso demonstra que a tabela `loans` não permite referências a usuários ou livros inexistentes nas respectivas tabelas.

<img width="190" height="129" alt="image" src="https://github.com/user-attachments/assets/351ee5ab-4c6b-4ab0-896e-4f55937775be" />

---

## 12. Exportação do banco de dados

Após a validação dos dados e dos relacionamentos, o banco de dados `biblioteca_seeder` foi exportado utilizando o **phpMyAdmin**.

O arquivo gerado possui a extensão `.sql` e contém tanto a estrutura quanto os dados persistidos no banco.

O dump está disponível no projeto em:

```text
database/dump/biblioteca_seeder.sql
```

---

## 13. Estrutura do projeto

A parte principal relacionada à atividade está organizada da seguinte maneira:

```text
biblioteca-seeder/
│
├── database/
│   ├── migrations/
│   │
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   ├── UserSeeder.php
│   │   ├── CategorySeeder.php
│   │   ├── BookSeeder.php
│   │   └── LoanSeeder.php
│   │
│   └── dump/
│       └── biblioteca_seeder.sql
│
├── docs/
│   └── images/
│       ├── 01-criacao-seeder.png
│       ├── 02-category-seeder.png
│       ├── 03-database-seeder.png
│       ├── 04-execucao-seeder.png
│       ├── 05-tabela-books.png
│       ├── 06-verificacao-livros.png
│       ├── 07-verificacao-emprestimos.png
│       ├── 08-chaves-estrangeiras.png
│       └── 09-integridade-referencial.png
│
└── README.md
```

---

## 14. Conclusão

A atividade possibilitou aplicar, na prática, o conceito de **Seeders no Laravel**, realizando a inserção de dados em diferentes tabelas e mantendo os relacionamentos existentes entre elas.

Após o povoamento, os registros foram verificados no phpMyAdmin. Também foram realizadas consultas SQL para validar os relacionamentos e as chaves estrangeiras presentes no banco de dados.

Por fim, o banco de dados preenchido foi exportado para um arquivo `.sql`, permitindo o versionamento tanto da estrutura quanto dos dados utilizados durante a atividade.
**
