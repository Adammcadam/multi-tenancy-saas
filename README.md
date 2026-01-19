# Multi-Tenant Operations SaaS (Laravel + Filament)

A multi-tenant SaaS application built with Laravel and Filament, designed to manage internal operations across multiple organisations with strict tenant isolation, role-based access control, and auditable workflows.

This project is primarily for **learning and personal development**, with an emphasis on SaaS architecture, authorisation, and admin-heavy interfaces.

---

## Goals

The primary goals of this project are:

- Design and implement **multi-tenant architecture** in Laravel
- Build an **admin panel** using Filament
- Model **real business workflows**, not just CRUD
- Apply **role-based permissions** at scale
- Focus on **clean architecture and maintainability**
- Document architectural decisions and trade-offs

---

## Non-Goals

To keep the scope focused, this project intentionally avoids:

- Public-facing frontend UI
- Marketing pages or landing pages
- Mobile or SPA clients

---

## Architecture Overview

- **Framework:** Laravel
- **Admin UI:** Filament
- **Database:** Single database, shared schema
- **Tenancy Model:** Company-based (team-style tenancy)
- **Authorisation:** Role & permission-based (scoped per company)
- **Async Processing:** Laravel queues
- **Audit & Logging:** Activity-based event logging

Tenancy is enforced via:
- Tenant resolution middleware
- Global model scopes
- Explicit escape hatches for system-level access

---

## Core Concepts

### Companies (Tenants)

- Users can belong to multiple companies
- Each company acts as a logical tenant
- All business data is scoped to company

### Users & Roles

- Owner
- Admin
- Manager
- Viewer

Roles are assigned per company and determine access to:
- Resources
- Actions
- Workflow transitions

---

## Features

### Company Management

- Create and manage a company
- Invite users by email
- Assign and revoke roles
- Suspend or remove members

### Operations Module

A configurable request/workflow system used to model internal business operations.

- Request types configurable per company
- Status-based workflows
- Role-restricted status transitions
- Comments and file attachments
- SLA tracking and deadlines

### Audit & Activity Logging

- User actions tracked per company
- Before/after state snapshots
- Immutable audit history

### Super Admin Capabilities

- View all companies
- Impersonate users
- Suspend companies
- Global metrics dashboard

---

## Authorisation Model

Authorisation is enforced at multiple layers:

- Laravel policies for all domain models
- Filament Shield for admin UI permissions
- Action-level authorisation for workflows
- Tenant-aware permission scoping

This ensures:
- No cross-tenant data leakage
- No privilege escalation
- Consistent rules across UI and API layers

---

## Testing Strategy

This project focuses on **high-value tests** rather than full coverage:

- Tenant isolation tests
- Permission & policy tests
- Workflow transition tests
- Critical Filament actions

---

## Local Development

### Requirements

- PHP ^8.2
- Composer
- Node.js & NPM
- MySQL or PostgreSQL

### Setup

```bash
git clone <repo-url>
cd project-name

composer install
npm install

cp .env.example .env
php artisan key:generate
php artisan migrate --seed

php artisan serve
```

### Demo Accounts

Seeded demo accounts will be available:

#### TODO:: add demo accounts here once seeders are in


### Future Improvements

- Subdomain-based tenancy
- Subscription billing
- API access per organization
- Rate limiting per tenant
- Advanced reporting


## Disclaimer

This project is for educational purposes and is not intended for production use.
