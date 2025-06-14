
<?php
header("Content-Type: application/json");

$host = 'localhost';
$dbname = 'findmyschool';
$user = 'root';
$pass = '';

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
//echo($keyword);

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

    // name または name_en に一致するデータを取得
    $stmt = $pdo->prepare("
        SELECT name, name_en, department_en 
        FROM school
        WHERE name LIKE ? OR name_en LIKE ?
    ");
    $search = '%' . $keyword . '%';
    $stmt->execute([$search, $search]);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);

} catch (PDOException $e) {
    echo json_encode([]);
    http_response_code(500);
}
