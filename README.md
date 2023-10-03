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

# Projeto

- Document (Professor)
- Project - 12
- Student - 13
- Teacher - 15
- Award - Rafael Vieira
- SchoolClass - Gustavo
- Course - Tiago
- Subject - 20
- Story - Filipe
- Quote - Diogo
- Hero - Emanuel
- Category - Gonçalo
- Event - Cláudio
- School - Francisco
- Partner - José
- Classroom - Bruno
- PAP - Carolina

## Criação do modelo e da base de dados

Cada aluno deverá, de acordo com o modelo atribuído, contribuir para o projeto.

Como exemplo, nestes apontamentos, encontrarás um tutorial para o caso específico dos Documentos.

Para criar um modelo para os Documentos (Document) juntamente com um ficheiro de migração, um controlador e um *seeder* deverás executar:

```bash
php artisan make:model Document -mcs
```

Este comando criou os seguintes ficheiros:

```bash
app/Models/Document.php
database/migrations/2023_10_03_083513_create_documents_table.php
database/seeders/DocumentSeeder.php
app/Http/Controllers/DocumentController.php
```

Nota: O ficheiro da migração tem no seu nome a data em que foi criado, pelo que no teu caso será certamente diferente.

### Migração

O primeiro passo é alterar a migração ```database/migrations/2023_10_03_083513_create_documents_table.php```. 

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

Depois de alterar o ficheiro, para que as alterações se propaguem na base de dados, deverás executar:

```php
php artisan migrate
```

Este comando só atualiza as tabelas. Relembro que caso queira apagar todas as tabelas anteriores e recomeçar a base de dados de novo pode usar:

```php
php artisan migrate:fresh
```

Caso pretenda apenas reverter a última migração, pode usar:

```php
php artisan migrate:rollback
```

## Seeder

Para atualizar o Seeder, pode atualizar o ficheiro ```database/seeders/DocumentSeeder.php```.

```php
public function run(): void
{
    DB::table('documents')->insert([
        'title' => 'Declaração dos Direitos Humanos',
        'slug' => 'declaracao-dos-direitos-humanos',
        'file' => 'decl.pdf',
    ]);        
}
```

Poderá invocar o seeder com o comando:

```php
php artisan db:seed --class=DocumentSeeder
```

Ou então colocá-lo no DatabaseSeeder.php e invocar todos os seeders com o comando:

```php
public function run(): void
{    
    $this->call([
        DocumentSeeder::class
    ]);
}
```

```php
php artisan db:seed
```