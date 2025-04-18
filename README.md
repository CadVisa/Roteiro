#### CRIAR PROJETO COM LARAVEL
```
composer create-project laravel/laravel .
```

### instalar as dependências do npm (vite)
```
npm install
```

## instalar o Bootstrap e suas dependências
```
npm install bootstrap @popperjs/core sass --save-dev
```
## na resources/js/boostrap.js, importe o boostrap (import 'bootstrap';) abaixo do código existente.

## no arquivo resources/css/app.css importe @import 'bootstrap';

## incluir na página de layout 
@vite(['resources/css/app.css', 'resources/js/app.js'])

## vite.config.js ficará assim: 

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});

## executar os comandos para iniciar o projeto
```
php artisan serve 
```

```
npm run dev
```

## instalar o fontawesome
```
npm install @fortawesome/fontawesome-free --save-dev
```

## No arquivo resources/js/app.js, importe abaixo da importação do .bootstrap:
```
import '@fortawesome/fontawesome-free/js/all';
```
## vite.config.js ficará assim: 

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@fortawesome': '/node_modules/@fortawesome',
        },
    },
});

## inicial o git
git init

## verificar a branch 
git branch

## criar uma nova branch
git checkout -b minha-branch

## adicionar as aletarções
git add .

## Faz o commit das alterações
git commit -m "Descrição..."

## Atualize sua branch local com o repositório remoto (evita conflitos)
git pull origin main

## Envie (push) suas alterações para o GitHub

## verifique as alterações feitas 
git status

### Resumo
git checkout main
git pull origin main
git add .
git commit -m "Mensagem do commit"
git push origin main

teste 2
