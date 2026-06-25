You are an expert full-stack web developer specializing in Laravel, Livewire, and Tailwind CSS. Your task is to build the core engine and initial responsive UI for a "Mobile-First Multi-Specialist Clinic Management Web Application" from scratch. 

Do NOT use Filament or any rigid pre-made admin dashboards. Build a completely custom, highly fluid UI tailored for thumb-driven mobile usage and tablet screens.

### 🎨 UI Design & Color Palette
- Canvas/Background: Off-White/Putih Tulang (#F8F7F3)
- Primary/Buttons/Headers: Mint/Teal (#96e6c2)
- Urgency/Queue/Alerts: Orange (#EA580C)
- Success/Approved: Green (#ffaa29)
- Layout Requirements: Implement a sleek custom Bottom Navigation Bar for mobile views (Patients/Admins) and a clean side-navigation layout or workspace for tablet/desktop views (Doctors).

### 👥 User Roles & Database Architecture
Implement a clear multi-role authentication system with the following tables, relationships, and business rules:
1. `users`: The main account handler (holds email/phone and password). Used by family heads, parents, or individual independent patients.
2. `patient_profiles`: Belongs to a user (One-to-Many). Contains: full_name, nik, date_of_birth, gender. Crucial Rule: All medical records and appointments must bind strictly to the `patient_profile_id`, NOT the `user_id`, so a single parent account can manage independent medical histories for multiple children or elderly relatives.
3. `doctors`: Contains doctor credentials, specialization/poli (e.g., Pediatrics, Obgyn, Internal Medicine, ENT, Dermatology).
4. `doctor_admin`: A pivot table (Many-to-Many) connecting `users` (with admin role) to `doctors`. An admin can manage 1 specific doctor, or 1 admin can manage all doctors.
5. `appointments` / Queue: Tracks daily clinic visits with a dynamic status state engine: ['Pending', 'Approved', 'Checked-In', 'Calling', 'Processing', 'Completed', 'Cancelled'].

### 🚀 Core Phase 1 Functionalities (Build These Features)

#### 1. Patient Panel (Mobile View Focus)
- Dashboard showing active profile picker (Netflix-style family profile selection).
- A bottom bar for navigation: Home, History, Profile.
- "Book Appointment" flow: Select a family profile -> Select specialized clinic/doctor -> Submit booking for the current day (Hari-H).

#### 2. Flexible Admin Workspace (Mobile & Tablet View)
- View list of Incoming bookings ('Pending').
- Configuration page for each doctor to set dynamic daily quotas and service intervals (e.g., fixed allocation of 15 minutes per patient).
- Logic Action: When an admin clicks "Approve", the system must automatically calculate the patient's sequential Queue Number and the estimated Service Time based on the doctor's set interval (e.g., Patient 1 at 09:00, Patient 2 at 09:15, etc.).

#### 3. Real-Time TV Queue Display Framework
- Create a specific full-screen TV view route (`/tv-display`).
- The screen layout must split: 
  - Center/Left: Large prominent box showing the current active calling queue number and the targeted doctor's examination room.
  - Right sidebar: A vertical table tracking the next 5-10 upcoming approved/checked-in queue numbers.
- Technical Requirement: Implement this view using Livewire's lightweight polling (`wire:poll.3s`) to simulate a real-time display without external websocket architectures.

### 🛠️ Code Quality Rules
- Write clean Laravel migrations with complete foreign keys and data cascading integrity.
- Use native Livewire components with standalone Blade views styled purely with Tailwind CSS.
- Ensure all inputs have proper validation (especially NIK validation, phone numbers, and time slots).
- Pre-seed dummy data for at least 3 doctors (Pediatrics, Obgyn, ENT) and 2 admin users to make testing immediate.

Buat aplikasi kita dengan penulisan kode yang CLEAN dan dry, 
Buat database dan aplikasi kita pakai bahasa inggris , tapi untuk label/tampilan akan digunakan oleh orang indonesia, jadi gunakan bahasa indonesia untuk ui , coba buatkan PRD yang rinci dan lengkap untuk saya gunakan pada ai builder
