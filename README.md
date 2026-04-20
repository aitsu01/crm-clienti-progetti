# CRM Clienti, Progetti e Task

Gestionale web sviluppato con **Laravel**, **Inertia.js**, **Vue 3** e **PrimeVue** per la gestione completa di:

- **clienti**
- **progetti**
- **task**

L'applicazione è pensata come pannello gestionale moderno con autenticazione, dashboard amministrativa, interfaccia responsive e funzionalità CRUD complete.

---

## Obiettivo del progetto

L'obiettivo del progetto è realizzare un **CRM / gestionale interno** semplice ma estendibile, capace di gestire:

- anagrafica clienti
- assegnazione di uno o più progetti ai clienti
- gestione delle task collegate ai progetti
- monitoraggio dello stato di avanzamento del lavoro

---

## Stack tecnologico

### Backend
- **Laravel**
- **Laravel Starter Kit**
- **PHP**
- **MySQL**

### Frontend
- **Vue 3**
- **Inertia.js**
- **PrimeVue**
- **Vite**
- **Tailwind CSS**

### Versionamento
- **Git**
- **GitHub**

---

## Perché Inertia.js

Inertia è stato utilizzato per integrare **Laravel** e **Vue 3** nello stesso progetto senza dover sviluppare una API REST separata.

### Vantaggi nel progetto
- routing gestito da Laravel
- validazioni gestite lato backend
- pagine frontend dinamiche con Vue
- navigazione fluida senza refresh completi
- minore complessità rispetto a una SPA completamente separata

In questo modo il progetto mantiene la semplicità di Laravel lato server e la modernità di Vue lato interfaccia.

---

## Funzionalità implementate

### 1. Autenticazione
- login
- registrazione
- dashboard protetta
- accesso alle pagine solo per utenti autenticati

### 2. Gestione Clienti
- creazione cliente
- modifica cliente
- visualizzazione dettaglio cliente
- eliminazione cliente
- associazione di uno o più progetti
- validazione condizionale:
  - se il cliente è **azienda** → obbligo di **partita IVA**
  - se il cliente è **privato** → obbligo di **codice fiscale**

### 3. Gestione Progetti
- creazione progetto
- modifica progetto
- visualizzazione dettaglio progetto
- eliminazione progetto
- associazione di uno o più clienti
- validazione nome progetto univoco
- validazione date:
  - data inizio obbligatoria
  - data fine successiva alla data inizio
  - data inizio precompilata con la data odierna in creazione

### 4. Gestione Task
- creazione task
- modifica task
- visualizzazione dettaglio task
- eliminazione task
- collegamento della task a un progetto
- vista delle task in formato card
- inserimento task direttamente dalla pagina del progetto
- preselezione automatica del progetto da URL
- board task divisa in colonne per stato
- drag and drop tra colonne per cambiare stato

### 5. Dashboard
- cards statistiche
- quick actions
- scorciatoie rapide
- struttura responsive
- navigazione laterale personalizzata
- miglioramento UX/UI rispetto allo starter kit iniziale

### 6. Esperienza utente
- sidebar con sezioni principali
- header migliorato
- board task con colonne colorate
- card task più uniformi
- messaggi flash automatici con scomparsa dopo pochi secondi
- layout responsive

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

- un **cliente** può avere **uno o più progetti**
- un **progetto** può essere associato a **più clienti**
- un **progetto** può avere **più task**
- una **task** appartiene a **un solo progetto**

### Relazioni Eloquent
- `Client belongsToMany Project`
- `Project belongsToMany Client`
- `Project hasMany Task`
- `Task belongsTo Project`

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
│   └── Middleware/
│       └── HandleInertiaRequests.php
├── Models/
│   ├── Client.php
│   ├── Project.php
│   └── Task.php

database/
└── migrations/

resources/
└── js/
    ├── components/
    ├── layouts/
    └── pages/
        ├── clients/
        ├── projects/
        ├── tasks/
        └── Dashboard.vue

routes/
└── web.php
```

---

## Rotte principali

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
```

### 5. Generare la chiave applicativa

```bash
php artisan key:generate
```

### 6. Eseguire le migration

```bash
php artisan migrate
```

### 7. Avviare il progetto

#### Backend Laravel
```bash
php artisan serve
```

#### Frontend Vite
```bash
npm run dev
```

L'app sarà disponibile di norma su:

```text
http://127.0.0.1:8000
```

---

## Validazioni implementate

### Clienti
- nome obbligatorio
- cognome obbligatorio
- tipo obbligatorio
- partita IVA obbligatoria per azienda
- codice fiscale obbligatorio per privato
- formato partita IVA controllato
- formato codice fiscale controllato
- email validata se presente

### Progetti
- nome obbligatorio
- nome univoco
- stato obbligatorio
- data inizio obbligatoria
- data fine successiva alla data inizio

### Task
- progetto obbligatorio
- titolo obbligatorio
- stato obbligatorio
- priorità obbligatoria

---

## Interfaccia

L'interfaccia utilizza:

- **PrimeVue** per componenti come:
  - Button
  - Card
  - Tag
  - Select
  - MultiSelect
  - Message
- **Vue 3** per la parte reattiva
- **Inertia.js** per il collegamento tra Laravel e frontend
- **Tailwind CSS** per layout e responsive design

---

## Board Task

Le task sono visualizzate in modalità **board/kanban** suddivisa per stato:

- Da fare
- In corso
- In revisione
- Completata
- Bloccata

Ogni task può essere:
- trascinata tra le colonne
- aggiornata automaticamente nel database
- visualizzata, modificata o eliminata direttamente dalla card

---

## Migliorie UX/UI implementate

- sidebar personalizzata per il gestionale
- dashboard responsive
- card statistiche
- board task colorata
- card task uniformate visivamente
- bottoni azione più leggibili
- messaggi flash automatici
- link rapidi verso dashboard e sezioni principali

---

## Possibili sviluppi futuri

- ricerca e filtri nelle liste
- conferme eliminazione con dialog PrimeVue
- validazione completa del codice fiscale italiano con regola custom
- seed di dati demo
- export dati
- ruoli e permessi utenti
- log attività recenti
- scadenze task evidenziate
- drag and drop più avanzato con ordinamento
- dashboard con grafici e trend

---

## Stato del progetto

Il progetto è già utilizzabile come base gestionale con:

- autenticazione
- CRUD clienti
- CRUD progetti
- CRUD task
- relazioni database corrette
- dashboard moderna
- UI responsive
- gestione task per stato

---

## Repository

Repository GitHub ufficiale del progetto:

```text
https://github.com/aitsu01/crm-clienti-progetti
```

---
