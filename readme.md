# AppClinic
----------------------
###เสร็จสมบูนย์แล้ ว !!
- การรักษา
- ซื้อคอร์ส
- ตาราง หมอ / ตาราง นัด
- Report
    - ยอดขาย sales หรือพนักงาน
    - ยอดขายแพทย์
    - ยอดขายพวกคอร์ต่างๆ
    - สรุปคอร์ส ขายดี
    - สินค้าขายดี
    - ยอดขายรายวัน
- forgot password
- เลือกสาขา
- ซือสินค้า POS
- เพิ่มยาในสร้างคอรส
- รับสินค้า
- ใบสั่งซื้อ
- สต้อกสินค้า

###Function เรียงตามความสำคัญ
- ชำระเงิน
- ปลิ้นบิล
- pdf
- export report to excel
- คืนสินค้า
- กำหนดสิทธิ์ user [ ตั้งค่าการมองเห็นเมนู ]
- เมนูตั้งค่า
- Refactor code
- minify Code
- Test Code

###Bug
+ หน้าสั่งสินค้า
    + ปลิ้นบิล
+ เพิ่ม ปุ่ม แก้ไข ข้อมูล หน้าคอร์ส
+ เพิ่ม ปุ่ม ดู ข้อมูล หน้าคอร์ส
+ หน้าเพิ่มคอร์ส ลบ ยา ไม่ได้
+ ข้อมูลสมาชิก เพิ่มปุ่มแก้ไข/ลบ ด้วย
+ เขียนดัก ไม่กรอกราคา ทั้งหมด
    + ขายสินค้า [ กรอก จำนวน 0 / ไม่ได้กรอก ลูกค้า / ไม่กรอกสินค้า สามารถกดบันทึกได้ทั้งหมด ]
    + สั่งซื้อสินค้า [ ไม่ได้กรอก Supplier / กรอกจำนวน 0 / ไม่ได้กรอก ราคา สามารถบันทึกได้ทั้งหมด ]
    + รับสินค้า [ ไม่ได้กรอกอ้างอิง สามารถกดบันทึกได้ ]
+ หน้ารักษา ซ่อน ปี 2558
+ คอร์สขายดี/สินค้าขายดี หน้าหลัก บัค สีซ้ำ
+ ข้อมูลสินค้า แก้ไข/ลบ ไม่ได้ ( ใครทำหน้าคืนในนี้อยู่ เห็นมันปิดคำสั่งไว้ )
+ สั่งซื้อสินค้า เราสั่ง ไป 1 จำนวน หน้ารับสินค้า สามารถรับเกินจำนวนที่สั่งได้
+ รีพอท ยอดขายรายวัน ยังไม่ได้ add calendar ที
+ จำนวนยา หน้า เข้ารับการรักษา ไม่ได้ ตรวจสอบกับ จำนวนในสต๊อกสินค้า
+ ตรงหน้าชำระเงินคอร์ส +5 เปลี่ยน +1 ตามค่าด้วย
+ ตรงการเก็บชื่อพนักงาน ชื่อหมอ เก็บรวมกันยุหรือป่าวเพราะตอนเลือกพนักงานขายทำไมชื่อหมอและชื่อพนักงานทั้งหมดโชว์ด้วย ไม่ได้แยกเป็นหน้าที่หรือป่าว
+ ดูเวลาในเว็บด้วยว่า อิง จาก เซิฟเว่อ ไหน ดึงมาจากนอกแน่เลย เพราะไม่ตรงกับ เซิฟเว่อ ผม
+ ยอดลูกหนี้เจ้าหนี้รายเดือน ลูกหนี้คือลูกค้า เจ้าหนี้ร้านยาขายยาให้เรา
+ การจัดการพนักงาน ให้ซ่อม IT Admin หรือแยกออก

****เสร็จภายในวันนี้ 6/8/58****
****Demo 7/8/58*****

###Freature
+ เช็ค PK ก่อนจะ Submit
    - Course
    - Product

###Bug แก้แล้ว
+ หน้าสั่งสินค้า
    + ~~Loading ไม่ขึ้น~~
     + ~~ลบไม่ได้~~
+ ~~หน้าซื้อคอร์ส หน้ารักษา ส่วนแสดงข้อมูล ลูกค้า [ ข้อมูลส่วนตัวทั้งหมด ]~~
+ ~~วันรักษา Fix~~
+ ~~ประวัติรักษาลูกค้า แสดงยาด้วย~~
+ ~~รีพอททั้งหมดยังไม่ได้ทำจุดแสดงที~~
+ ~~บัค ไอคอน adminlte ซ้ำกับ ตารางที่ใช้ของ zofe~~
+ ~~หน้าซื้อคอร์ส กดเลือกลูกค้า แล้ว ยังไม่ได้ กดบันทึก แล้วออกไป แล้วกลับมา กดเปลี่ยนลูกค้า ไม่ได้ขึ้นเออเร่อ~~
+ ~~Sale ซื้อคอรส์แล้ว ไม่บันทึกข้อมูล รีพอท พนักงาน ไม่ขึ้น~~
+ ~~ตรงหน้าหลักสินค้าที่ถึงจำนวนที่ต้องสั่งซื้อ พอกดดูทำไมไม่เด้งไปหน้าที่บอกจำนวนสินค้าในสต๊อก~~
+ ~~ตรงหน้าหลักสินค้าที่กำลังจะหมดอายุ วันหมดอายุ ไม่ตรงกับหน้าข้อมูลสินค้าหมดอายุ~~
+ ~~ตรงรายงานยอดขาย สินค้าที่ดีที่สุด ตารางสรุปข้อมูลด้านล่าง จำนวนน่าจะผิด~~
+ ~~ตัด vat 7% ออกตรงซื้อคอร์สไม่ต้องใส่~~
+ ~~สต๊อกหน้าร้าน เพิ่มได้ไหมว่ายาสาขานี้มีอยู่เท่าไหร่~~