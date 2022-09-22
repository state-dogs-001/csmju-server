<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class MaterialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materials = array(
            array('name' => 'กรรไกรตัดกระดาษ', 'quantity' => '36'),
            array('name' => 'คัตเตอร์เหล็ก ขนาดใหญ่', 'quantity' => '20'),
            array('name' => 'คัตเตอร์เหล็ก ขนาดเล็ก', 'quantity' => '16'),
            array('name' => 'แท่นตัดสติ๊กเกอร์', 'quantity' => '9'),
            array('name' => 'ที่เจาะกระดาษ', 'quantity' => '4'),
            array('name' => 'กระดิ่ง', 'quantity' => '5'),
            array('name' => 'ใบมีดคัตเตอร์', 'quantity' => '1'),
            array('name' => 'เทปใส ขนาด 2 นิ้ว', 'quantity' => '32'),
            array('name' => 'เทปสันหนา ขนาด 2 นิ้ว', 'quantity' => '42'),
            array('name' => 'เทปสันหนา ขนาด 1 นิ้ว', 'quantity' => '48'),
            array('name' => 'สก๊อตเทปใส', 'quantity' => '44'),
            array('name' => 'คลิบดำ 2 ขา เบอร์ 108', 'quantity' => '19'),
            array('name' => 'คลิบดำ 2 ขา เบอร์ 109', 'quantity' => '7'),
            array('name' => 'คลิบดำ 2 ขา เบอร์ 112', 'quantity' => '5'),
            array('name' => 'เทปโฟมกาว 2 หน้า (หนา)', 'quantity' => '34'),
            array('name' => 'แผ่น DVD', 'quantity' => '7'),
            array('name' => 'ซองใส่แผ่น DVD', 'quantity' => '3'),
            array('name' => 'เทปกระดาษกาวย่น', 'quantity' => '43'),
            array('name' => 'เทปกาว 2 หน้า (บาง)', 'quantity' => '19'),
            array('name' => 'ปากกาลูกลื่น สีน้ำเงิน', 'quantity' => '200'),
            array('name' => 'ปากกาลูกลื่น สีแดง', 'quantity' => '150'),
            array('name' => 'ปากกาลูกลื่น สีดำ', 'quantity' => '50'),
            array('name' => 'ปากกาเมจิ สีน้ำเงิน', 'quantity' => '120'),
            array('name' => 'ปากกาเมจิ สีแดง', 'quantity' => '120'),
            array('name' => 'ปากกาเขียนไวท์บอร์ด สีน้ำเงิน', 'quantity' => '200'),
            array('name' => 'ปากกาเขียนไวท์บอร์ด สีแดง', 'quantity' => '250'),
            array('name' => 'ปากกาเขียนไวท์บอร์ด สีดำ', 'quantity' => '160'),
            array('name' => 'ปากกาเขียนไวท์บอร์ด สีเขียว', 'quantity' => '150'),
            array('name' => 'ดินสอ', 'quantity' => '192'),
            array('name' => 'ยางลบ', 'quantity' => '20'),
            array('name' => 'ถ่าน AA', 'quantity' => '30'),
            array('name' => 'ถ่าน AAA', 'quantity' => '20'),
            array('name' => 'ถ่านชาร์จได้', 'quantity' => '7'),
            array('name' => 'ปากกาเขียน CD', 'quantity' => '7'),
            array('name' => 'ปากกาเน้นข้อความ', 'quantity' => '40'),
            array('name' => 'ปากกาลบคำผิด', 'quantity' => '23'),
            array('name' => 'โฟสต์-อีท แฟล็กซ์', 'quantity' => '47'),
            array('name' => 'โฟสต์-อีท โน้ต', 'quantity' => '18'),
            array('name' => 'กาวยู่ฮู', 'quantity' => '28'),
            array('name' => 'กาวน้ำแท่ง', 'quantity' => '12'),
            array('name' => 'กาวลาเท็กซ์', 'quantity' => '7'),
            array('name' => 'ลวดเย็บกระดาษ เบอร์ 10', 'quantity' => '240'),
            array('name' => 'ลวดเย็บกระดาษ เบอร์ 8', 'quantity' => '120'),
            array('name' => 'ลวดเย็บกระดาษ เบอร์ 15', 'quantity' => '10'),
            array('name' => 'ลวดเย็บกระดาษ T-3 (แม็กซ์ยิง)', 'quantity' => '10'),
            array('name' => 'แม็กซ์เย็บกระดาษ เบอร์ 10', 'quantity' => '24'),
            array('name' => 'แม็กซ์เย็บกระดาษ เบอร์ 8', 'quantity' => '9'),
            array('name' => 'แม็กซ์ยิง', 'quantity' => '1'),
            array('name' => 'ลวดเสียบกระดาษ เบอร์ 1', 'quantity' => '110'),
            array('name' => 'ลวดเสียบกระดาษ เบอร์ 0', 'quantity' => '30'),
            array('name' => 'ที่ใส่ลวดเสียบ', 'quantity' => '8'),
            array('name' => 'ไม้บรรทัดเหล็ก', 'quantity' => '3'),
            array('name' => 'เข็มหมุดหัวแบน', 'quantity' => '12'),
            array('name' => 'เครื่องเหลาดินสอ', 'quantity' => '6'),
            array('name' => 'หมุดปักสี', 'quantity' => '12'),
            array('name' => 'ปากกาเคมี', 'quantity' => '10'),
            array('name' => 'ปากกาเขียนครุภัณฑ์', 'quantity' => '12'),
            array('name' => 'เชือกขาว', 'quantity' => '18'),
            array('name' => 'ลิ้นแฟ้ม', 'quantity' => '1'),
            array('name' => 'สามเหลี่ยมป้ายวิทยากร', 'quantity' => 0),
            array('name' => 'สติ๊กเกอร์ขาวเงา', 'quantity' => 0),
            array('name' => 'แผ่นใสชนิดเขียน', 'quantity' => 0),
            array('name' => 'แฟ้มสอด A4/F14', 'quantity' => 0),
            array('name' => 'สติ๊กเกอร์ใส', 'quantity' => 0),
            array('name' => 'สก๊อตซ์-ไบรต์', 'quantity' => 0),
            array('name' => 'สติ๊กเกอร์ขาวด้าน', 'quantity' => 0),
            array('name' => 'ซองเจอะรู', 'quantity' => 0),
            array('name' => 'ซองจดหมาย', 'quantity' => 0),
            array('name' => 'คลิบบอร์ด A4/F14', 'quantity' => 0),
            array('name' => 'แฟ้มกล่าวรายงาน', 'quantity' => 0),
            array('name' => 'แฟ้มเสนอเซ็น', 'quantity' => 0),
            array('name' => 'สมุดเล่มสีฟ้า', 'quantity' => 0),
            array('name' => 'กระดาษการ์ด', 'quantity' => 0),
            array('name' => 'กระดาษแผ่นเช็ดมือ', 'quantity' => 0),
            array('name' => 'กระดาษม้วนเล็ก', 'quantity' => 0),
            array('name' => 'กระดาษคาร์บอน', 'quantity' => 0),
            array('name' => 'กระดาษสีแผ่นใหญ่', 'quantity' => 0)
        );

        //? Insert $materials to table
        foreach ($materials as $material) {
            DB::table('materials')->insert($material);
        }
    }
}
