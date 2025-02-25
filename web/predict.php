<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $myct = isset($_POST["MYCT"]) ? trim($_POST["MYCT"]) : "";
    $mmin = isset($_POST["MMIN"]) ? trim($_POST["MMIN"]) : "";
    $mmax = isset($_POST["MMAX"]) ? trim($_POST["MMAX"]) : "";
    $cach = isset($_POST["CACH"]) ? trim($_POST["CACH"]) : "";
    $chmin = isset($_POST["CHMIN"]) ? trim($_POST["CHMIN"]) : "";
    $chmax = isset($_POST["CHMAX"]) ? trim($_POST["CHMAX"]) : "";

    if ($myct !== "" && $mmin !== "" && $mmax !== "" && $cach !== "" && $chmin !== "" && $chmax !== "") {
        $command = "java -cp \"C:/Users/User-KK33/OneDrive/Desktop/ProjectDM/libs/weka-3-8-0-monolithic.jar;C:/Users/User-KK33/OneDrive/Desktop/ProjectDM/src\" CPUPerformancePredictor $myct $mmin $mmax $cach $chmin $chmax";
        
        $output = shell_exec($command);
        if ($output) {
            echo "ผลลัพธ์ที่พยากรณ์: " . htmlspecialchars($output);
        } else {
            echo "❌ เกิดข้อผิดพลาดระหว่างการรันโมเดล";
        }
    } else {
        echo "กรุณากรอกค่าทั้งหมดก่อนทำการพยากรณ์!";
    }
} else {
    echo "ไม่รองรับการเรียกใช้งานแบบ GET!";
}
