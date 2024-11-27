<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';


// Create a PDO connection
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
// Initialize $results to an empty array
$results = [];

if (isset($_GET['country']) && !empty($_GET['country'])) {
    $country = $_GET['country'];

    // If the 'lookup' parameter is set to 'cities', fetch city information
    if (isset($_GET['lookup']) && $_GET['lookup'] === 'cities') {
        // Prepare and execute the query to get cities in the specified country
        $stmt = $conn->prepare("SELECT c.name AS city_name, c.district, c.population
                        FROM cities c
                        JOIN countries co ON c.country_code = co.code
                        WHERE co.name LIKE :country");
        $stmt->execute([':country' => "%$country%"]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Output the city data as an HTML table
        if (!empty($results)) {
            echo "<table border='1'>
                    <thead>
                        <tr>
                            <th>City Name</th>
                            <th>District</th>
                            <th>Population</th>
                        </tr>
                    </thead>
                    <tbody>";
            foreach ($results as $row) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['city_name']) . "</td>
                        <td>" . htmlspecialchars($row['district']) . "</td>
                        <td>" . htmlspecialchars($row['population']) . "</td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No cities found for this country.</p>";
        }
    } else {
        // Default query to show country data if 'lookup' is not 'cities'
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->execute([':country' => "%$country%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Output the country data as an HTML table
        if (!empty($results)) {
            echo "<table border='1'>
                    <thead>
                        <tr>
                            <th>Country Name</th>
                            <th>Continent</th>
                            <th>Independence Year</th>
                            <th>Head of State</th>
                        </tr>
                    </thead>
                    <tbody>";
            foreach ($results as $row) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['continent']) . "</td>
                        <td>" . htmlspecialchars($row['independence_year']) . "</td>
                        <td>" . htmlspecialchars($row['head_of_state']) . "</td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No countries found.</p>";
        }
    }
} else {
    echo "<p>Please provide a country name.</p>";
}
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