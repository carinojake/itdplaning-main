# 📋 Planning System — ระบบวางแผนงาน IT

ระบบบริหารจัดการแผนงานและโครงการด้านเทคโนโลยีสารสนเทศ (IT) พัฒนาด้วย Laravel Framework

---

## ✨ ฟีเจอร์หลัก

- **จัดการโครงการ (Projects)** — เพิ่ม แก้ไข ลบ และติดตามสถานะโครงการ
- **จัดการสัญญา (Contracts)** — บันทึกสัญญา งบประมาณ PR/PA และติดตามความคืบหน้า
- **จัดการกิจกรรม (Tasks)** — แบ่งงานย่อยในแต่ละโครงการ
- **Gantt Chart** — แสดงแผนงานในรูปแบบ Gantt Chart
- **Dashboard** — ภาพรวมสรุปโครงการและงบประมาณ
- **ระบบงบประมาณ** — แยกประเภท งบดำเนินงาน / งบลงทุน / งบ IT
- **ระบบสิทธิ์ผู้ใช้ (Role-Based Access)** — กำหนดสิทธิ์ผู้ใช้แต่ละระดับ
- **รองรับหลายภาษา (Multi-language)**

---

## 🛠️ เทคโนโลยีที่ใช้

| ส่วน | เทคโนโลยี |
|------|------------|
| Backend | PHP / Laravel |
| Frontend | Bootstrap / CoreUI |
| Database | MySQL |
| Auth | Laravel Breeze |
| DataTable | Yajra DataTables |
| Gantt | DHTMLX Gantt |
| ID Encoding | Hashids |

---

## ⚙️ วิธีติดตั้ง

### ความต้องการของระบบ
- PHP >= 8.0
- Composer
- MySQL
- Node.js & NPM

### ขั้นตอนติดตั้ง

```bash
# 1. Clone โปรเจกต์
git clone https://github.com/carinojake/itdplaning-main2.git
cd itdplaning-main2

# 2. ติดตั้ง PHP dependencies
composer install

# 3. ติดตั้ง Node dependencies
npm install && npm run build

# 4. ตั้งค่า Environment
cp .env.example .env
php artisan key:generate

# 5. ตั้งค่าฐานข้อมูลใน .env
DB_DATABASE=planning
DB_USERNAME=root
DB_PASSWORD=your_password

# 6. รัน Migration
php artisan migrate --seed

# 7. เริ่มต้น Server
php artisan serve
```

---

## 🗄️ โครงสร้างฐานข้อมูลหลัก

- `projects` — ข้อมูลโครงการ (ชื่อ, วันเริ่ม-สิ้นสุด, งบประมาณ, ปีงบประมาณ)
- `contracts` — ข้อมูลสัญญา (หมายเลขสัญญา, งบ PR/PA, สถานะ)
- `tasks` — กิจกรรมในโครงการ
- `users` — ผู้ใช้งานระบบ

---

## 📁 โครงสร้างโฟลเดอร์สำคัญ

```
app/
├── Http/Controllers/
│   ├── ProjectController.php    # จัดการโครงการ
│   ├── ContractController.php   # จัดการสัญญา
│   ├── DashboardController.php  # Dashboard
│   └── Core/                   # ระบบ Users, Roles, Menus
├── Models/
│   ├── Project.php
│   ├── Contract.php
│   └── Task.php
└── Libraries/
    └── Helper.php               # Helper functions
```

---


## 🚀 แผนเริ่มทำงานทันที

แนวทางการพัฒนาควรเริ่มจากการทำให้ระบบหลักเสถียรก่อน แล้วค่อยเพิ่มฟีเจอร์ที่ต่อยอดจากข้อมูลจริง โดยเรียงลำดับดังนี้:

1. **แก้ Bug สำคัญ (Stabilize)** — แก้ปัญหาที่กระทบข้อมูล งบประมาณ ความคืบหน้า และการใช้งานหลัก
2. **เพิ่ม Core Features** — พัฒนา Contracts และ Tasks ให้ครบ workflow ก่อน
3. **เพิ่ม Visualization** — ทำ Gantt Chart และ Dashboard หลังจากข้อมูลหลักนิ่งแล้ว
4. **ปรับปรุงโค้ด (Refactor)** — ปรับเฉพาะจุดที่ทำให้ดูแลยากหรือเพิ่มฟีเจอร์ต่อยาก

### Priority Backlog

| Priority | งาน | เป้าหมาย |
|----------|-----|----------|
| P0 | ตรวจสอบและแก้ Bug งบประมาณ PR/PA | ป้องกันข้อมูลผิดพลาดในสัญญาและโครงการ |
| P0 | ตรวจสอบการคำนวณ Progress | ให้สถานะโครงการและกิจกรรมแสดงผลถูกต้อง |
| P0 | ตรวจสอบสิทธิ์การเข้าถึง | ป้องกันผู้ใช้เห็นหรือแก้ไขข้อมูลที่ไม่ควรเข้าถึง |
| P1 | ปรับปรุง Contracts Workflow | เพิ่ม/แก้ไข/ติดตามสัญญา งบประมาณ และสถานะได้ครบถ้วน |
| P1 | ปรับปรุง Tasks Workflow | แบ่งงานย่อย ผูกกับโครงการ และติดตามสถานะได้ชัดเจน |
| P1 | เชื่อม Tasks กับ Progress โครงการ | ให้ความคืบหน้าโครงการสะท้อนจากงานจริง |
| P2 | เพิ่ม/ปรับปรุง Gantt Chart | แสดง timeline ของโครงการและกิจกรรมได้เข้าใจง่าย |
| P2 | เพิ่ม/ปรับปรุง Dashboard | สรุปจำนวนโครงการ งบประมาณ สัญญา และความคืบหน้า |
| P2 | เพิ่ม Test Coverage จุดสำคัญ | ลดความเสี่ยงเมื่อแก้ไขหรือเพิ่มฟีเจอร์ใหม่ |

### Sprint แนะนำ 2 สัปดาห์แรก

**Week 1 — Stabilize**
- ตรวจ bug ใน Projects, Contracts, Tasks
- ตรวจความถูกต้องของ PR/PA และงบประมาณ
- ตรวจการคำนวณ progress และ task status
- ตรวจ role/permission ที่เกี่ยวข้องกับข้อมูลโครงการและสัญญา

**Week 2 — Core Workflow**
- ทำให้ Contracts ใช้งานครบ flow หลัก
- ทำให้ Tasks ผูกกับ Projects/Contracts ได้ชัดเจน
- ปรับหน้า list/detail/form ให้ใช้งานต่อเนื่องกัน
- เพิ่ม validation และข้อความแจ้งเตือนที่จำเป็น

### Definition of Done

งานหนึ่งรายการถือว่าเสร็จเมื่อ:

- ผู้ใช้สามารถทำ workflow นั้นได้ตั้งแต่ต้นจนจบ
- ข้อมูลถูกบันทึกและแสดงผลถูกต้อง
- มี validation สำหรับข้อมูลสำคัญ
- ไม่มี error ในหน้าหลักที่เกี่ยวข้อง
- ทดสอบ scenario สำคัญแล้วอย่างน้อย 1 รอบ

---

## 👤 ผู้พัฒนา

- **Jake Carino** — [@carinojake](https://github.com/carinojake)

---

## 📄 License

โปรเจกต์นี้เผยแพร่ภายใต้ [MIT License](https://opensource.org/licenses/MIT)
