<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$stmt = $conn->query("SELECT * FROM countries");

if (isset($_GET['country']) && !empty ($_GET['country']))
{
  $country = $_GET['country'];

  // Prepare and execute a parameterized query
  $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
  $stmt->execute([':country' => "%$country%"]);
}
else
{
  // Default query to show all countries if no 'country' parameter is provided
  $stmt = $conn->query("SELECT * FROM countries");
}
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- HTML Table to display country details -->
<!-- <table border="1">
    <thead>
        <tr>
            <th>Country Name</th>
            <th>Continent</th>
            <th>Independence Year</th>
            <th>Head of State</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['continent']) ?></td>
            <td><?= htmlspecialchars($row['independence_year']) ?></td>
            <td><?= htmlspecialchars($row['head_of_state']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>World Database Lookup</title>
    <link href="world.css" type="text/css" rel="stylesheet" />
</head>
<body>

    <header>
        <h1>World Database Lookup</h1>
    </header>

    <main>
        <div id="result">
            <?php if (!empty($results)): ?>
                <!-- Display country data in a table -->
                <table border="1">
                    <thead>
                        <tr>
                            <th>Country Name</th>
                            <th>Continent</th>
                            <th>Independence Year</th>
                            <th>Head of State</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['continent']) ?></td>
                                <td><?= htmlspecialchars($row['independence_year']) ?></td>
                                <td><?= htmlspecialchars($row['head_of_state']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <!-- Display country data as a list -->
                <ul>
                    <?php foreach ($results as $row): ?>
                        <li><?= htmlspecialchars($row['name']) . ' is ruled by ' . htmlspecialchars($row['head_of_state']); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>