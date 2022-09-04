<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = array(
            array('id' => '1', 'room_id' => '2000', 'room_name_th' => 'สาขาคอม', 'room_name_en' => NULL, 'personnel_id' => '58', 'building_id' => '1', 'floor' => '3', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '2', 'room_id' => '2001', 'room_name_th' => 'สำนักงานเลขา', 'room_name_en' => NULL, 'personnel_id' => '58', 'building_id' => '1', 'floor' => '1', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '3', 'room_id' => '2600', 'room_name_th' => 'ทางเดิน', 'room_name_en' => NULL, 'personnel_id' => '5', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '4', 'room_id' => '2601', 'room_name_th' => 'ห้องธุรการ, พี่ปราณี', 'room_name_en' => NULL, 'personnel_id' => '5', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '5', 'room_id' => '26011', 'room_name_th' => 'ห้องผลิตเอกสาร', 'room_name_en' => NULL, 'personnel_id' => '5', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '6', 'room_id' => '260110', 'room_name_th' => 'ห้อง อ.ดร.สมนึก', 'room_name_en' => NULL, 'personnel_id' => '3', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '7', 'room_id' => '260111', 'room_name_th' => 'ห้อง อ.ภานุวัฒน์', 'room_name_en' => NULL, 'personnel_id' => '15', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '8', 'room_id' => '260112', 'room_name_th' => 'ห้อง อ.อรรถวิท', 'room_name_en' => NULL, 'personnel_id' => '14', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '9', 'room_id' => '260113', 'room_name_th' => 'ห้อง อ.ก่องกาญจน์', 'room_name_en' => NULL, 'personnel_id' => '9', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '10', 'room_id' => '260114', 'room_name_th' => 'ห้อง อ.นษิ, อ.ดร.กิติศักดิ์', 'room_name_en' => NULL, 'personnel_id' => '5', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '11', 'room_id' => '260115', 'room_name_th' => 'ห้องประชุมสาขา', 'room_name_en' => NULL, 'personnel_id' => '5', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '12', 'room_id' => '260116', 'room_name_th' => 'ห้องค้นคว้า', 'room_name_en' => NULL, 'personnel_id' => '18', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '13', 'room_id' => '26012', 'room_name_th' => 'ห้อง อ.ชลิตดา', 'room_name_en' => NULL, 'personnel_id' => '10', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '14', 'room_id' => '26013', 'room_name_th' => 'ห้อง อ.อลงกต', 'room_name_en' => NULL, 'personnel_id' => '11', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '15', 'room_id' => '26014', 'room_name_th' => 'ห้อง อ.ดร.กิตติกร', 'room_name_en' => NULL, 'personnel_id' => '13', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '16', 'room_id' => '26015', 'room_name_th' => 'ห้อง อ.ดร.ปวีณ', 'room_name_en' => NULL, 'personnel_id' => '52', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '17', 'room_id' => '26016', 'room_name_th' => 'ห้อง อ.ดำเกิง', 'room_name_en' => NULL, 'personnel_id' => '7', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '18', 'room_id' => '26017', 'room_name_th' => 'ห้อง รศ.จักรภพ', 'room_name_en' => NULL, 'personnel_id' => '4', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '19', 'room_id' => '26018', 'room_name_th' => 'ห้อง อ.ดร.พาสน์', 'room_name_en' => NULL, 'personnel_id' => '12', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '20', 'room_id' => '26019', 'room_name_th' => 'ห้อง ผศ.ดร.สนิท', 'room_name_en' => NULL, 'personnel_id' => '8', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '21', 'room_id' => '2602', 'room_name_th' => 'ห้องปฏิบัติการคอมพิวเตอร์ 1', 'room_name_en' => 'Lab 1', 'personnel_id' => '19', 'building_id' => '1', 'floor' => '6', 'amount_seat' => '30', 'image' => NULL, 'type_room_id' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '22', 'room_id' => '2603', 'room_name_th' => 'ห้องปฏิบัติการคอมพิวเตอร์ 2', 'room_name_en' => 'Lab 2', 'personnel_id' => '19', 'building_id' => '1', 'floor' => '6', 'amount_seat' => '54', 'image' => NULL, 'type_room_id' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '23', 'room_id' => '2604', 'room_name_th' => 'ห้องปฏิบัติการคอมพิวเตอร์ 4', 'room_name_en' => 'Lab 4', 'personnel_id' => '20', 'building_id' => '1', 'floor' => '6', 'amount_seat' => '60', 'image' => NULL, 'type_room_id' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '24', 'room_id' => '2605', 'room_name_th' => 'ห้องปฏิบัติการคอมพิวเตอร์ 5', 'room_name_en' => 'Lab 5', 'personnel_id' => '18', 'building_id' => '1', 'floor' => '6', 'amount_seat' => '30', 'image' => NULL, 'type_room_id' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '25', 'room_id' => '26051', 'room_name_th' => 'ห้อง STUDY ROOM', 'room_name_en' => NULL, 'personnel_id' => '20', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '26', 'room_id' => '26052', 'room_name_th' => 'ห้องเซิร์ฟเวอร์', 'room_name_en' => NULL, 'personnel_id' => '20', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '27', 'room_id' => '2606', 'room_name_th' => 'ห้องเก็บของ', 'room_name_en' => NULL, 'personnel_id' => '5', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '28', 'room_id' => '2607', 'room_name_th' => 'ห้องบรรยายคอมพิวเตอร์ 7', 'room_name_en' => 'Lect 7', 'personnel_id' => '6', 'building_id' => '1', 'floor' => '6', 'amount_seat' => '56', 'image' => NULL, 'type_room_id' => '2', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '29', 'room_id' => '2608', 'room_name_th' => 'ห้องบรรยายคอมพิวเตอร์ 8', 'room_name_en' => 'Lect 8', 'personnel_id' => '6', 'building_id' => '1', 'floor' => '6', 'amount_seat' => '90', 'image' => NULL, 'type_room_id' => '2', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '30', 'room_id' => '2609', 'room_name_th' => 'ห้องปฏิบัติการคอมพิวเตอร์ 3', 'room_name_en' => 'Lab 3', 'personnel_id' => '18', 'building_id' => '1', 'floor' => '6', 'amount_seat' => '58', 'image' => NULL, 'type_room_id' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '31', 'room_id' => '26091', 'room_name_th' => 'ห้องชมรมคอมพิวเตอร์', 'room_name_en' => NULL, 'personnel_id' => '20', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '32', 'room_id' => '26092', 'room_name_th' => 'ห้องพี่ประทีป,พี่ช่อทิพย์', 'room_name_en' => NULL, 'personnel_id' => '6', 'building_id' => '1', 'floor' => '6', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '33', 'room_id' => '2610', 'room_name_th' => 'ห้องบรรยายคอมพิวเตอร์ 6', 'room_name_en' => 'Lect 6', 'personnel_id' => '6', 'building_id' => '1', 'floor' => '6', 'amount_seat' => '90', 'image' => NULL, 'type_room_id' => '2', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '34', 'room_id' => '32031', 'room_name_th' => 'ห้องบรรยาย 3203 จุฬาภรณ์', 'room_name_en' => 'Lect 3203', 'personnel_id' => '19', 'building_id' => '2', 'floor' => '2', 'amount_seat' => '48', 'image' => NULL, 'type_room_id' => '2', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '35', 'room_id' => '32032', 'room_name_th' => 'ห้องปฏิบัติการ 3203 จุฬาภรณ์', 'room_name_en' => 'Lab 3203', 'personnel_id' => '19', 'building_id' => '2', 'floor' => '2', 'amount_seat' => '45', 'image' => NULL, 'type_room_id' => '1', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '36', 'room_id' => '3204', 'room_name_th' => 'อาคารจุฬาภรณ์ห้อง 3204', 'room_name_en' => NULL, 'personnel_id' => '18', 'building_id' => '2', 'floor' => '2', 'amount_seat' => NULL, 'image' => NULL, 'type_room_id' => '3', 'is_del' => '0', 'created_at' => NULL, 'updated_at' => NULL)
        );

        //? Insert $rooms to table
        foreach ($rooms as $room) {
            DB::table('rooms')->insert($room);
        }
    }
}
