<?php
$array = [];
$data = [];

for ($i=2450; $i<=date('Y')+543; $i++) {

    $array[] = $i;
    $test = array_reverse($array);

}

array_push($data,$array);

/**
 * Created by PhpStorm.
 * User: Syr4h
 * Date: 7/7/2015
 * Time: 6:23 PM
 */
return [
    'sex' => array(
        1 => "โปรดเลือก...",
        'ชาย' => "ชาย",
        'หญิง' => "หญิง"
    ),

    'blood' => array(
        1 => "โปรดเลือก...",
        'A' => "A",
        'B' => "B",
        'AB' => "AB",
        'O' => "O"
    ),

    'province' => array(
        1 => "โปรดเลือกจังหวัด...",
        "กระบี่" => "กระบี่",
        "กรุงเทพมหานคร" => "กรุงเทพมหานคร",
        "กาญจนบุรี" => "กาญจนบุรี",
        "กาฬสินธุ์" => "กาฬสินธุ์",
        "กำแพงเพชร" => "กำแพงเพชร",
        "ขอนแก่น" => "ขอนแก่น",
        "จันทบุรี" => "จันทบุรี",
        "ฉะเชิงเทรา" => "ฉะเชิงเทรา",
        "ชลบุรี" => "ชลบุรี",
        "ชัยนาท" => "ชัยนาท",
        "ชัยภูมิ" => "ชัยภูมิ",
        "ชุมพร" => "ชุมพร",
        "ตรัง" => "ตรัง",
        "ตราด" => "ตราด",
        "ตาก" => "ตาก",
        "นครนายก" => "นครนายก",
        "นครปฐม" => "นครปฐม",
        "นครพนม" => "นครพนม",
        "นครราชสีมา" => "นครราชสีมา",
        "นครศรีธรรมราช" => "นครศรีธรรมราช",
        "นครสวรรค์" => "นครสวรรค์",
        "นนทบุรี" => "นนทบุรี",
        "นราธิวาส" => "นราธิวาส",
        "น่าน" => "น่าน",
        "บึงกาฬ" => "บึงกาฬ",
        "บุรีรัมย์" => "บุรีรัมย์",
        "ปทุมธานี" => "ปทุมธานี",
        "ประจวบคีรีขันธ์" => "ประจวบคีรีขันธ์",
        "ปราจีนบุรี" => "ปราจีนบุรี",
        "ปัตตานี" => "ปัตตานี",
        "พระนครศรีอยุธยา" => "พระนครศรีอยุธยา",
        "พะเยา" => "พะเยา",
        "พังงา" => "พังงา",
        "พัทลุง" => "พัทลุง",
        "พิจิตร" => "พิจิตร",
        "พิษณุโลก" => "พิษณุโลก",
        "ภูเก็ต" => "ภูเก็ต",
        "มหาสารคาม" => "มหาสารคาม",
        "มุกดาหาร" => "มุกดาหาร",
        "ยะลา" => "ยะลา",
        "ยโสธร" => "ยโสธร",
        "ระนอง" => "ระนอง",
        "ระยอง" => "ระยอง",
        "ราชบุรี" => "ราชบุรี",
        "ร้อยเอ็ด" => "ร้อยเอ็ด",
        "ลพบุรี" => "ลพบุรี",
        "ลำปาง" => "ลำปาง",
        "ลำพูน" => "ลำพูน",
        "ศรีสะเกษ" => "ศรีสะเกษ",
        "สกลนคร" => "สกลนคร",
        "สงขลา" => "สงขลา",
        "สตูล" => "สตูล",
        "สมุทรปราการ" => "สมุทรปราการ",
        "สมุทรสงคราม" => "สมุทรสงคราม",
        "สมุทรสาคร" => "สมุทรสาคร",
        "สระบุรี" => "สระบุรี",
        "สระแก้ว" => "สระแก้ว",
        "สิงห์บุรี" => "สิงห์บุรี",
        "สุพรรณบุรี" => "สุพรรณบุรี",
        "สุราษฎร์ธานี" => "สุราษฎร์ธานี",
        "สุรินทร์" => "สุรินทร์",
        "สุโขทัย" => "สุโขทัย",
        "หนองคาย" => "หนองคาย",
        "หนองบัวลำภู" => "หนองบัวลำภู",
        "อำนาจเจริญ" => "อำนาจเจริญ",
        "อุดรธานี" => "อุดรธานี",
        "อุตรดิตถ์" => "อุตรดิตถ์",
        "อุทัยธานี" => "อุทัยธานี",
        "อุบลราชธานี" => "อุบลราชธานี",
        "อ่างทอง" => "อ่างทอง",
        "เชียงราย" => "เชียงราย",
        "เชียงใหม่" => "เชียงใหม่",
        "เพชรบุรี" => "เพชรบุรี",
        "เพชรบูรณ์" => "เพชรบูรณ์",
        "เลย" => "เลย",
        "แพร่" => "แพร่",
        "แม่ฮ่องสอน" => "แม่ฮ่องสอน",

    ),

    'day' => array(

        "1" => "1",
        "2" => "2",
        "3" => "3",
        "4" => "4",
        "5" => "5",
        "6" => "6",
        "7" => "7",
        "8" => "8",
        "9" => "9",
        "10" => "10",
        "11" => "11",
        "12" => "12",
        "13" => "13",
        "14" => "14",
        "15" => "15",
        "16" => "16",
        "17" => "17",
        "18" => "18",
        "19" => "19",
        "20" => "20",
        "21" => "21",
        "22" => "22",
        "23" => "23",
        "24" => "24",
        "25" => "25",
        "26" => "26",
        "27" => "27",
        "28" => "28",
        "29" => "29",
        "30" => "30",
        "31" => "31",
    ),

    'month' => array(

        "มกราคม" => "มกราคม",
        "กุมภาพันธ์" => "กุมภาพันธ์",
        "มีนาคม" => "มีนาคม",
        "เมษายน" => "เมษายน",
        "พฤษภาคม" => "พฤษภาคม",
        "มิถุนายน" => "มิถุนายน",
        "กรกฏาคม" => "กรกฏาคม",
        "สิงหาคม" => "สิงหาคม",
        "กันยายน" => "กันยายน",
        "ตุลาคม" => "ตุลาคม",
        "พฤศจิกายน" => "พฤศจิกายน",
        "ธันวาคม" => "ธันวาคม",
    ),


    'year' => $test,


];

