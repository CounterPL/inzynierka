
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="sidebar">
    <div class="logo-details">
       <i class='bx bxl-S-plus-plus'></i> 
      <span class="logo_name">Apka</span>
    </div>
      <ul class="nav-links">
        <li>
          <a href="homepage.php" class="active">
            <i class='bx bx-grid-alt' ></i> 
            <span class="links_name">Panel</span>
          </a>
        </li>
        <li>
          <a href="lista_urzadzen.html">
            <i class='bx bx-list-ul' ></i>
            <span class="links_name">Lista Urządzeń</span>
          </a>
        </li>
        <li>
          <a href="historia_zdarzen.html">
            <i class='bx bx-pie-chart-alt-2' ></i>
            <span class="links_name">Historia Zdarzeń</span>
          </a>
        </li>
        <li>
          <a href="lista_uzytkownikow.php">
            <i class='bx bx-user' ></i>
            <span class="links_name">Lista Użytkowników</span>
          </a>
        </li>
        <li>
          <a href="wykresy.html">
            <i class='bx bx-message' ></i>
            <span class="links_name">Wykresy</span>
          </a>
        </li>
        <li style='text-align: center;' class="bx bx-log-out">
          <form action="index.php" method="post">
            <input type="hidden" name="action" value="logout">
            <button type="sumbit" class="btn btn-primary w-100"><span class="links_name">Wyloguj</span></button>
        </form>
          <!--<a href="#">
            <i class='bx bx-log-out'></i>
            <span class="links_name">Wyloguj</span>
          </a> -->
        </li>
      </ul>
  </div>
  <section class="home-section">
    <nav>
      </div>
      <div class="profile-details">
        <img src="images/admin.jpg" alt="">
        <span class="admin_name">ADMIN</span>
        <i class='bx bx-chevron-down' ></i>
      </div>
    </nav>
    <div class="home-content">
      <div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Urządzenia Aktywne</div>
            <div class="number">1</div>
            <div class="indicator">
            </div>
          </div>
          <i class='clarity:devices-line'></i>    
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Liczba Urządzeń</div>
            <div class="number">1</div>
            <div class="indicator">
            </div>
          </div>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Aktualna Godzina</div>
            <div class="number">
      <?php
                 $czas=date("H:i");
           echo "$czas";
      ?>
      </div>
            <div class="indicator">
            </div>
          </div>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Aktualna Data</div>
            <div class="number">
        <?php
                $data=date("Y-m-d");
                echo "$data";
        ?></div>
            <div class="indicator">
            </div>
          </div>
        </div>
      </div> 
      <div class="sales-boxes">
        <div class="recent-sales box">
          <div class="title">Lista Obsługiwane Urządzenie</div>
          <div class="sales-details">
            <ul class="details">
              <li class="topic">Data</li>
              <li><a href="#">
              <?php
                $data=date("Y-m-d");
                echo "$data";
              ?>
              </a>
            </li>
            </ul>
           <ul class="details">
            <li class="topic">Godzina</li>
             <li><a href="#">
             <?php
                 $czas=date("H:i");
                  echo "$czas";
                  ?>
             </a>
            </li>
          </ul>
          <ul class="details">
            <li class="topic">Temperatura</li>
             <li>
             <?php

/**
 * Measurements generator
 * Version: 1.0.1
 * 
 * @TODO:
 * - Manual temperature customize (target temperature)
 */

// Database configuration
const MYSQL_HOST = 'localhost';
const MYSQL_PORT = '3306';
const MYSQL_DBNAME = 'logowanie';
const MYSQL_USER = 'root';
const MYSQL_PASSWORD = '';
const MYSQL_CHARSET = 'utf8mb4';

// Temperature status
const TEMP_NOT_MOVING = 'TEMP_NOT_MOVING';
const TEMP_GOING_UP = 'TEMP_GOING_UP';
const TEMP_GOING_DOWN = 'TEMP_GOING_DOWN';
const TEMP_GOING_UP_CRITICAL = 'TEMP_GOING_UP_CRITICAL';
const TEMP_GOING_DOWN_CRITICAL = 'TEMP_GOING_DOWN_CRITICAL';

// Temperatures
const MIN_TEMP = 35;
const MAX_TEMP = 60;
const MIN_TEMP_CRITICAL = 0;
const MAX_TEMP_CRITICAL = 100;

//echo MYSQL_USER . " " . MYSQL_PASSWORD;
//die();
// PDO init
$dsn = "mysql:host=".MYSQL_HOST.";dbname=".MYSQL_DBNAME.";charset=".MYSQL_CHARSET;

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, MYSQL_USER, MYSQL_PASSWORD, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Get last measurement
$stmt = $pdo->query('SELECT * FROM temperatures ORDER BY timestamp DESC LIMIT 1');
$lastMeasurement = $stmt->fetch();

// Get last 5 measurements
$stmt = $pdo->query('SELECT * FROM temperatures ORDER BY timestamp DESC LIMIT 5');
$lastMeasurements = $stmt->fetchAll();

// Get new values
$newStatus = getStatus($lastMeasurement['status'], $lastMeasurement['temperature'], $lastMeasurements);
$newTemperature = getTemperature($newStatus, $lastMeasurement['temperature'], $lastMeasurement['status']);

// Insert new measurement into db 
$stmt = $pdo->prepare('INSERT INTO temperatures (temperature, status) VALUES (?, ?)');
$stmt->execute([$newTemperature, $newStatus]);
          echo "<a>$newTemperature</a>";
          echo "  </li>";
          echo "</ul>";
          echo "<ul class='details'>";
          echo "  <li class='topic'>AKTUALNY STAN</li>";
          echo "  <li>";
          echo "    <a>";
          //echo "      <img src="images/prawidlowy.png" alt="">";
          echo "      <span class='product'>$newStatus</span>";
          echo "    </li> " ;
          echo "</ul>";

function getTemperature($status, $lastTemperature, $lastStatus) {
    $temperatureDifference = rand(1, 2);
    $bigTemperatureDifference = rand(2, 5);
    $temperature = 0;

    switch ($status) {
        case TEMP_GOING_UP:
            $temperature = $lastTemperature += $temperatureDifference;
            break;
        case TEMP_GOING_DOWN:
            $temperature = $lastTemperature -= $temperatureDifference;
            break;
        case TEMP_GOING_UP_CRITICAL:
            $temperature = $lastTemperature += $bigTemperatureDifference;
            break;
        case TEMP_GOING_DOWN_CRITICAL:
            $temperature = $lastTemperature -= $bigTemperatureDifference;
            break;
        case TEMP_NOT_MOVING:
            $temperature = $lastTemperature;
            break;
    }

    if ($temperature > MAX_TEMP && $status != TEMP_GOING_UP_CRITICAL && $lastStatus != TEMP_GOING_UP_CRITICAL) {
        return MAX_TEMP;
    } elseif ($temperature < MIN_TEMP && $status != TEMP_GOING_DOWN_CRITICAL && $lastStatus != TEMP_GOING_DOWN_CRITICAL) {
        return MIN_TEMP;
    }

    if ($temperature > MAX_TEMP_CRITICAL) {
        return MAX_TEMP_CRITICAL;
    } elseif ($temperature < MIN_TEMP_CRITICAL) {
        return MIN_TEMP_CRITICAL;
    }

    return $temperature;
}

function getStatus($lastStatus, $lastTemperature, $lastMeasurements): string {
    $isTempGoingCritical = rand(0, 1);

    $statuses = [
        TEMP_NOT_MOVING,
        TEMP_GOING_UP,
        TEMP_GOING_DOWN,
        TEMP_GOING_UP_CRITICAL,
        TEMP_GOING_DOWN_CRITICAL
    ];
    $statusesIndex = 0;

    if ($isTempGoingCritical && ($lastStatus == TEMP_NOT_MOVING || $lastStatus == TEMP_GOING_UP || $lastStatus == TEMP_GOING_DOWN)) {
        $statusesIndex = rand(0, 4);
    } else {
        $statusesIndex = rand(0, 2);
    }

    if ($lastStatus == TEMP_GOING_UP_CRITICAL) {
        $statusesIndex = 3;
    } elseif ($lastStatus == TEMP_GOING_DOWN_CRITICAL) {
        $statusesIndex = 4;
    }

    if (lastMeasurementsAreCritical($lastMeasurements) && $lastStatus == TEMP_GOING_UP_CRITICAL) {
        $statusesIndex = 2;
    } elseif (lastMeasurementsAreCritical($lastMeasurements) && $lastStatus == TEMP_GOING_DOWN_CRITICAL) {
        $statusesIndex = 1;
    }

    return $statuses[$statusesIndex];
}

function lastMeasurementsAreCritical($lastMeasurements) {
    $upCounter = 0;
    $downCounter = 0;

    foreach($lastMeasurements as $measurement) {
        if ($measurement['status'] == TEMP_GOING_UP_CRITICAL && $measurement['temperature'] == MAX_TEMP_CRITICAL)
            $upCounter += 1;

        if ($measurement['status'] == TEMP_GOING_DOWN_CRITICAL && $measurement['temperature'] == MIN_TEMP_CRITICAL)
            $downCounter += 1;
    }

    return $upCounter >= 5 || $downCounter >= 5;
}
?> 
              
          </div>
          <div class="button">
            <a href="#">Więcej...</a>
          </div> 
        </div>
        <div class="top-sales box">
          <div class="title">Ostatnie 24H</div>
          <ul class="top-sales-details">
            <li>
            <a href="#">
              <img src="images/prawidlowy.png" alt="">
              <span class="product">PRAWIDŁOWY</span>
            </a>
            <span class="price">Więcej...</span>
          </li>
          <li>
            <a href="#">
               <img src="images/alarm.png" alt="">
              <span class="product">ALARM </span>
            </a>
            <span class="price">Więcej...</span>
          </li>
          <li>
            <a href="#">
            <img src="images/alarm.png" alt="Alarm">
              <span class="product">ALARM</span>
            </a>
            <span class="price">Więcej...</span>
          </li>
          <li>
            <a href="#">
              <img src="images/prawidlowy.png" alt="">
              <span class="product">PRAWIDŁOWY</span>
            </a>
            <span class="price">Więcej...</span>
          </li>
          </li>
          <li>
            <a href="#">
             <img src="images/ostrzezenie.png" alt="">
              <span class="product">OSTRZEŻENIE</span>
            </a>
            <span class="price">Więcej...</span>
          </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <script>
   let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function() {
  sidebar.classList.toggle("active");
  if(sidebar.classList.contains("active")){
  sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
}else
  sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
}
 </script>
</body>
</html>

