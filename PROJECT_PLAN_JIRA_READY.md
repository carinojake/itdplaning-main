# ITD Planning — Jira-ready Backlog (Contracts / Tasks / Gantt / Dashboard)

เอกสารนี้จัดทำเพื่อแปลง roadmap ให้พร้อมใช้งานใน Jira ทันที โดยแยกเป็น Epic > Story > Sub-task พร้อม Priority, Story Point, Sprint และ Acceptance Criteria.

## Sprint Cadence
- Sprint length: 2 สัปดาห์
- Sprint 1: Stability + Core Data
- Sprint 2: Execution + Visibility

## Priority Definition
- P0 = Critical (ต้องทำก่อนเพื่อความถูกต้องของข้อมูล/การใช้งานหลัก)
- P1 = High (ฟีเจอร์หลักที่ผู้ใช้ใช้ทุกวัน)
- P2 = Medium (ปรับปรุงคุณภาพ/ขยายระบบ)

## Jira-ready Items

| Key | Epic | Story | Sub-task | Priority | SP | Sprint | Owner (Template) | Acceptance Criteria |
|---|---|---|---|---|---:|---|---|---|
| EP-01 | Contracts Foundation | Fix PR/PA budget calculation | Add rule for draft/approved/cancelled states | P0 | 5 | Sprint 1 | BE-1 | ยอดรวม PR/PA ถูกต้องตามสถานะเอกสาร 100% |
| EP-01 | Contracts Foundation | Fix PR/PA budget calculation | Add unit tests for budget scenarios | P0 | 3 | Sprint 1 | QA-1 | ผ่าน test cases สถานะหลักครบถ้วน |
| EP-01 | Contracts Foundation | Contract input validation | Unique contract number validation | P0 | 2 | Sprint 1 | BE-1 | บันทึกซ้ำเลขที่สัญญาไม่ได้ |
| EP-01 | Contracts Foundation | Contract input validation | Start/end date and non-negative budget checks | P0 | 2 | Sprint 1 | BE-1 | วันที่เริ่ม <= วันที่สิ้นสุด และงบ >= 0 |
| EP-01 | Contracts Foundation | Authorization hardening | Restrict contract visibility by permission | P0 | 5 | Sprint 1 | BE-2 | ผู้ใช้เห็นเฉพาะสัญญาที่มีสิทธิ์ |
| EP-02 | Task Execution | Tasks CRUD | Create and edit task | P1 | 5 | Sprint 2 | BE-2 | สร้าง/แก้ไขงานย่อยได้พร้อม due date/priority |
| EP-02 | Task Execution | Tasks CRUD | Assignee and status workflow | P1 | 3 | Sprint 2 | FE-1 | มอบหมายและเปลี่ยนสถานะงานได้ครบ flow |
| EP-02 | Task Execution | Progress tracking | Auto progress by task status/weight | P1 | 5 | Sprint 2 | BE-1 | %progress โครงการอัปเดตอัตโนมัติแบบถูกต้อง |
| EP-03 | Planning Timeline | Gantt Chart v1 | Render project timeline and milestones | P1 | 8 | Sprint 2 | FE-2 | แสดง timeline โครงการและ milestone ได้ |
| EP-03 | Planning Timeline | Gantt Chart v1 | Date dependency and overlap checks | P1 | 3 | Sprint 2 | BE-2 | แจ้งเตือนงานชนกัน/วันที่ไม่สอดคล้อง |
| EP-04 | Dashboard Insights | Dashboard v1 | Budget summary widgets (used/remaining) | P1 | 5 | Sprint 2 | FE-1 | แสดงงบใช้ไป/คงเหลือถูกต้อง |
| EP-04 | Dashboard Insights | Dashboard v1 | Risk panel (overdue tasks / delayed projects) | P1 | 5 | Sprint 2 | FE-2 | แสดงรายการเสี่ยงล่าช้าตามเงื่อนไข |
| EP-05 | Engineering Quality | Targeted refactor | Service/Repository cleanup for contracts/tasks | P2 | 5 | Sprint 2 | BE-1 | โครงสร้างอ่านง่ายขึ้นและไม่กระทบพฤติกรรมเดิม |
| EP-05 | Engineering Quality | Test expansion | Add regression tests for critical flows | P2 | 3 | Sprint 2 | QA-1 | ลดโอกาสเกิด bug ซ้ำใน flow หลัก |

## Suggested Labels (Jira)
- domain:contracts, domain:tasks, domain:gantt, domain:dashboard
- type:bug, type:feature, type:refactor
- risk:data-integrity, risk:auth, risk:schedule

## Definition of Done (DoD)
1. ผ่าน code review อย่างน้อย 1 คน
2. มี test ครอบคลุมกรณีหลักของงาน
3. ไม่มี bug ระดับ critical ใหม่ในฟีเจอร์ที่ส่ง
4. มีหมายเหตุ release note สั้น ๆ สำหรับผู้ใช้งาน

## Execution Order (Recommended)
1. ปิด P0 ทั้งหมดก่อน (โดยเฉพาะ data integrity และ authorization)
2. ส่งมอบ Contracts + Tasks ให้ใช้งานจริง
3. ต่อด้วย Gantt และ Dashboard เพื่อ visibility
4. ทำ refactor แบบเจาะจงเฉพาะส่วนที่เป็นคอขวด
