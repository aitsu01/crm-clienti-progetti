# CRM Clienti, Progetti e Task

Gestionale web sviluppato con **Laravel**, **Inertia.js**, **Vue 3** e **PrimeVue** per la gestione di:

- clienti
- progetti
- task collegate ai progetti

Il progetto nasce come applicazione CRUD moderna con autenticazione, interfaccia responsive e dashboard amministrativa.

## Stack tecnologico

- **Laravel**
- **Laravel Starter Kit**
- **Inertia.js**
- **Vue 3**
- **PrimeVue**
- **MySQL**
- **Vite**
- **GitHub**

## Funzionalità implementate

### Autenticazione
- login
- registrazione
- dashboard protetta

### Gestione Clienti
- creazione cliente
- modifica cliente
- visualizzazione dettaglio cliente
- eliminazione cliente
- associazione di uno o più progetti

### Gestione Progetti
- creazione progetto
- modifica progetto
- visualizzazione dettaglio progetto
- eliminazione progetto
- associazione di uno o più clienti

### Gestione Task
- creazione task
- modifica task
- visualizzazione dettaglio task
- eliminazione task
- collegamento della task a un progetto
- visualizzazione task in formato card
- possibilità di inserire una task direttamente dalla pagina del progetto

### Dashboard
- cards statistiche
- accessi rapidi a clienti, progetti e task
- struttura responsive
- sidebar personalizzata con navigazione principale

## Modello dati

### Client
Campi principali:
- nome
- cognome
- tipo cliente (`privato` / `azienda`)
- partita IVA
- codice fiscale
- indirizzo
- email

### Project
Campi principali:
- nome
- descrizione
- stato
- data inizio
- data fine

### Task
Campi principali:
- progetto associato
- titolo
- descrizione
- stato
- priorità
- data di scadenza

## Relazioni

- un **cliente** può avere **uno o più progetti**
- un **progetto** può essere associato a **più clienti**
- un **progetto** può avere **più task**
- una **task** appartiene a **un solo progetto**

### Relazioni Eloquent
- `Client belongsToMany Project`
- `Project belongsToMany Client`
- `Project hasMany Task`
- `Task belongsTo Project`

## Struttura del progetto

```bash
app/
 ├── Http/Controllers/
 │    ├── ClientController.php
 │    ├── DashboardController.php
 │    ├── ProjectController.php
 │    └── TaskController.php
 └── Models/
      ├── Client.php
      ├── Project.php
      └── Task.php

resources/js/
 ├── components/
 ├── layouts/
 └── pages/
      ├── clients/
      ├── projects/
      ├── tasks/
      └── Dashboard.vue

database/migrations/
```

## Installazione

### 1. Clona la repository

```bash
git clone https://github.com/aitsu01/crm-clienti-progetti.git
cd crm-clienti-progetti
```

### 2. Installa le dipendenze backend

```bash
composer install
```

### 3. Installa le dipendenze frontend

```bash
npm install
```

### 4. Configura il file `.env`

Copia il file di esempio:

```bash
cp .env.example .env
```

Configura poi i parametri del database nel file `.env`.

### 5. Genera la chiave applicativa

```bash
php artisan key:generate
```

### 6. Esegui le migration

```bash
php artisan migrate
```

### 7. Avvia il progetto

Backend Laravel:

```bash
php artisan serve
```

Frontend Vite:

```bash
npm run dev
```

## Rotte principali

- `/dashboard`
- `/clients`
- `/projects`
- `/tasks`

## Interfaccia

L'applicazione utilizza:

- **PrimeVue** per componenti come bottoni, card, tag e select
- **Vue 3** per il frontend reattivo
- **Inertia.js** per una navigazione fluida senza dover costruire API REST separate

## Stato del progetto

Il progetto è attualmente in sviluppo e include già una base completa per la gestione di:

- clienti
- progetti
- task

## Miglioramenti futuri

Possibili evoluzioni del progetto:

- messaggi flash visibili
- filtri e ricerca nelle liste
- conferme di eliminazione con dialog dedicato
- seed di dati demo
- esportazione dati
- gestione ruoli e permessi
- dashboard con attività recenti più avanzata

## Repository

Repository GitHub del progetto:

```text
https://github.com/aitsu01/crm-clienti-progetti
```

## Autore

Progetto sviluppato da **Gianni** come gestionale CRM con Laravel, Inertia e PrimeVue.