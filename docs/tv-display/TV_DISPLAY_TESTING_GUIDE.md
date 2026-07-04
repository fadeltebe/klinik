# TV Display - Workflow Testing & Verification Guide

## 📺 Komponen yang Telah Dibuat

### 1. **Livewire Component**: `QueueDisplay`
- **Location**: [app/Livewire/TvDisplay/QueueDisplay.php](app/Livewire/TvDisplay/QueueDisplay.php)
- **Features**:
  - Real-time queue data loading
  - Displays active appointment (in_service or in_queue)
  - Shows next 5 appointments
  - Supports filtering by polyclinic_id

### 2. **Blade View**: `queue-display.blade.php`
- **Location**: [resources/views/livewire/tv-display/queue-display.blade.php](resources/views/livewire/tv-display/queue-display.blade.php)
- **Features**:
  - Fullscreen TV display layout
  - Large animated queue number
  - Next queue list with 5 items
  - Responsive design (desktop, tablet, mobile)
  - `wire:poll.3s` untuk auto-refresh setiap 3 detik

### 3. **Routes**: Public TV Display
- **Route 1**: `/tv-display` - Display semua antrian
- **Route 2**: `/tv-display/{polyclinic_id}` - Filter antrian per polyclinic

## 🧪 Testing Workflow

### Prerequisites
- Laravel development server running
- Database dengan test data (seed data)
- Access ke admin & patient dashboard

### Test Scenario 1: Booking & Queue Display

**Step 1: Patient Books Appointment**
```
1. Access patient dashboard (http://localhost:8000/patient/dashboard)
2. Click "Book Appointment"
3. Select:
   - Patient Profile
   - Doctor/Polyclinic
   - Date & Time
4. Submit booking
5. Appointment created with status: "pending"
```

**Step 2: Admin Reviews & Approves**
```
1. Login as Admin
2. Go to Admin Queue (http://localhost:8000/admin/queue)
3. Find the pending appointment
4. Click "Approve" button
5. Status changes to: "confirmed"
```

**Step 3: Admin Moves to Queue**
```
1. Still in Admin Queue
2. Find the appointment
3. Click "Move to Queue" or similar button
4. Status changes to: "in_queue"
5. Queue number assigned automatically
```

**Step 4: Admin Calls Patient (Start Service)**
```
1. Click "Call Next" or "Start Service"
2. Status changes to: "in_service"
3. TV display should show this appointment as active
```

**Step 5: Verify TV Display Updates**
```
1. Open http://localhost:8000/tv-display in a separate window/TV screen
2. Should show:
   - Large queue number of current appointment
   - Patient name
   - Doctor name
   - Next 5 appointments in list below
3. Verify auto-refresh: watch for smooth transitions every 3 seconds
```

### Test Scenario 2: Multiple Appointments

**Setup**: Create 10 test appointments with different statuses
```bash
php artisan tinker
# Create appointments with various statuses
App\Models\Appointment::factory(10)->create([
    'status' => 'in_queue'
]);
```

**Verify**:
1. Open `/tv-display`
2. Should show first appointment (in_service or first in_queue) as active
3. List should show next 5 appointments
4. When admin changes status, display should update within 3 seconds

### Test Scenario 3: Empty Queue

**Setup**: Delete all in_queue and in_service appointments

**Verify**:
1. Open `/tv-display`
2. Should show "Tidak ada antrean saat ini" message
3. No errors in console

### Test Scenario 4: Polyclinic Filtering

**Setup**: Create appointments for different polyclinics

**Verify**:
1. Open `/tv-display/1` (filter by polyclinic 1)
2. Should only show appointments for that polyclinic
3. Open `/tv-display/2` (filter by polyclinic 2)
4. Should show different appointments

## 🔍 Quality Assurance Checklist

### UI/UX Testing
- [ ] Large queue number is clearly visible
- [ ] Text is readable from distance (TV screen simulation)
- [ ] Colors are appropriate (gradient background)
- [ ] Animation pulse effect works smoothly
- [ ] Next queue list is scrollable if > 5 items
- [ ] No UI elements overlap

### Responsiveness
- [ ] Desktop view (1920x1080): Shows 2 columns
- [ ] Tablet view (1024x768): Shows 1 column, adapts layout
- [ ] Mobile view: Still readable but optimized
- [ ] Full-screen mode works properly

### Data Accuracy
- [ ] Active appointment shows correct data
- [ ] Next 5 appointments in correct order
- [ ] Queue numbers are properly formatted (e.g., 001, 002)
- [ ] Patient names are correct
- [ ] Doctor names are correct

### Real-time Updates
- [ ] Auto-refresh every 3 seconds works
- [ ] No flickering or lag during refresh
- [ ] Data updates correctly when status changes
- [ ] No memory leaks (console check)

### Edge Cases
- [ ] Empty queue handled gracefully
- [ ] No appointments for polyclinic
- [ ] Multiple patients with same name
- [ ] Special characters in names
- [ ] Very long patient/doctor names (should truncate)

### Performance
- [ ] Page loads in < 2 seconds
- [ ] Polling doesn't cause lag
- [ ] Database queries are optimized (check with Laravel Debugbar)
- [ ] No N+1 query problems

### Accessibility
- [ ] High contrast for readability
- [ ] Font sizes appropriate for distance viewing
- [ ] No reliance on color alone
- [ ] Numbers are clear and distinguishable

## 📊 Testing Commands

### Run Database Seeders
```bash
php artisan db:seed --class=PatientSeeder
php artisan db:seed --class=DoctorSeeder
php artisan db:seed --class=AdminSeeder
```

### Generate Test Appointments
```bash
php artisan tinker
> App\Models\Appointment::factory(15)->create(['status' => 'in_queue']);
```

### Clear Queue
```bash
php artisan tinker
> App\Models\Appointment::where('status', 'in_queue')->delete();
```

### Monitor Queries
```bash
# In config/app.php ensure debug is true
# Use Laravel Debugbar or enable query logging
```

## 🐛 Troubleshooting

### Issue: Component not found
**Solution**: Verify component path matches namespace
```
App\Livewire\TvDisplay\QueueDisplay
File: app/Livewire/TvDisplay/QueueDisplay.php
```

### Issue: Polling not working
**Solution**: Ensure:
1. Livewire JS is included in layout
2. `wire:poll.3s` directive is present
3. `loadQueueData()` method exists in component

### Issue: Data not showing
**Solution**: 
1. Check database has appointments with correct status
2. Verify relationships are loaded properly
3. Check Blade syntax for array access `['key']` not `->`

### Issue: Styling not applied
**Solution**:
1. Clear browser cache (Ctrl+Shift+Del)
2. Refresh page with `Ctrl+F5`
3. Check Tailwind CSS is included in view

## 📝 Next Steps

1. **Integrate Status Update UI**:
   - Add buttons in admin queue to:
     - Move appointment to queue
     - Start service (in_service)
     - Complete service (completed)

2. **Sound Notifications** (Optional):
   - Add beep sound when new patient called

3. **Analytics**:
   - Track average service time
   - Monitor queue length
   - Track appointment completion rate

4. **Multi-TV Support**:
   - Support multiple polyclinics
   - Individual TV for each doctor
   - Rotating display schedules

5. **Enhanced Features**:
   - Show estimated wait time
   - Display health tips/ads between appointments
   - Print queue tickets
   - SMS notifications to patients

## 📞 Support Notes

- TV Display adalah **public route** - tidak perlu login
- Data auto-refresh setiap **3 detik**
- Support **polyclinic filtering** via query parameter
- Responsive design untuk berbagai ukuran layar
