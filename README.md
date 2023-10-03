# Forking

- Ir ao projeto: (no Github)
- No canto superior direito clicar em Fork
- Por baixo de "owner" escolher o nosso utilizador
- Selecionar o "Copy the default branch"
- Clicar em Create Fork.

## Clonar o fork

- Em Code copiar o endereco do repositório.
- git clone https://github.com/YOUR-USERNAME/aeg_rc
- cd aeg_rc


---

```bash
git branch BRANCH-NAME
git checkout BRANCH-NAME
```

---

https://github.com/<your_username>/aeg_rc. You'll see a banner indicating that your branch is one commit ahead of dvdfreitas:main. Click Contribute and then Open a pull request.


GitHub will bring you to a page that shows the differences between your fork and the dvdfreitas/aeg_rc repository. Click Create pull request.


- git remote -v
- git remote add upstream https://github.com/ORIGINAL_OWNER/aeg_rc
- git remote -v


Mais informações em:
https://docs.github.com/en/get-started/quickstart/contributing-to-projects

# Tutoriais

## Markdown

https://www.markdownguide.org/cheat-sheet/

# Trabalhos

Document
Project
Student
Teacher
Award
SchoolClass
Course
Subject
Story
Quote
Hero
Category
Quote
Event
School
Partner

## Criação do modelo e da base de dados

```bash
php artisan make:model Document -mcs
```

Editar a migração:

```php
Schema::create('documents', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('subtitle')->nullable();
        $table->string('slug')->unique();
        $table->text('description')->nullable();
        $table->text('file');
        $table->string('image')->nullable();
        $table->string('type')->nullable();
        $table->year('year')->nullable();
        $table->timestamps();
    });
```

Atualizar a BD:

```php
php artisan migrate
```

Atualizar o Seeder:

