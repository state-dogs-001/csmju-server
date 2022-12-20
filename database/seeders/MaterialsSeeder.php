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
            array('id' => '1', 'name' => 'กรรไกรตัดกระดาษ', 'quantity' => '36', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '2', 'name' => 'คัตเตอร์เหล็ก ขนาดใหญ่', 'quantity' => '20', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '3', 'name' => 'คัตเตอร์เหล็ก ขนาดเล็ก', 'quantity' => '16', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '4', 'name' => 'แท่นตัดสติ๊กเกอร์', 'quantity' => '9', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '5', 'name' => 'ที่เจาะกระดาษ', 'quantity' => '4', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '6', 'name' => 'กระดิ่ง', 'quantity' => '5', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '7', 'name' => 'ใบมีดคัตเตอร์', 'quantity' => '1', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '8', 'name' => 'เทปใส ขนาด 2 นิ้ว', 'quantity' => '32', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '9', 'name' => 'เทปสันหนา ขนาด 2 นิ้ว', 'quantity' => '42', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '10', 'name' => 'เทปสันหนา ขนาด 1 นิ้ว', 'quantity' => '48', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '11', 'name' => 'สก๊อตเทปใส', 'quantity' => '44', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '12', 'name' => 'คลิบดำ 2 ขา เบอร์ 108', 'quantity' => '19', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '13', 'name' => 'คลิบดำ 2 ขา เบอร์ 109', 'quantity' => '7', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '14', 'name' => 'คลิบดำ 2 ขา เบอร์ 112', 'quantity' => '5', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '15', 'name' => 'เทปโฟมกาว 2 หน้า (หนา)', 'quantity' => '34', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '16', 'name' => 'แผ่น DVD', 'quantity' => '7', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '17', 'name' => 'ซองใส่แผ่น DVD', 'quantity' => '3', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '18', 'name' => 'เทปกระดาษกาวย่น', 'quantity' => '43', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '19', 'name' => 'เทปกาว 2 หน้า (บาง)', 'quantity' => '19', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '20', 'name' => 'ปากกาลูกลื่น สีน้ำเงิน', 'quantity' => '200', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '21', 'name' => 'ปากกาลูกลื่น สีแดง', 'quantity' => '150', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '22', 'name' => 'ปากกาลูกลื่น สีดำ', 'quantity' => '50', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '23', 'name' => 'ปากกาเมจิ สีน้ำเงิน', 'quantity' => '120', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '24', 'name' => 'ปากกาเมจิ สีแดง', 'quantity' => '120', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '25', 'name' => 'ปากกาเขียนไวท์บอร์ด สีน้ำเงิน', 'quantity' => '200', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '26', 'name' => 'ปากกาเขียนไวท์บอร์ด สีแดง', 'quantity' => '250', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '27', 'name' => 'ปากกาเขียนไวท์บอร์ด สีดำ', 'quantity' => '160', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '28', 'name' => 'ปากกาเขียนไวท์บอร์ด สีเขียว', 'quantity' => '150', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '29', 'name' => 'ดินสอ', 'quantity' => '192', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '30', 'name' => 'ยางลบ', 'quantity' => '20', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '31', 'name' => 'ถ่าน AA', 'quantity' => '30', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '32', 'name' => 'ถ่าน AAA', 'quantity' => '20', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '33', 'name' => 'ถ่านชาร์จได้', 'quantity' => '7', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '34', 'name' => 'ปากกาเขียน CD', 'quantity' => '7', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '35', 'name' => 'ปากกาเน้นข้อความ', 'quantity' => '40', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '36', 'name' => 'ปากกาลบคำผิด', 'quantity' => '23', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '37', 'name' => 'โฟสต์-อีท แฟล็กซ์', 'quantity' => '47', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '38', 'name' => 'โฟสต์-อีท โน้ต', 'quantity' => '18', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '39', 'name' => 'กาวยู่ฮู', 'quantity' => '28', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '40', 'name' => 'กาวน้ำแท่ง', 'quantity' => '12', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '41', 'name' => 'กาวลาเท็กซ์', 'quantity' => '7', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '42', 'name' => 'ลวดเย็บกระดาษ เบอร์ 10', 'quantity' => '240', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '43', 'name' => 'ลวดเย็บกระดาษ เบอร์ 8', 'quantity' => '120', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '44', 'name' => 'ลวดเย็บกระดาษ เบอร์ 15', 'quantity' => '10', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '45', 'name' => 'ลวดเย็บกระดาษ T-3 (แม็กซ์ยิง)', 'quantity' => '10', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '46', 'name' => 'แม็กซ์เย็บกระดาษ เบอร์ 10', 'quantity' => '24', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '47', 'name' => 'แม็กซ์เย็บกระดาษ เบอร์ 8', 'quantity' => '9', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '48', 'name' => 'แม็กซ์ยิง', 'quantity' => '1', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '49', 'name' => 'ลวดเสียบกระดาษ เบอร์ 1', 'quantity' => '110', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '50', 'name' => 'ลวดเสียบกระดาษ เบอร์ 0', 'quantity' => '30', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '51', 'name' => 'ที่ใส่ลวดเสียบ', 'quantity' => '8', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '52', 'name' => 'ไม้บรรทัดเหล็ก', 'quantity' => '3', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '53', 'name' => 'เข็มหมุดหัวแบน', 'quantity' => '12', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '54', 'name' => 'เครื่องเหลาดินสอ', 'quantity' => '6', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '55', 'name' => 'หมุดปักสี', 'quantity' => '12', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '56', 'name' => 'ปากกาเคมี', 'quantity' => '10', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '57', 'name' => 'ปากกาเขียนครุภัณฑ์', 'quantity' => '12', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '58', 'name' => 'เชือกขาว', 'quantity' => '18', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '59', 'name' => 'ลิ้นแฟ้ม', 'quantity' => '1', 'image' => NULL, 'status' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '60', 'name' => 'สามเหลี่ยมป้ายวิทยากร', 'quantity' => '0', 'image' => NULL, 'status' => '0', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => '2022-11-16 00:41:25'),
            array('id' => '61', 'name' => 'สติ๊กเกอร์ขาวเงา', 'quantity' => '0', 'image' => NULL, 'status' => '0', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '62', 'name' => 'แผ่นใสชนิดเขียน', 'quantity' => '0', 'image' => NULL, 'status' => '0', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '63', 'name' => 'แฟ้มสอด A4/F14', 'quantity' => '0', 'image' => NULL, 'status' => '0', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '64', 'name' => 'สติ๊กเกอร์ใส', 'quantity' => '0', 'image' => NULL, 'status' => '0', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '65', 'name' => 'สก๊อตซ์-ไบรต์', 'quantity' => '0', 'image' => NULL, 'status' => '0', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '66', 'name' => 'สติ๊กเกอร์ขาวด้าน', 'quantity' => '0', 'image' => NULL, 'status' => '0', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '67', 'name' => 'ซองเจอะรู', 'quantity' => '0', 'image' => NULL, 'status' => '0', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '68', 'name' => 'ซองจดหมาย', 'quantity' => '0', 'image' => NULL, 'status' => '0', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '69', 'name' => 'คลิบบอร์ด A4/F14', 'quantity' => '0', 'image' => NULL, 'status' => '0', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => '2022-11-16 00:44:46'),
            array('id' => '70', 'name' => 'แฟ้มกล่าวรายงาน', 'quantity' => '0', 'image' => NULL, 'status' => '0', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => '2022-11-16 00:44:39'),
            array('id' => '71', 'name' => 'แฟ้มเสนอเซ็น', 'quantity' => '0', 'image' => NULL, 'status' => '0', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => '2022-11-16 00:44:33'),
            array('id' => '72', 'name' => 'สมุดเล่มสีฟ้า', 'quantity' => '0', 'image' => NULL, 'status' => '0', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => '2022-11-16 00:44:26'),
            array('id' => '73', 'name' => 'กระดาษการ์ด', 'quantity' => '0', 'image' => NULL, 'status' => '0', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => '2022-11-16 00:44:19'),
            array('id' => '74', 'name' => 'กระดาษแผ่นเช็ดมือ', 'quantity' => '0', 'image' => NULL, 'status' => '0', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => '2022-11-16 00:44:14'),
            array('id' => '75', 'name' => 'กระดาษม้วนเล็ก', 'quantity' => '0', 'image' => NULL, 'status' => '0', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => '2022-11-16 00:44:07'),
            array('id' => '76', 'name' => 'กระดาษคาร์บอน', 'quantity' => '0', 'image' => NULL, 'status' => '0', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => '2022-11-16 00:44:03'),
            array('id' => '77', 'name' => 'กระดาษสีแผ่นใหญ่', 'quantity' => '0', 'image' => NULL, 'status' => '0', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => '2022-11-16 00:43:58')
        );

        //? Insert $materials to table
        foreach ($materials as $material) {
            DB::table('materials')->insert($material);
        }
    }
}
