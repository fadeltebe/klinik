# 🎬 TV Display - Visual Workflow Guide

## 🎯 Sistem Workflow

```
USER JOURNEY                          SYSTEM FLOW
─────────────────────────────────────────────────────────────────────

Patient
  │
  ├─→ Book Appointment
  │        │
  │        └─→ DB: Save (status: pending)
  │
  └─→ Wait for Approval

                                   ADMIN
                                   └─→ Review Queue
                                        │
                                        ├─→ Approve
                                        │   └─→ DB: status = confirmed
                                        │
                                        ├─→ Move to Queue
                                        │   └─→ DB: status = in_queue
                                        │       Assign queue_number
                                        │
                                        ├─→ Call Next Patient
                                        │   └─→ DB: status = in_service
                                        │
                                        └─→ Mark Complete
                                            └─→ DB: status = completed

                                                            TV DISPLAY
                                                            │
                                                            ├─→ Poll every 3s
                                                            │   └─→ Load data from DB
                                                            │
                                                            ├─→ Display Active
                                                            │   (status: in_service OR first in_queue)
                                                            │
                                                            └─→ Display Next 5
                                                                (status: in_queue)
```

## 📺 Display Layout

```
┌─────────────────────────────────────────────────────────────────┐
│                      TV DISPLAY SCREEN                          │
│  [http://localhost:8000/tv-display]                             │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  ┌───────────────────────────┐   ┌────────────────────────────┐ │
│  │                           │   │                            │ │
│  │      NOMOR ANTREAN        │   │  Antrean Berikutnya        │ │
│  │                           │   │                            │ │
│  │           001             │   │  ┌──────────────────────┐  │ │
│  │                           │   │  │ 002                  │  │ │
│  │   John Doe                │   │  │ John Doe             │  │ │
│  │   Dr. Budi Santoso        │   │  │ Dr. Budi Santoso     │  │ │
│  │                           │   │  └──────────────────────┘  │ │
│  │ [Pulsing animation]       │   │                            │ │
│  │                           │   │  ┌──────────────────────┐  │ │
│  │                           │   │  │ 003                  │  │ │
│  │                           │   │  │ Jane Smith           │  │ │
│  │                           │   │  │ Dr. Ahmad Ibrahim    │  │ │
│  │                           │   │  └──────────────────────┘  │ │
│  │                           │   │                            │ │
│  │                           │   │  ┌──────────────────────┐  │ │
│  │                           │   │  │ 004                  │  │ │
│  │                           │   │  │ Bob Johnson          │  │ │
│  │                           │   │  │ Dr. Siti Nurhaliza   │  │ │
│  │                           │   │  └──────────────────────┘  │ │
│  │                           │   │                            │ │
│  │                           │   │  ┌──────────────────────┐  │ │
│  │                           │   │  │ 005                  │  │ │
│  │                           │   │  │ Alice Brown          │  │ │
│  │                           │   │  │ Dr. Hendra Wijaya    │  │ │
│  │                           │   │  └──────────────────────┘  │ │
│  │                           │   │                            │ │
│  │                           │   │  ┌──────────────────────┐  │ │
│  │                           │   │  │ 006                  │  │ │
│  │                           │   │  │ Charlie Lee          │  │ │
│  │                           │   │  │ Dr. Dewi Lestari     │  │ │
│  │                           │   │  └──────────────────────┘  │ │
│  │                           │   │                            │ │
│  └───────────────────────────┘   └────────────────────────────┘ │
│                                                                  │
│  [Auto-refresh every 3 seconds via wire:poll.3s]                │
└─────────────────────────────────────────────────────────────────┘
```

## 🔄 Status Flow Diagram

```
               APPOINTMENT LIFECYCLE
               
    PENDING → CONFIRMED → IN_QUEUE → IN_SERVICE → COMPLETED
       ↑                                                ↓
       └──────────────── CANCELLED ←───────────────────┘

    DISPLAY STATUS:
    ✗ PENDING (hidden)
    ✗ CONFIRMED (hidden)
    ✓ IN_QUEUE (shown)
    ⭐ IN_SERVICE (active/highlighted)
    ✗ COMPLETED (hidden)
    ✗ CANCELLED (hidden)
```

## 📊 Data Flow

```
DATABASE                        COMPONENT                   VIEW
─────────────────────────────────────────────────────────────────

Appointments Table
    ├── id
    ├── queue_number ──→ loadQueueData() ──→ $activeAppointment
    ├── patient_profile_id                    (large number)
    ├── doctor_id        ├─→ Active: in_service or first in_queue
    ├── status           ├─→ Next: slice(+1, 5) of remaining
    └── appointment_date └─→ Poll every 3s for updates

PatientProfile Table ──→ Load patient name
Doctor Table         ──→ Load doctor name
```

## 🎨 Color Scheme

```
Primary Gradient:
┌─────────────────────────────┐
│ ████████████████████████    │ #667eea (Blue)
│ ████████████████████████    │ 
│ ████████████████████████    │ ↓ Gradient
│ ████████████████████████    │
│ ████████████████████████    │ #764ba2 (Purple)
└─────────────────────────────┘

Dark Background: #1a1a1a
Card Background: #2a2a2a
Accent: #667eea

Text Colors:
- Active: white (100%)
- Secondary: white (85%)
- Tertiary: white (60%)
```

## 📱 Responsive Breakpoints

```
DESKTOP (1920x1080+)
┌──────────────┬──────────────┐
│   ACTIVE     │    NEXT 5    │
│   (large)    │              │
│              │              │
└──────────────┴──────────────┘
2 Columns | Queue #: 180px | List: 28px #


TABLET (1024x768)
┌──────────────────────────────┐
│          ACTIVE              │
│        (medium)              │
├──────────────────────────────┤
│         NEXT 5               │
│                              │
└──────────────────────────────┘
1 Column | Queue #: 120px | List: 24px #


MOBILE (375x667)
┌──────────────┐
│   ACTIVE     │
│   (small)    │
├──────────────┤
│   NEXT 5     │
│              │
└──────────────┘
1 Column | Queue #: 80px | List: 16px #
```

## 🔁 Polling Cycle

```
TIME (seconds)     LIVEWIRE CYCLE
──────────────────────────────────────

0s    ─→ Initial page load
      ├─ Component mounts
      └─ Call loadQueueData()
              ├─ Query DB
              ├─ Get active appointment
              ├─ Get next 5
              └─ Return to view

1s    ─→ No polling (waiting)

2s    ─→ No polling (waiting)

3s    ─→ POLL TRIGGERED (wire:poll.3s)
      ├─ Call loadQueueData()
      ├─ Check for changes
      ├─ Re-render if changed
      └─ Display updates

4s    ─→ No polling (waiting)

5s    ─→ No polling (waiting)

6s    ─→ POLL TRIGGERED AGAIN
      └─ Repeat cycle...
```

## 🎬 Animation Timeline

```
QUEUE NUMBER ANIMATION (Pulsing)

Size:     100% ──→ 105% ──→ 100%
Time:     0s      1s       2s
          ├─ scale(1.0)
          ├─ scale(1.05) [peak]
          └─ scale(1.0)
          
Repeat: Every 2 seconds continuously

CSS: animation: pulse 2s ease-in-out infinite;
```

## 📲 API/Route Flow

```
REQUEST                        ROUTING
───────────────────────────────────────────

GET /tv-display
    ├─ Public (no auth)
    ├─→ Route to QueueDisplay component
    │   └─ No polyclinic filter
    └─→ Load all appointments

GET /tv-display/1
    ├─ Public (no auth)
    ├─→ Route to QueueDisplay component
    │   ├─ Mount with polyclinic_id = 1
    │   └─ Filter appointments for polyclinic 1
    └─→ Load filtered appointments

LIVEWIRE POLLING (Every 3s)
    ├─ wire:poll.3s="loadQueueData"
    ├─→ Call loadQueueData() method
    ├─→ Query database
    └─→ Re-render view with fresh data
```

## 🗂️ Component Structure

```
QueueDisplay Component
├── Public Properties
│   ├── $activeAppointment
│   ├── $nextAppointments
│   └── $polyclinic_id
│
├── Methods
│   ├── mount($polyclinic_id = null)
│   │   └─ Initialize component
│   └── loadQueueData()
│       ├─ Query appointments
│       ├─ Filter by status (in_queue, in_service)
│       ├─ Set active appointment
│       └─ Load next 5
│
└── View
    └── queue-display.blade.php
        ├─ Active section (large number)
        ├─ Next queue section (5 items)
        └─ wire:poll.3s directive
```

## 🎓 Key Transitions

```
STATE 1: Empty Queue          STATE 2: Has Appointments
┌────────────────────┐        ┌─────────────────────┐
│ No Queue Message   │   →    │ Active: 001         │
│ (Error state)      │        │ Next: 002-006       │
└────────────────────┘        └─────────────────────┘
                                    ↓
                            [Admin calls patient]
                                    ↓
                              STATE 3: Updated
                              ┌─────────────────┐
                              │ Active: 002     │
                              │ Next: 003-007   │
                              └─────────────────┘
```

## ⚡ Performance Metrics

```
Page Load Time:        < 2 seconds
First Paint:           < 500ms
Polling Interval:      3 seconds
Database Queries:      ~5-7 per poll
Memory Usage:          ~2-5 MB
CPU Usage:             < 5% idle

Optimization:
├─ Eager loading (with relationships)
├─ Status filtering (in_queue, in_service)
├─ Polyclinic filtering (optional)
└─ Limit to 5 next appointments
```

---

**Last Updated**: 2026-06-30  
**Status**: ✅ Ready for Implementation
