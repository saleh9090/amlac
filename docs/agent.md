# Codex Agent Instructions

## Project Name

Amlac

## Goal

Build an internal property management system using Django and MySQL.

The system is for learning Django and managing real building operations.

## Main Rules

* Keep the first version simple.
* Use Django Admin first.
* Use MySQL.
* Do not build maintenance requests.
* Do not build mobile app.
* Do not build notifications.
* Do not build multi-company support.
* Use clean Django models.
* Use DecimalField for money.
* Use fixed choices for dropdown values in version 1.
* Add comments where business logic is important.

## Required Apps

Create these Django apps:

* buildings
* units
* tenants
* contracts
* payments
* expenses
* dashboard
* reports

## Main Models

### Building

* name
* location
* description

### Unit

* building
* unit_number
* unit_type
* layout
* floor
* area
* electricity_account
* water_account
* status
* notes

### Tenant

* tenant_type
* name
* id_cr
* phone
* email
* address
* notes

### Contract

* contract_number
* tenant
* unit
* start_date
* duration_months
* end_date
* rent_amount
* payment_frequency
* payment_method
* security_deposit
* status
* notes

### ContractPayment

* contract
* due_date
* payment_for_month
* payment_for_year
* amount_due
* amount_paid
* paid_date
* status
* notes

### Expense

* building
* expense_date
* expense_category
* amount
* description
* payment_method
* reference_number

## Business Logic

### Contract End Date

When saving a contract, calculate end_date automatically from start_date and duration_months.

### Contract Payments

When a contract becomes active, generate scheduled contract payments based on payment_frequency:

* Monthly = every 1 month
* Quarterly = every 3 months
* Semi-Annual = every 6 months
* Annual = every 12 months

### Payment Status

Calculate status based on amount_due, amount_paid, paid_date, and due_date.

### Unit Occupancy

A unit is occupied if it has an active contract.

A unit is vacant if it has no active contract.

## Development Order

1. Create project structure.
2. Configure MySQL.
3. Create apps.
4. Create models.
5. Create migrations.
6. Register models in Django Admin.
7. Add admin filters and search.
8. Add contract payment generation logic.
9. Add dashboard.
10. Add reports.
