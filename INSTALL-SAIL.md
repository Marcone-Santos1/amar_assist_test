# Manual de Instalação com Laravel Sail

## Pré-requisitos
- Docker Desktop instalado
- Git instalado

## Passo a Passo

1. Clone o repositório e instale o sail:
   ```bash
   git clone https://github.com/Marcone-Santos1/amar_assist_test.git
   cd amar_assist_test
   ```
   
2. Configure o ambiente:
   ```bash
   cp .env.example .env
   ```

3. Instale o sail:
   ```bash
    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
   ```

4. Suba os containers e gere a key:
   ```bash
   ./vendor/bin/sail up -d
   
   ./vendor/bin/sail artisan key:generate
   ```
   
5. Execute as migrações e seeders:
   ```bash
   ./vendor/bin/sail artisan migrate
   ```

6. Instale as dependências frontend:
   ```bash
   ./vendor/bin/sail npm install
   ```

7. Compile os assets:
   ```bash
   ./vendor/bin/sail npm run dev
   ```

8. Link o storage:
   ```bash
   ./vendor/bin/sail artisan storage:link
   ```

9. Acesse a aplicação:
   ```
   http://localhost
   ```

## Comandos Úteis

| Comando                      | Descrição                              |
|------------------------------|----------------------------------------|
| `./vendor/bin/sail up -d`    | Inicia os containers em background     |
| `./vendor/bin/sail stop`     | Para os containers                     |
| `./vendor/bin/sail bash`     | Acessa o container principal           |
| `./vendor/bin/sail mysql`    | Acessa o MySQL                         |
| `./vendor/bin/sail npm`      | Executa comandos NPM                   |
| `./vendor/bin/sail artisan`  | Executa comandos Artisan               |
| `./vendor/bin/sail test`     | Executa os testes PHP                  |
