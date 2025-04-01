# Manual do Usuário - Ambiente Sail

## Acessando a Aplicação
- **Frontend**: http://localhost

## Comandos para Desenvolvimento

### Rodar testes
```bash
./vendor/bin/sail test
```

### Monitorar alterações frontend
```bash
./vendor/bin/sail npm run dev
```

### Acessar shell do container
```bash
./vendor/bin/sail bash
```

## Fluxo de Trabalho

1. Inicie os containers:
   ```bash
   ./vendor/bin/sail up -d
   ```

2. Em outro terminal, monitore o frontend:
   ```bash
   ./vendor/bin/sail npm run dev
   ```

3. Para parar tudo:
   ```bash
   ./vendor/bin/sail down
   ```
