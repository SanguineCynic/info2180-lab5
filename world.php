<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$stmt = $conn->query("SELECT * FROM countries");

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$country = filter_input(INPUT_GET, "country", FILTER_SANITIZE_STRING);
$url = $_SERVER['REQUEST_URI'];
$query = parse_url($url, PHP_URL_QUERY);
parse_str($query, $querryArray); //From my understanding, parses multiple-query data from URL into an array? I think?

if (count($querryArray) > 1){
  $cityQuery = $querryArray['lookup'];
}else{
  $cityQuery = '';
}

$countryLookup = $conn->query("SELECT * FROM countries WHERE name LIKE '%$country%'");
$resCountry = $countryLookup->fetchAll(PDO::FETCH_ASSOC);

$cityLookup = $conn->query("SELECT * FROM countries JOIN cities ON countries.code = cities.country_code WHERE countries.name LIKE '%$country%'");
$resCity = $cityLookup->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
if(($cityQuery === '') or ($cityQuery == null)){
  $output = '<table>'.'<tr>'.'<th>Name</th>'.'<th>Continenent</th>'.'<th>Year of Independence</th>'.'<th>Head of State</th>'.'</tr>';

  foreach ($resCountry as $row){
    $output.= '<tr>';
    $output.= "<td>".$row['name'].'</td>';
    $output.='<td>'.$row['continent'].'</td>';
    $output.='<td>'.$row['independence_year'].'</td>';
    $output.='<td>'.$row['head_of_state'].'</td>';
    $output.='</tr>';
  }
  $output.='</table>';
}else{
  $output = '<table>'.'<tr>'.'<th>Name</th>'.'<th>District</th>'.'<th>Population</th>'.'</tr>';
  foreach ($resCity as $row){
    $output.= '<tr>';
    $output.= "<td>".$row['name'].'</td>';
    $output.= "<td>".$row['district'].'</td>';
    $output.= "<td>".$row['population'].'</td>';
    $output.='</tr>';
  }
  $output.= '</table>';
}


echo $output;
?>

<!-- <ul>
<?php foreach ($resCountry as $row): ?>
  <li><?= $row['name'] . ' is ruled by ' . $row['head_of_state']; ?></li>
<?php endforeach; ?>
</ul> -->
