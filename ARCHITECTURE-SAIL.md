# Arquitetura do Sistema com Docker Sail

## Diagrama de Containers

```
+-------------------+     +----------------+
|  Laravel (PHP)    |     |   MySQL        |
|  Container: app   |<--->|  Container: db |
+-------------------+     +----------------+
       ^
       |
       v
+-------------------+
|  Vue (Frontend)   |
|  Container: node  |
+-------------------+
```

## Serviços Configurados

### PHP 8.2 (app)
- Porta: 80 (mapeada para 80 local)
- Extensões: GD, PDO, MySQL
- Volume: `/var/www/html` -> `./` (código-fonte)

### MySQL 8.0 (db)
- Porta: 3306 (mapeada para 3306 local)
- Credenciais:
    - Usuário: sail
    - Senha: password
    - Banco: laravel
- Volume: `sailmysql` -> `/var/lib/mysql`

### Node.js (node)
- Usado para compilar assets
- Volume: `/var/www/html` -> `./` (código-fonte)

## Fluxo de Requisições

1. Browser -> http://localhost
2. Nginx (no container app) -> Laravel
3. Laravel:
    - Banco: mysql (container db)
4. Frontend:
    - Vue (container node) -> Hot reload para desenvolvimento
