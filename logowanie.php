<html>
  <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>     
    <style>
      .log-tab{
        margin-top:15vh;
      }
      .padding5050{
        padding-top:50px;
        padding-bottom:50px;
      }
    </style>
  </head>
  <body class="bg-secondary">
    <div class="container-fluid bg-info log-tab">
      <div class="row">
<?php

/***********************************

KONTO DO LOGOWANIA PRACOWNIKA MA DANE

LOGIN: admin
HASŁO: admin

************************************/

if(isset($_COOKIE['p_logowanie'])){ //sprawdza czy ciasteczko "p_logowanie" istnieje, jeśli tak pokazuje stronę logowania dla pracowników
  echo("
    
  <div>
    <h1 class='text-center' style='padding-top:70px'>Logowanie dla pracowników</h1>
  </div>
  <div class='d-flex justify-content-center padding5050' >
    <form action='' method='post'>
        <input style='padding:5px;' type='text' name='login' placeholder='UID'><br/>
        <input style='padding:5px;' type='password' name='pass' placeholder='Hasło'><br/><br/>
      <input class='btn btn-dark d-flex justify-content-center' type='submit' value='Wykonaj' name='p_zaloguj'/>
    </form>
  </div>

  ");
}
else{
  if(isset($_COOKIE['rejestracja'])){ //sprawdza czy ciasteczko "rejestracja" istnieje, jeśli tak pokazuje stronę rejestracji klientów
    echo("
    
          <div>
            <h1 class='text-center' style='padding-top:70px'>Utwórz konto</h1>
          </div>
          <div class='d-flex justify-content-center padding5050' >
            <form action='' method='post'>
                <input style='padding:5px;' type='text' name='imie' placeholder='Imie'><br/>
                <input style='padding:5px;' type='text' name='nazwisko' placeholder='Nazwisko'><br/>
                <input style='padding:5px;' type='number' name='telefon' placeholder='Telefon'><br/>
                <input style='padding:5px;' type='text' name='email' placeholder='Email'><br/>
                <input style='padding:5px;' type='password' name='pass' placeholder='Hasło'><br/><br/>
              <input class='btn btn-dark d-flex justify-content-center' type='submit' value='Wykonaj' name='zarejestruj'/>
            </form>
          </div>

    ");
  }
  else{ //jeśli tych 2 ciasteczek nie ma, pokazuje stronę logowania dla klientów

    echo("
    
    <div>
      <h1 class='text-center' style='padding-top:70px'>Zaloguj się</h1>
    </div>
    <div class='d-flex justify-content-center padding5050' >
      <form action='' method='post'>
          <input style='padding:5px;' type='text' name='email' placeholder='Email'><br/>
          <input style='padding:5px;' type='password' name='pass' placeholder='Hasło'><br/><br/>
        <input class='btn btn-dark d-flex justify-content-center' type='submit' value='Wykonaj' name='zaloguj'/>
      </form>
    </div>

  ");
    
  }
}
?>
        
<?php
$host="localhost";
$db="restauracjapnk";
$dbuser="root";
$dbpass="";

/*
$host= lokacja servera
$db= baze danych
$dbuser= nazwa użytkowniaka bazr danych
$dbpass= hasło użytkownika bazy danych
*/

if(isset($_POST["p_zaloguj"])){ //komendy kiedy wciśnięto przycisk o nazwie "p_zaloguj"

  $login=$_POST["login"];
  $pass=$_POST["pass"];

  //przechowywanie danych z formularza

  if(empty($login)==TRUE || empty($pass)==TRUE){ //sprawdza czy wpisano dane do formularza
    echo "<br/><div class='text-center' style='color:red'>Wpisz UID oraz hasło</div><br/>";
  }
  else{

  $conn= new mysqli($host,$dbuser,$dbpass,$db);
  if (!$conn) {
      die("Connection failed: " . $conn->connect_error);
    }
  else {}

  //łączenie z bazą danych

  $sql="
  SELECT login,pass
  FROM konta
  WHERE
  login='$login' AND
  BINARY pass='$pass'
  ;";
//komenda sql

  $result=$conn->query($sql);
  if ($result->num_rows>0) {

    setcookie("imie",'', time()-86400, "/");
    setcookie("nazwisko",'', time()-86400, "/");
    setcookie("telefon",'', time()-86400, "/");
    setcookie("p_logowanie",'', time()-86400, "/");
    setcookie("rejestracja",'', time()-86400, "/");
    setcookie("pracownik",1, time()+86400, "/");
    $conn->close();
    header('Location: index.php');

  }
  else {
    echo "<br/><div class='text-center' style='color:red'>Nie udało się zalogować</div><br/>";
    $conn->close();
  }
  
  }

}

if(isset($_POST["zaloguj"])){ //komendy kiedy wciśnięto przycisk o nazwie "zaloguj"

  $email=$_POST["email"];
  $pass=$_POST["pass"];

  //przechowywanie danych z formularza

  if(empty($email)==TRUE || empty($pass)==TRUE){
    echo "<br/><div class='text-center' style='color:red'>Wpisz login i hasło</div><br/>";
  }
  else{

  $conn= new mysqli($host,$dbuser,$dbpass,$db);
  if (!$conn) {
      die("Connection failed: " . $conn->connect_error);
    }
  else {}

  $sql="
  SELECT email,pass
  FROM klient
  WHERE
  email='$email' AND
  BINARY pass='$pass'
  ;";
  $result=$conn->query($sql);
  if ($result->num_rows>0) {
    $sql="
        SELECT imie,nazwisko,telefon
        FROM klient
        WHERE
        email='$email' AND
        BINARY pass='$pass'
    ;";
    $result=$conn->query($sql);

    while($row = $result->fetch_assoc()) {
    $imie=$row["imie"];
    $nazwisko=$row["nazwisko"];
    $telefon=$row["telefon"];

    //przechowywanie danych z tabeli bazy danych
    
  }

    setcookie("imie", $imie, time()+86400, "/");
    setcookie("nazwisko", $nazwisko, time()+86400, "/");
    setcookie("telefon", $telefon, time()+86400, "/");
    setcookie("p_logowanie",'', time()-86400, "/");
    setcookie("rejestracja",'', time()-86400, "/");
    setcookie("pracownik",'', time()-86400, "/");

    //ustawianie odpowiednich ciasteczek i usuwanie tych niepotrzebnych

    $conn->close();
    //zamykanie połączenia z bazą danych

    header('Location: index.php');

    //przejście do strony index.php
  }
  else {
    echo "<br/><div class='text-center' style='color:red'>Nie udało się zalogować</div><br/>";
    $conn->close();
  }
  
  }
}

if(isset($_POST["zarejestruj"])){

  $imie=$_POST["imie"];
  $nazwisko=$_POST["nazwisko"];
  $telefon=$_POST["telefon"];
  $email=$_POST["email"];
  $pass=$_POST["pass"];

  if(empty($imie)==TRUE || empty($nazwisko)==TRUE || empty($telefon)==TRUE || empty($email)==TRUE || empty($pass)==TRUE){
    echo "<div class='text-center' style='color:red'>Uzupełnij wsztstkie rubryki</div><br/><br/><br/>";
  }
  else{

  $conn= new mysqli($host,$dbuser,$dbpass,$db);
  if (!$conn) {
      die("Connection failed: " . $conn->connect_error);
    }
  else {}

  $sql="
  INSERT INTO klient(imie,nazwisko,telefon,email,pass)
  VALUES
  ('$imie','$nazwisko',$telefon,'$email','$pass')
  ;";
  $result=$conn->query($sql);
  if ($result==TRUE) {
    echo "<div class='text-center' style='color:green'>Konto zostało utworzone</div><br/><br/>";
  }
  else {
    echo "<div class='text-center' style='color:red'>Nie udało się zalogować</div><br/><br/>";
    $conn->close();
  }
  }
}

if(isset($_POST["rejestracja"])){
  setcookie("rejestracja",1, time()+86400, "/");
  setcookie("p_logowanie",1, time()-86400, "/");
  header("Refresh:0");
}

if(isset($_POST["logowanie"])){
  setcookie("rejestracja",'', time()-86400, "/");
  setcookie("p_logowanie",1, time()-86400, "/");
  header("Refresh:0");
}

if(isset($_POST["pracownik"])){
  setcookie("rejestracja",'', time()-86400, "/");
  setcookie("p_logowanie",1, time()+86400, "/");
  header("Refresh:0");
}
?>

<?php

if(isset($_COOKIE['p_logowanie'])){
  echo(" 
    <div class='text-center' style='padding-bottom:50px'>
      <form action='' method='post'>
          <div>Logowanie dla klientów <input type='submit' name='logowanie' value='Tutaj'></div>
          <br/><a href='index.php'>Wróć do strony głównej</a>
      </form><br/>
    </div>
  ");
}
else{
  if(isset($_COOKIE['rejestracja'])){
  echo(" 
    <div class='text-center' style='padding-bottom:50px'>
      <form action='' method='post'>
          <div>Masz już konto? <input type='submit' name='logowanie' value='Zaloguj się!'></div>
          <div>Logowanie dla pracowników <input type='submit' name='pracownik' value='Tutaj'></div>
          <br/><a href='index.php'>Wróć do strony głównej</a>
      </form><br/>
    </div>
  ");
}
else{
  echo("
        <div class='text-center' style='padding-bottom:50px'>
          <form action='' method='post'>
              <div>Nie masz konta? <input type='submit' name='rejestracja' value='Stwórz je!'></div>
              <div>Logowanie dla pracowników <input type='submit' name='pracownik' value='Tutaj'></div>
              <br/><a href='index.php'>Wróć do strony głównej</a>
          </form><br/>
        </div>
  ");
}
}



?>
        
      </div>
    </div>
  </body>
</html>