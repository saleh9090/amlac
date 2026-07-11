# Architecture

## Technology Stack

* Backend: Django
* Database: MySQL
* ORM: Django ORM
* Admin Panel: Django Admin
* Frontend: Django Templates
* Charts: Chart.js
* Future Data Analysis: Python and Pandas

## Suggested Django Apps

amlac/
├── config/
├── buildings/
├── units/
├── tenants/
├── contracts/
├── payments/
├── expenses/
├── dashboard/
├── reports/
└── docs/

## App Responsibilities

### buildings

Handles building data.

### units

Handles flats and shops.

### tenants

Handles individuals and companies renting units.

### contracts

Handles rental contracts.

### payments

Handles generated contract payments.

### expenses

Handles building expenses.

### dashboard

Shows summary statistics.

### reports

Shows detailed financial and operational reports.

## Database

The system uses MySQL.

All financial records should use Decimal fields, not Float fields.

## First Version UI

The first version should use Django Admin first.

Custom dashboard and reports can be added after the models are stable.

---
