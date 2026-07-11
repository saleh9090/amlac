# Project Scope

## Purpose

The purpose of Amlac is to provide a simple and reliable property management system for residential and commercial buildings.

The first version focuses on managing rental operations, contracts, payments, expenses, and reporting while keeping the system easy to maintain and extend.

---

# In Scope

## Building Management

* Create buildings
* Update building information
* View building details

---

## Unit Management

Manage all rentable units.

Supported unit types:

* Flat
* Shop

Features:

* Create units
* Edit units
* Archive units
* Assign units to buildings
* Store layout information
* Track occupancy status

---

## Tenant Management

Manage tenants.

Supported tenant types:

* Individual
* Company

Features:

* Create tenants
* Edit tenant information
* View tenant history
* Store contact information
* Store ID or Commercial Registration number

---

## Contract Management

Manage rental agreements.

Features:

* Create contracts
* Edit contracts
* Activate contracts
* Complete contracts
* Cancel contracts
* Automatic end date calculation
* Automatic unit occupancy update
* Automatic payment schedule generation

---

## Contract Payments

Manage scheduled rent payments.

Features:

* Generate payment schedules automatically
* Record received payments
* Support partial payments
* Track outstanding balances
* Track overdue payments
* View payment history

Supported payment frequencies:

* Monthly
* Quarterly
* Semi-Annual
* Annual

Supported payment methods:

* Bank Transfer
* Cheque

---

## Expense Management

Record building expenses.

Features:

* Create expenses
* Edit expenses
* Categorize expenses
* Filter expenses by building
* Track payment method

---

## Dashboard

Provide operational insights.

Examples:

* Total Buildings
* Total Units
* Vacant Units
* Occupied Units
* Active Contracts
* Contracts Expiring Soon
* Outstanding Rent
* Monthly Income
* Monthly Expenses
* Net Income

---

## Reports

Generate reports for:

* Buildings
* Units
* Tenants
* Contracts
* Rent Collection
* Outstanding Payments
* Expenses
* Income vs Expenses
* Occupancy Rate

---

# Out of Scope (Version 1)

The following features will not be included in the first release.

## Maintenance Management

Maintenance requests

Maintenance scheduling

Maintenance vendors

Maintenance costs

---

## Utility Billing

Electricity billing

Water billing

Internet billing

Service charges

---

## Accounting

General Ledger

Journal Entries

Chart of Accounts

Bank Reconciliation

Financial Statements

---

## Notifications

SMS notifications

WhatsApp notifications

Email notifications

Push notifications

---

## Document Storage

Contract attachments

Tenant documents

Scanned files

---

## Mobile Application

The first version is web-based only.

---

## Multi-language

English only.

Arabic will be added later.

---

## Multi-company

The first version manages one organization.

Support for multiple companies can be added later.

---

## AI Features

AI-generated reports

Expense analysis

Rent prediction

Occupancy forecasting

Decision support

These features are planned for future releases after sufficient operational data has been collected.

---

# Design Principles

The system should be:

* Simple
* Fast
* Reliable
* Easy to learn
* Easy to maintain
* Built using Django best practices
* Designed for future expansion without major database changes
