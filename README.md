# Task Project - To-Do List

## Descrição do Projeto

Este é um projeto de caratér didático, consistindo na implementação de uma aplicação de lista de tarefas (To-Do List) utilizando **Laravel 12** como backend e **Vue.js 3** como frontend.

## Objetivo do Teste

O projeto visa demonstrar conhecimentos em:

- Desenvolvimento de APIs RESTful com Laravel
- Frontend moderno com Vue.js e Pinia
- Gerenciamento de banco de dados SQLite
- Sistema de filas e jobs em Laravel
- Implementação de cache e invalidação
- Soft deletes
- Integração frontend/backend

## Stack Tecnológica

### Backend
- **Laravel 12.x** - Framework PHP
- **SQLite** - Banco de dados
- **PHP 8.2+** - Linguagem de programação

### Frontend
- **Vue.js 3.4** - Framework JavaScript
- **Pinia 2.1** - Gerenciamento de estado
- **Vite 6.3** - Build tool
- **Bootstrap 5.0** - Framework CSS

### Ferramentas de Desenvolvimento
- **Laravel Vite Plugin** - Integração Vite/Laravel
- **Concurrently** - Execução paralela de comandos
- **Laravel Pail** - Log viewer
- **PEST Php** - Testes unitários

## Estrutura do Projeto

```
├── app/
│   ├── Http/Controllers/     # Controllers da API
│   ├── Models/              # Models Eloquent
│   ├── Jobs/                # Jobs para processamento em fila
│   └── Services/            # Services para lógica de negócio
├── database/
│   ├── migrations/          # Migrações do banco
│   └── seeders/            # Seeders para dados iniciais
├── resources/
│   ├── js/
│   │   ├── components/      # Componentes Vue.js
│   │   ├── stores/         # Stores Pinia
│   │   └── services/       # Services para API
│   ├── css/                # Estilos CSS
│   └── views/              # Views Blade
├── routes/
│   ├── web.php             # Rotas web
│   └── api.php             # Rotas da API
```

## Funcionalidades Requeridas

### 1. Gerenciamento de Tarefas (CRUD)

#### Operações:
- **Criar** nova tarefa
- **Listar** todas as tarefas (não excluídas)
- **Visualizar** tarefa específica
- **Editar** tarefa existente (clique para editar)
- **Marcar** como finalizada/não finalizada
- **Excluir** tarefa (soft delete)

### 2. Interface do Usuário

- Lista de tarefas responsiva
- Modal para criação/edição de tarefas
- Botões de ação (editar, finalizar, excluir)
- Feedback visual para diferentes estados das tarefas

### 3. Sistema de Filas e Jobs

- **Job de Exclusão Automática**: Após uma tarefa ser marcada como finalizada, é criado um job que será executado em 10 minutos para excluir definitivamente o registro
- Configuração de fila para processamento assíncrono

### 4. Sistema de Cache

- **Cache para Requests GET**: Implementação de cache para listagem e visualização de tarefas usando <strong>REDIS</strong>
- **Invalidação de Cache**: Gerenciar invalidação automática quando dados são modificados (CREATE, UPDATE, DELETE)
- Tags de cache para invalidação granular

6. **Cache**
   - Implementar cache com tags
   - Service ou Repository pattern para gerenciar cache

### Frontend (Vue.js)

1. **Componentes**
   - `TaskList.vue` - Lista de tarefas
   - `TaskItem.vue` - Item individual de tarefa
   - `CreateTaskModal.vue` - Modal para criar
   - `EditTaskModal.vue` - Modal para editar
   - `TaskForm.vue` - Formulário de tarefa

## Configuração e Execução

### Pré-requisitos
- PHP 8.2+
- Composer
- Node.js 18+
- SQLite
- Redis

### Instalação

1. **Clone e instale dependências:**
   ```bash
   composer install
   npm install
   ```

2. **Configuração do ambiente:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Configuração do banco de dados (.env):**
   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=database/database.sqlite
   ```

4. **Configurando REDIS (.env):**
```env
QUEUE_CONNECTION=redis
CACHE_DRIVER=redis
CACHE_STORE=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=sua_senha
REDIS_PORT=sua_porta
REDIS_CACHE_CONNECTION=cache
```

5. **Execute as migrações:**
   ```bash
   php artisan migrate
   ```

6. **Execute o projeto:**
   ```bash
   composer run dev
   ```
   
   Ou alternativamente:
   ```bash
   # Terminal 1 - Laravel
   php artisan serve
   
   # Terminal 2 - Queue Worker
   php artisan queue:work
   
   # Terminal 3 - Vite
   npm run dev
   ```

### Scripts Disponíveis

- `composer run dev` - Executa todos os serviços simultaneamente
- `composer run test` - Executa os testes
- `npm run dev` - Desenvolvimento frontend
- `npm run build` - Build de produção

