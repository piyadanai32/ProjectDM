<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $fields = ["MYCT", "MMIN", "MMAX", "CACH", "CHMIN", "CHMAX"];
    $data = [];

    foreach ($fields as $field) {
        if (!isset($_POST[$field]) || trim($_POST[$field]) === "") {
            echo "❌ กรุณากรอกค่าทั้งหมดก่อนทำการพยากรณ์!";
            exit;
        }
        if (!is_numeric($_POST[$field])) {
            echo "⚠️ ค่าที่ป้อนไม่ถูกต้อง! กรุณากรอกเฉพาะตัวเลข";
            exit;
        }
        $data[$field] = trim($_POST[$field]);
    }

    // คำสั่งรันโมเดล Java
    $command = escapeshellcmd("java -cp \"C:/Users/User-KK33/OneDrive/Desktop/ProjectDM/libs/weka-3-8-0-monolithic.jar;C:/Users/User-KK33/OneDrive/Desktop/ProjectDM/src\" CPUPerformancePredictor {$data['MYCT']} {$data['MMIN']} {$data['MMAX']} {$data['CACH']} {$data['CHMIN']} {$data['CHMAX']}");

    $output = shell_exec($command);
    $performance = intval($output); // แปลงค่าผลลัพธ์เป็นตัวเลข

    // ตรวจสอบระดับของประสิทธิภาพ
    if ($performance > 500) {
        $level = "🔥 ดีมาก";
    } elseif ($performance >= 300) {
        $level = "✅ ดี";
    } elseif ($performance >= 200) {
        $level = "⚖️ ปานกลาง";
    } else {
        $level = "🔴 น้อย";
    }

    if ($output) {
        echo "$performance ($level)";
    } else {
        echo "❌ เกิดข้อผิดพลาดระหว่างการรันโมเดล";
    }
} else {
    echo "⛔ ไม่รองรับการเรียกใช้งานแบบ GET!";
}
