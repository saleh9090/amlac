# Database Design

## Overview

Amlac uses a MySQL database to store all property management data.

The database is designed to manage buildings, units, tenants, rental contracts, scheduled contract payments, expenses, and financial reports.

The system does not track maintenance requests in the current version.

---

# Main Tables

## 1. buildings

Stores building information.

### Fields

* id
* name
* location
* description
* created_at
* updated_at

---

## 2. units

Stores all rentable units such as flats and shops.

### Fields

* id
* building_id
* unit_number
* unit_type
* layout
* floor
* area
* electricity_account
* water_account
* status
* notes
* created_at
* updated_at

### Unit Types

* Flat
* Shop

### Layout Examples

* Studio
* 1BHK
* 2BHK
* 2B2BHK
* 3BHK
* 3B2BHK
* 3B3BHK
* Shop

### Unit Status

* Vacant
* Occupied
* Reserved
* Inactive

---

## 3. tenants

Stores tenant information for individuals and companies.

### Fields

* id
* tenant_type
* name
* id_cr
* phone
* email
* address
* notes
* created_at
* updated_at

### Tenant Types

* Individual
* Company

### ID/CR

The `id_cr` field stores:

* National ID or Resident Card number for individuals.
* Commercial Registration number for companies.

---

## 4. contracts

Stores rental agreements between tenants and units.

### Fields

* id
* contract_number
* tenant_id
* unit_id
* start_date
* duration_months
* end_date
* rent_amount
* payment_frequency
* payment_method
* security_deposit
* status
* notes
* created_at
* updated_at

### Payment Frequency

* Monthly
* Quarterly
* Semi-Annual
* Annual

### Payment Methods

* Bank Transfer
* Cheque

### Contract Status

* Draft
* Active
* Completed
* Cancelled

### Business Rules

* One unit can have only one active contract at a time.
* End date is automatically calculated from the start date and duration.
* Contract payments are automatically generated when the contract becomes active.
* Rent amount is stored in the contract, not in the unit.
* Payment frequency controls how scheduled payments are generated.

---

## 5. contract_payments

Stores all scheduled rent payments generated from a contract.

### Fields

* id
* contract_id
* due_date
* payment_for_month
* payment_for_year
* amount_due
* amount_paid
* paid_date
* status
* notes
* created_at
* updated_at

### Payment Status

* Unpaid
* Partial
* Paid
* Late
* Cancelled

### Business Rules

* Payment records are automatically generated from the contract.
* The number of payment records depends on contract duration and payment frequency.
* Amount due is generated automatically.
* Amount paid is updated when the tenant makes a payment.
* Outstanding balance is calculated as amount due minus amount paid.
* A payment is marked as Late when the due date has passed and the amount paid is less than the amount due.

---

## 6. expenses

Stores building expenses.

### Fields

* id
* building_id
* expense_date
* expense_category_id
* amount
* description
* created_at
* updated_at

### Expense Categories

Expense categories are managed from the Expense Categories page and
stored in the `expense_categories` table (see below), instead of a
fixed list of choices.

---

## 7. expense_categories

Manageable list of expense categories (e.g. Maintenance, Cleaning,
Management Commission).

### Fields

* id
* name
* created_at
* updated_at

---

## 8. income_categories

Manageable list of income categories (e.g. Rent, Other Income).

### Fields

* id
* name
* created_at
* updated_at

---

## 9. incomes

Stores recorded income entries.

### Fields

* id
* date
* amount
* income_category_id
* note
* created_at
* updated_at

---

# Relationships

## Building Relationships

One building has many units.

```text
Building 1 ---- * Unit
```

One building has many expenses.

```text
Building 1 ---- * Expense
```

---

## Category Relationships

One expense category has many expenses.

```text
ExpenseCategory 1 ---- * Expense
```

One income category has many incomes.

```text
IncomeCategory 1 ---- * Income
```

---

## Unit Relationships

One unit can have many contracts over time.

```text
Unit 1 ---- * Contract
```

Only one contract should be active for a unit at the same time.

---

## Tenant Relationships

One tenant can have many contracts.

```text
Tenant 1 ---- * Contract
```

This allows the same tenant to rent more than one unit or rent different units over time.

---

## Contract Relationships

One contract has many scheduled payments.

```text
Contract 1 ---- * Contract Payment
```

Scheduled payments are linked to contracts, not directly to tenants or units.

This makes reports more accurate because the system knows which tenant, unit, and building each payment belongs to.

---

# Data Flow

## Contract Creation Flow

When a contract is created:

1. Select tenant.
2. Select unit.
3. Enter contract number.
4. Enter start date.
5. Enter duration in months.
6. System calculates end date automatically.
7. Enter rent amount.
8. Select payment frequency.
9. Select payment method.
10. Save contract.

When the contract becomes active, the system generates scheduled contract payments.

---

## Payment Generation Example

Contract details:

* Start Date: 2026-07-01
* Duration: 12 months
* Rent Amount: 300 OMR
* Payment Frequency: Monthly

Generated payments:

```text
July 2026       300 OMR
August 2026     300 OMR
September 2026  300 OMR
October 2026    300 OMR
November 2026   300 OMR
December 2026   300 OMR
January 2027    300 OMR
February 2027   300 OMR
March 2027      300 OMR
April 2027      300 OMR
May 2027        300 OMR
June 2027       300 OMR
```

---

## Payment Frequency Logic

### Monthly

Generates one payment for each month.

Example:

```text
12-month contract = 12 payments
```

### Quarterly

Generates one payment every 3 months.

Example:

```text
12-month contract = 4 payments
```

### Semi-Annual

Generates one payment every 6 months.

Example:

```text
12-month contract = 2 payments
```

### Annual

Generates one payment every 12 months.

Example:

```text
12-month contract = 1 payment
```

---

# Suggested Database Rules

## Units

* Unit number should be unique inside the same building.
* Unit type is required.
* Layout is optional for shops.
* Status should be selected from predefined values.

## Tenants

* Tenant name is required.
* Tenant type is required.
* ID/CR can be optional at the beginning, but recommended for official records.
* Phone number is required.

## Contracts

* Tenant is required.
* Unit is required.
* Contract number is required.
* Start date is required.
* Duration in months is required.
* End date is generated automatically.
* Rent amount is required.
* Payment frequency is required.
* Payment method is required.
* A unit should not have more than one active contract at the same time.

## Contract Payments

* Contract is required.
* Due date is required.
* Amount due is required.
* Amount paid defaults to zero.
* Payment status defaults to Unpaid.

## Expenses

* Building is required.
* Expense date is required.
* Amount is required.
* Expense category is required.

## Income

* Date is required.
* Amount is required.
* Income category is required.

---

# Future Optional Tables

These tables are not required in the first version, but can be added later.

## unit_types

Used if unit types need to be managed from the system.

## unit_layouts

Used if layouts need to be managed from the system.

## documents

Used to upload contract files, receipts, or tenant documents.

## users

Used when the system needs multiple users with different permissions.

---

# First Version Recommendation

For the first version, keep the database simple.

Use fixed choices for:

* Unit Type
* Unit Status
* Tenant Type
* Contract Status
* Payment Frequency
* Payment Method
* Contract Payment Status

Expense and income categories are managed from the system (expense_categories / income_categories) rather than fixed choices.

