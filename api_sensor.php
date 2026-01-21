<?php
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
ini_set('default_charset', 'UTF-8');
if (function_exists('mb_internal_encoding')) {
    mb_internal_encoding('UTF-8');
}

$sensors_list = [
    ["id" => "SN-001", "location" => "Kho Đông Lạnh A"],
    ["id" => "SN-002", "location" => "Kho Đông Lạnh B"],
    ["id" => "SN-003", "location" => "Khu Vực Chế Biến"],
    ["id" => "SN-004", "location" => "Xe Container 01"]
];

$response_data = [];

foreach ($sensors_list as $sensor) {
    // Giả lập dữ liệu
    $temp = ($sensor['id'] == "SN-003") ? round(mt_rand(120, 220) / 10, 1) : round(mt_rand(-220, -140) / 10, 1);
    $humi = mt_rand(70, 98);

    // Ngưỡng kiểm tra
    $t_max = ($sensor['id'] == "SN-003") ? 20.0 : -18.0;
    $h_min = 85;

    $is_temp_warn = $temp > $t_max;
    $is_humi_warn = $humi < $h_min;

    // Tạo thông báo trạng thái
    if ($is_temp_warn && $is_humi_warn) {
        $msg = "⚠ Nguy cơ cao: Nhiệt độ cao & Độ ẩm thấp!";
        $status = "Danger";
    } elseif ($is_temp_warn) {
        $msg = "⚠ Cảnh báo: Nhiệt độ vượt ngưỡng!";
        $status = "Warning";
    } elseif ($is_humi_warn) {
        $msg = "⚠ Lưu ý: Độ ẩm thấp (gây khô cá)";
        $status = "Warning";
    } else {
        $msg = "✓ Thiết bị hoạt động ổn định";
        $status = "Normal";
    }

    $response_data[] = [
        "id" => $sensor['id'],
        "location" => $sensor['location'],
        "temp" => ["val" => $temp, "warn" => $is_temp_warn],
        "humi" => ["val" => $humi, "warn" => $is_humi_warn],
        "status" => $status,
        "message" => $msg,
        "time" => date('H:i:s')
    ];
}

echo json_encode($response_data, JSON_UNESCAPED_UNICODE);
?>