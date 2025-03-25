<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_pokedex"; // Jouw database naam

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

$sql = "
SELECT user_id, COUNT(*) AS score
FROM caught_pokemon
GROUP BY user_id
ORDER BY score DESC
";
$result = $conn->query($sql);

$usernames = [
    1 => 'Gino',
    2 => 'Lala',
    3 => 'Harry'
];

$leaderboard = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $name = isset($usernames[$row['user_id']]) ? $usernames[$row['user_id']] : 'Onbekend';
        $leaderboard[] = [
            'name' => $name,
            'score' => $row['score']
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($leaderboard);
$conn->close();
?>
