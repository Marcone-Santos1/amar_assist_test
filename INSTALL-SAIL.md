# Manual de Instalação com Laravel Sail

## Pré-requisitos
- Docker Desktop instalado
- Git instalado

## Passo a Passo

1. Clone o repositório:
   ```bash
   git clone https://github.com/seu-repositorio/projeto.git
   cd projeto
   ```

2. Instale as dependências PHP (usando o container do Sail):
   ```bash
   ./vendor/bin/sail composer install
   ```

3. Configure o ambiente:
   ```bash
   cp .env.example .env
   ./vendor/bin/sail artisan key:generate
   ```

4. Suba os containers:
   ```bash
   ./vendor/bin/sail up -d
   ```

5. Execute as migrações e seeders:
   ```bash
   ./vendor/bin/sail artisan migrate
   ```

6. Instale as dependências frontend:
   ```bash
   ./vendor/bin/sail npm install
   ```

7. Compile os assets (para desenvolvimento):
   ```bash
   ./vendor/bin/sail npm run dev
   ```

8. Acesse a aplicação:
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
