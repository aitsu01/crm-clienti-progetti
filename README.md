# CRM Clienti, Progetti e Task

Gestionale web sviluppato con **Laravel**, **Inertia.js**, **Vue 3** e **PrimeVue** per la gestione di:

- clienti
- progetti
- task

Il progetto è strutturato come applicazione web moderna con autenticazione, dashboard amministrativa, CRUD completi, validazioni tramite **Form Request** e interfaccia responsive.

---

## Obiettivo del progetto

L'obiettivo è realizzare un piccolo **CRM / gestionale** per:

- gestire clienti privati e aziende
- associare uno o più progetti ai clienti
- gestire task collegate ai progetti
- monitorare lo stato del lavoro tramite dashboard e board task

---

## Stack tecnologico

### Backend
- Laravel
- PHP
- MySQL
- Laravel Fortify

### Frontend
- Vue 3
- Inertia.js
- PrimeVue
- Tailwind CSS
- Vite

### Versionamento
- Git
- GitHub

---

## Perché Inertia.js

Inertia è stato utilizzato per collegare **Laravel** e **Vue 3** nello stesso progetto senza dover creare una API REST separata.

Vantaggi nel progetto:

- rotte gestite da Laravel
- controller e validazioni centralizzati
- pagine dinamiche con Vue
- navigazione fluida senza full reload
- minore complessità rispetto a una SPA separata frontend/backend

---

## Funzionalità implementate

### Autenticazione
- login
- registrazione
- logout
- recupero password predisposto tramite Fortify

### Clienti
- elenco clienti
- creazione cliente
- modifica cliente
- dettaglio cliente
- eliminazione cliente
- associazione di uno o più progetti

### Progetti
- elenco progetti
- creazione progetto
- modifica progetto
- dettaglio progetto
- eliminazione progetto
- associazione di uno o più clienti

### Task
- elenco task
- creazione task
- modifica task
- dettaglio task
- eliminazione task
- associazione a un progetto
- board task per stato
- drag and drop tra colonne per cambiare stato

### Dashboard
- cards statistiche
- scorciatoie rapide
- sezioni recenti
- pulsante logout
- layout responsive

### Interfaccia
- sidebar personalizzata
- welcome page personalizzata
- login e registrazione tradotti e semplificati
- flash messages automatici
- dark mode compatibile

---

## Modello dati

### Client
Campi principali:
- `first_name`
- `last_name`
- `type`
- `vat_number`
- `tax_code`
- `address`
- `email`

### Project
Campi principali:
- `name`
- `description`
- `status`
- `start_date`
- `end_date`

### Task
Campi principali:
- `project_id`
- `title`
- `description`
- `status`
- `priority`
- `due_date`

---

## Relazioni

- un **cliente** può essere associato a **più progetti**
- un **progetto** può essere associato a **più clienti**
- un **progetto** può avere **più task**
- una **task** appartiene a **un solo progetto**

### Relazioni Eloquent
- `Client belongsToMany Project`
- `Project belongsToMany Client`
- `Project hasMany Task`
- `Task belongsTo Project`

---

## Validazioni implementate

### Clienti
- nome obbligatorio
- cognome obbligatorio
- tipo obbligatorio
- se il cliente è **azienda**:
  - partita IVA obbligatoria
- se il cliente è **privato**:
  - codice fiscale obbligatorio
- formato partita IVA controllato
- formato codice fiscale controllato
- email validata se presente

### Progetti
- nome obbligatorio
- nome univoco
- stato obbligatorio
- data inizio obbligatoria
- data fine successiva alla data inizio
- data inizio predefinita nella creazione

### Task
- progetto obbligatorio
- titolo obbligatorio
- stato obbligatorio
- priorità obbligatoria
- data scadenza valida se presente

---

## Form Request utilizzati

La validazione è stata spostata dai controller ai **Form Request**.

### Clienti
- `StoreClientRequest`
- `UpdateClientRequest`

### Progetti
- `StoreProjectRequest`
- `UpdateProjectRequest`

### Task
- `StoreTaskRequest`
- `UpdateTaskRequest`

---

## Localizzazione

Il progetto supporta la lingua italiana tramite i file in:

```bash
lang/it/
```

File principali tradotti:
- `validation.php`
- `auth.php`
- `pagination.php`

Questo consente di mostrare:
- messaggi di validazione in italiano
- messaggi di autenticazione in italiano
- paginazione tradotta

---

## Task board

Le task sono visualizzate in una board suddivisa per stato:

- `da_fare`
- `in_corso`
- `in_revisione`
- `completata`
- `bloccata`

Funzionalità:
- card visivamente uniformate
- colonne colorate
- spostamento task via drag and drop
- aggiornamento rapido dello stato

---

## Struttura del progetto

```bash
app/
├── Http/
│   ├── Controllers/
│   │   ├── ClientController.php
│   │   ├── DashboardController.php
│   │   ├── ProjectController.php
│   │   └── TaskController.php
│   ├── Middleware/
│   │   └── HandleInertiaRequests.php
│   └── Requests/
│       ├── Clients/
│       ├── Projects/
│       └── Tasks/
├── Models/
│   ├── Client.php
│   ├── Project.php
│   └── Task.php

resources/js/
├── components/
├── layouts/
└── pages/
    ├── auth/
    ├── clients/
    ├── projects/
    ├── tasks/
    ├── Dashboard.vue
    └── Welcome.vue

routes/
└── web.php
```

---

## Rotte principali

- `/`
- `/login`
- `/register`
- `/dashboard`
- `/clients`
- `/projects`
- `/tasks`

---

## Installazione

### 1. Clonare la repository

```bash
git clone https://github.com/aitsu01/crm-clienti-progetti.git
cd crm-clienti-progetti
```

### 2. Installare le dipendenze backend

```bash
composer install
```

### 3. Installare le dipendenze frontend

```bash
npm install
```

### 4. Configurare l'ambiente

Copia il file `.env.example`:

```bash
cp .env.example .env
```

Poi configura il database nel file `.env`.

Esempio:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=test
DB_USERNAME=root
DB_PASSWORD=
APP_LOCALE=it
APP_FALLBACK_LOCALE=it
APP_FAKER_LOCALE=it_IT
```

### 5. Generare la chiave applicativa

```bash
php artisan key:generate
```

### 6. Eseguire le migration

```bash
php artisan migrate
```

### 7. Pubblicare i file lingua

```bash
php artisan lang:publish
```

### 8. Avviare il progetto

#### Backend Laravel
```bash
php artisan serve
```

#### Frontend Vite
```bash
npm run dev
```

L'app sarà disponibile in locale su:

```text
http://127.0.0.1:8000
```

---

## UX / UI migliorate

Nel progetto sono state migliorate diverse parti dell'interfaccia:

- dashboard più leggibile e moderna
- sidebar personalizzata
- pulsanti azione più chiari
- card task uniformi
- logout dalla dashboard
- welcome page personalizzata
- login e register in italiano
- messaggi flash temporanei

---

## Possibili sviluppi futuri

- filtri e ricerca avanzata
- conferme eliminazione con dialog dedicato
- validazione completa del codice fiscale italiano con regola custom
- gestione ruoli e permessi
- seed di dati demo
- esportazione dati
- dashboard con grafici
- notifiche e scadenze task

---

## Repository

Repository GitHub del progetto:

```text
https://github.com/aitsu01/crm-clienti-progetti
```

---

