# Publishing House Backend — Core Modules

> Backend specification for IndianOpinions editorial operations.

---

## Contents

1. [User & Role System](#1-user--role-system)
2. [Article Workflow](#2-article-workflow)
3. [Editorial Calendar](#3-editorial-calendar)
4. [Submission System](#4-submission-system)
5. [Fact-Checking & Source Manager](#5-fact-checking--source-manager)
6. [Media Library](#6-media-library)
7. [Newsletter System](#7-newsletter-system)
8. [Homepage & Section Curation](#8-homepage--section-curation)
9. [Versioning & Audit Trail](#9-versioning--audit-trail)
10. [Corrections & Updates](#10-corrections--updates)
11. [Analytics Dashboard](#11-analytics-dashboard)
12. [MVP Backend Build](#mvp-backend-build)

---

## 1. User & Role System

Beyond the basic writer/editor split, the platform should support dedicated editorial roles.

| Role | Purpose |
|------|---------|
| **Owner / Admin** | Full control |
| **Publisher** | Final approval and publish |
| **Editor-in-Chief** | Editorial calendar and assignments |
| **Section Editor** | Politics, Economy, Society, etc. |
| **Managing Editor** | Workflow, deadlines, coordination |
| **Writer** | Draft articles |
| **Contributor** | External submissions |
| **Copy Editor** | Grammar, clarity, style |
| **Fact Checker** | Sources, claims, citations |
| **Legal / Review** | Sensitive political and legal review |
| **SEO Editor** | Headlines, metadata, search |
| **Social Editor** | Distribution copy |
| **Newsletter Editor** | Email edition |
| **Researcher** | Background notes, source packs |

---

## 2. Article Workflow

Every article moves through explicit status tracking.

### Status pipeline

| Stage | Description |
|-------|-------------|
| Pitch | Initial idea or proposal |
| Assigned | Assigned to a writer |
| Drafting | Active writing |
| Editor Review | Section or managing editor review |
| Revision Requested | Sent back to author |
| Copy Edit | Grammar, clarity, style pass |
| Fact Check | Claims and sources verified |
| Legal Review | Sensitive content review |
| SEO Review | Headlines, metadata, search optimization |
| Scheduled | Queued for publish |
| Published | Live on site |
| Updated | Post-publish revision |
| Archived | Removed from active rotation |
| Rejected | Not proceeding |

### Article data model

**Core**

- title
- subtitle
- slug
- summary
- article body
- featured image

**People & placement**

- author
- editor
- section
- tags

**Editorial**

- sources
- notes
- revision history

**Publishing**

- publish date
- update date
- canonical URL

**SEO**

- SEO metadata

---

## 3. Editorial Calendar

Critical for editorial planning and predictable publishing.

### Features to build

- Calendar view
- Article deadlines
- Issue planning
- Newsletter schedule
- Scheduled publishing
- Section quotas
- Author assignments
- Weekly editorial board view

### IndianOpinions section rhythm

| Day | Section |
|-----|---------|
| Monday | Politics |
| Tuesday | Economy |
| Wednesday | Foreign Affairs |
| Thursday | Society |
| Friday | Technology |
| Sunday | Weekly Letter |

---

## 4. Submission System

For external contributors.

### Requirements

- Pitch form
- Article submission form
- Contributor bio
- Topic selection
- Conflict disclosure
- Source attachments
- Status tracking
- Accept / reject workflow

---

## 5. Fact-Checking & Source Manager

Essential for politics and economy coverage.

### Requirements

- Source links
- Citation notes
- Claim checklist
- Fact-check status
- Source reliability rating
- Quote verification
- Correction notes

---

## 6. Media Library

Basic asset management for editorial production.

### Asset types

- Images
- Author headshots
- Charts
- PDFs
- Documents

### Metadata per asset

- Captions
- Credits
- Alt text
- Copyright / source field

---

## 7. Newsletter System

Powers the **Weekly Letter** product.

### Requirements

- Newsletter draft
- Article selection
- Subject line
- Preview text
- Sections
- Subscriber list integration
- Send / schedule / export
- Archive page

---

## 8. Homepage & Section Curation

The homepage should not be automatic-only. Manual curation keeps the site intentional.

### Curation slots

- Lead story
- Featured analysis
- Section highlights
- Debate block
- Latest articles
- Newsletter CTA
- Archive picks

---

## 9. Versioning & Audit Trail

For serious publishing, every edit matters.

### Track

- Who changed what
- When it changed
- Previous versions
- Publish history
- Correction history
- Editor comments

---

## 10. Corrections & Updates

Public trust feature for transparent journalism.

### Support

- Correction notice
- Update note
- Editor’s note
- Retraction
- Article version label

---

## 11. Analytics Dashboard

Editorial and growth metrics in one place.

### Metrics

- Page views
- Newsletter signups
- Top articles
- Author performance
- Section performance
- Referral sources
- Reading time
- Conversion to newsletter

---

## MVP Backend Build

**Ship first** — everything else can follow.

| Priority | Module |
|----------|--------|
| 1 | Users / Roles |
| 2 | Articles |
| 3 | Workflow Status |
| 4 | Editorial Calendar |
| 5 | Media Library |
| 6 | Homepage Curation |
| 7 | Newsletter Drafts |
| 8 | Submissions |
