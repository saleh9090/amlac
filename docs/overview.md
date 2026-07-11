# Amlac

## Overview

Amlac is a property management system designed to manage residential and commercial rental properties.

The system helps property owners manage buildings, rental units, tenants, contracts, rent collections, expenses, and financial reporting through a centralized web application.

Although the project is currently being developed as an internal system for learning and managing real operations, the architecture follows production-level standards, allowing it to evolve into a commercial solution in the future.

---

# Vision

Build a modern, scalable, and easy-to-use property management platform that simplifies rental operations while providing accurate financial insights and business reporting.

---

# Objectives

- Centralize all property management data.
- Replace manual Excel spreadsheets with a structured database.
- Simplify rental contract management.
- Track rent collections and outstanding balances.
- Record and categorize building expenses.
- Generate financial and occupancy reports.
- Build a solid Django learning project using real-world business requirements.
- Create a strong foundation for future AI-powered analytics.

---

# Property Structure

The system is designed around a single entity called **Unit**.

A Unit represents any rentable property inside a building.

Examples include:

- Flat
- Shop

Each unit belongs to one building and contains its own rental and occupancy information.

---

# Unit Type

Every unit has a Unit Type.

Initial supported types:

- Flat
- Shop

The design allows additional unit types to be added in the future without changing the overall system architecture.

---

# Unit Layout

Residential units may include a layout description.

Examples:

- Studio
- 1BHK
- 2BHK
- 2B2BHK
- 3BHK
- 3B3BHK
- Penthouse

Commercial units such as shops may leave this field empty.

---

# Core Features

- Building Management
- Unit Management
- Tenant Management
- Rental Contracts
- Rent Collection
- Expense Management
- Financial Reports
- Dashboard & Analytics

---

# Technology Stack

| Component | Technology |
|----------|------------|
| Backend | Django |
| Database | MySQL |
| ORM | Django ORM |
| Authentication | Django Authentication |
| Admin Panel | Django Admin |
| Charts | Chart.js |
| Future AI | Python, Pandas, AI Agents |

---

# Project Goals

This project has two primary goals:

1. Manage real property operations efficiently.
2. Learn professional Django application architecture using a real business case.

The project emphasizes clean architecture, maintainability, scalability, and production-ready development practices from the beginning.