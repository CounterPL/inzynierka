<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <!--<title> Responsiive Admin Dashboard | CodingLab </title>-->
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
          <a href="homepage.php">
            <i class='bx bx-list-ul' ></i>
            <span class="links_name">Lista Urządzeń</span>
          </a>
        </li>
        <li>
          <a href="homepage.php">
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
        <i class='clarity:devices-line'></i>    <!-- bx bx-cart-alt cart-->
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
        </div>
      </div>
    </div> 
    <div class="sales-boxes">
  <div class="recent-sales box">
  <div class="title">Lista Użytkowników</div>
    <?php
      
  $servername = "localhost";
$username = "root";
$password = "";
$dbname = "logowanie";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT nazwisko, email, imie FROM user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
      echo '  <div class="sales-details">';
      echo '    <ul class="details">';
      echo '      <li class="topic">Imię</li>';
      echo "      <li><a>" . $row["imie"] ." </a></li>";
      echo '    </ul>';
      echo '   <ul class="details">';
      echo '    <li class="topic">Nazwisko</li>';
      echo "      <li><a>" . $row["nazwisko"] ." </a></li>";
      echo '  </ul>';
      echo '  <ul class="details">';
      echo '    <li class="topic">Adres Email</li>';
      echo "      <li><a>" . $row["email"] ." </a></li>";
      echo '  </ul>';
      echo '  </div>';
  }
  
} else {
  echo "0 results";
}
$conn->close();
?>

    </div>




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