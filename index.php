<html>
    <head>


<?php
$host="localhost";
$db="restauracjapnk";
$dbuser="root";
$dbpass="";
$conn= new mysqli($host,$dbuser,$dbpass,$db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
/*********************************************************

Skrypy powyżej odpowiada za połączenie z bazą danych

$host= lokacja servera
$db= baze danych
$dbuser= nazwa użytkowniaka bazr danych
$dbpass= hasło użytkownika bazy danych

*********************************************************/

if(isset($_POST["wyloguj"])){
  setcookie("imie",'', time()-86400, "/");
  setcookie("nazwisko",'', time()-86400, "/");
  setcookie("telefon",'', time()-86400, "/");
  setcookie("pracownik",'', time()-86400, "/");

  header("Refresh:0");
}
/*********************************************************

Skrypy powyżej odpowiada za wylogowanie:

  usuwa ciasteczka i odświerza stronę

*********************************************************/
if(isset($_POST["reload"])){
  header("Refresh:0");
}
/*********************************************************

Skrypy powyżej odpowiada za odświeżanie strony kiedy użyto przycisku o nazwie "reload"

*********************************************************/
?>


        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <style>
            table{
                width:30vw;
                border:solid;
                background-color:white;
                float:left;
                margin:10px;
            }
            .zamowienia{
                width:30vw;
                border:solid;
                background-color:white;
                margin:10px;
                width:100%;
            }
            th{
                font-size:150%;
                text-align:center;
                padding:5px;
            }
            .zamowienia th{
                font-size:100%;
                text-align:center;
                padding:5px;
                border-bottom:solid;
            }
            td{
                padding:5px;
                text-align:center;
            }
            .zamowienia td{
                padding:5px;
                text-align:center;
                border-bottom:solid 1px;
            }
            header h1{
                padding:40px;
                font-size:50px;
            }
            header a{
                background-color:white;
                text-decoration:none;
            }
            header a:hover{
                background-color:gray;
            }
            footer {
                position: fixed;
                bottom:0;
            }
            .imdania{
              padding:10px;
            }
        </style>
    </head>
    <body style="background-color:lightblue">
    <header class="container-fluid bg-primary">
        <div class="row" style="height:200px;">
            <div class="col-9">
                <h1 style="color:white;">Restauracja Pod Niebieskim Kurem</h1>
            </div>
            <div class="col-3">
                <img height="150px" width="150px" style="margin-top:20px;" src="img/logo.png" alt="logo">
            </div>
        </div>
    </header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-5">


<?php

if(isset($_COOKIE['pracownik'])){ //sprawdza czy ciasteczko pracownik istnieje, jeśli tak wyświetla dane na stronie dla pracownika

  $sql="
  select id,id_dania,status
  from zamowienia;
  ";

  //$sql przechowywuje komende sql 

  $result =$conn->query($sql); //$result przechowuje odpowiedź od bazy danych na zapytanie ze zmiennej $sql
  if ($result->num_rows > 0) { //sprawdza czy wynik ma jakiekolwiek linijki
    echo("
    <table class='zamowienia'>
      <tr>
        <th style='padding-right:0px;'>ID zamówienia</th>
        <th>Danie</th>
        <th>Status</th>
      </tr>
    ");
    while($row = $result->fetch_assoc()) { //zmienna $row przchowywuje tablice stworzoną ze zmiennej $result i dla każdej linijki wykonywane są komendy w nawiasasie klamrowym
      $id=$row["id_dania"];
      $sql1="
        select nazwa
        from dania
        where
        ID=$id;
        ";
      $result1 =$conn->query($sql1);
      if($result1==TRUE){
        $result2 = $result1->fetch_assoc();
        $danie=$result2['nazwa'];
      }
      else{
        $danie=$id;
      }
      //skrypt powyżej daje zmiennej $danie nazwe dania za pomocą drugiego select w bazie danych
      //dało się to zrobić używając w komendy sql INNER JOIN ale gdy to zauważyłem nie chciało mi się zmieniać
    echo("
      <tr>
        <td class='text-center'>".$row["id"]."</td>
        <td class='text-center'>".$danie."</td>
        <td class='text-center'>".$row["status"]."</td>
      </tr>
    "); 
  }
  echo("</table>");
}
 else {
  echo "Brak zamówień"
  ;}

  $sql="
  select nazwa,cena,id
  from dania
  where typ=1;
  ";
  $result =$conn->query($sql);
  if ($result->num_rows > 0) {
    echo("
    <table>
      <tr>
        <th style='padding-right:20px;'>Dania główne</th>
        <th>Cena</th>
        <th>ID</th>
      </tr>
    ");
  while($row = $result->fetch_assoc()) {
    echo("
      <tr>
        <td>".$row["nazwa"]."</td>
        <td class='text-center'>".$row["cena"]." zł</td>
        <td class='text-center'>".$row["id"]."</td>
      </tr>
    "); 
  }
  echo("</table>");
}
 else {
  echo "0 results";}

  $sql="
  select nazwa,cena,id
  from dania
  where typ=2;
  ";
  $result =$conn->query($sql);
  if ($result->num_rows > 0) {
    echo("
    <table>
      <tr>
        <th style='padding-right:20px;'>Zupy</th>
        <th>Cena</th>
        <th>ID</th>
      </tr>
    ");
  while($row = $result->fetch_assoc()) {
    echo("
      <tr>
        <td>".$row["nazwa"]."</td>
        <td class='text-center'>".$row["cena"]." zł</td>
        <td class='text-center'>".$row["id"]."</td>
      </tr>
    "); 
  }
  echo("</table>");
}
 else {
  echo "0 results";}

  $sql="
  select nazwa,cena,id
  from dania
  where typ=3;
  ";
  $result =$conn->query($sql);
  if ($result->num_rows > 0) {
    echo("
    <table>
      <tr>
        <th style='padding-right:20px;'>Dodatki</th>
        <th>Cena</th>
        <th>ID</th>
      </tr>
    ");
  while($row = $result->fetch_assoc()) {
    echo("
      <tr>
        <td>".$row["nazwa"]."</td>
        <td class='text-center'>".$row["cena"]." zł</td>
        <td class='text-center'>".$row["id"]."</td>
      </tr>
    "); 
  }
  echo("</table>");
}
 else {
  echo "0 results";}

  $sql="
  select nazwa,cena,id
  from dania
  where typ=4;
  ";
  $result =$conn->query($sql);
  if ($result->num_rows > 0) {
    echo("
    <table>
      <tr>
        <th style='padding-right:20px;'>Desery</th>
        <th>Cena</th>
        <th>ID</th>
      </tr>
    ");
  while($row = $result->fetch_assoc()) {
    echo("
      <tr>
        <td>".$row["nazwa"]."</td>
        <td class='text-center'>".$row["cena"]." zł</td>
        <td class='text-center'>".$row["id"]."</td>
      </tr>
    "); 
  }
  echo("</table>");
}
 else {
  echo "0 results";}


  $sql="
  select nazwa,cena,id
  from dania
  where typ=5;
  ";
  $result =$conn->query($sql);
  if ($result->num_rows > 0) {
    echo("
    <table>
      <tr>
        <th style='padding-right:20px;'>Napoje</th>
        <th>Cena</th>
        <th>ID</th>
      </tr>
    ");
  while($row = $result->fetch_assoc()) {
    echo("
      <tr>
        <td>".$row["nazwa"]."</td>
        <td class='text-center'>".$row["cena"]." zł</td>
        <td class='text-center'>".$row["id"]."</td>
      </tr>
    "); 
  }
  echo("</table>");
}
 else {
  echo "0 results";}
  
  /*********************************************************

  skrypy powyżej odpowiadają za wyświetlanie tabel z potrawami

  *********************************************************/

}
else{
if(isset($_COOKIE['imie'])&& isset($_COOKIE['nazwisko'])){ //sprawdza czy ciasteczka klienta istnieją, jeśli tak wyświetla dane na stronie dla klienta

  $sql="
  select nazwa,cena,id
  from dania
  where typ=1;
  ";
  $result =$conn->query($sql);
  if ($result->num_rows > 0) {
    echo("
    <table>
      <tr>
        <th style='padding-right:20px;'>Dania główne</th>
        <th>Cena</th>
        <th>ID</th>
      </tr>
    ");
  while($row = $result->fetch_assoc()) {
    echo("
      <tr>
        <td>".$row["nazwa"]."</td>
        <td class='text-center'>".$row["cena"]." zł</td>
        <td class='text-center'>".$row["id"]."</td>
      </tr>
    "); 
  }
  echo("</table>");
}
 else {
  echo "0 results";}


  $sql="
  select nazwa,cena,id
  from dania
  where typ=2;
  ";
  $result =$conn->query($sql);
  if ($result->num_rows > 0) {
    echo("
    <table>
      <tr>
        <th style='padding-right:20px;'>Zupy</th>
        <th>Cena</th>
        <th>ID</th>
      </tr>
    ");
  while($row = $result->fetch_assoc()) {
    echo("
      <tr>
        <td>".$row["nazwa"]."</td>
        <td class='text-center'>".$row["cena"]." zł</td>
        <td class='text-center'>".$row["id"]."</td>
      </tr>
    "); 
  }
  echo("</table>");
}
 else {
  echo "0 results";}


  $sql="
  select nazwa,cena,id
  from dania
  where typ=3;
  ";
  $result =$conn->query($sql);
  if ($result->num_rows > 0) {
    echo("
    <table>
      <tr>
        <th style='padding-right:20px;'>Dodatki</th>
        <th>Cena</th>
        <th>ID</th>
      </tr>
    ");
  while($row = $result->fetch_assoc()) {
    echo("
      <tr>
        <td>".$row["nazwa"]."</td>
        <td class='text-center'>".$row["cena"]." zł</td>
        <td class='text-center'>".$row["id"]."</td>
      </tr>
    "); 
  }
  echo("</table>");
}
 else {
  echo "0 results";}


  $sql="
  select nazwa,cena,id
  from dania
  where typ=4;
  ";
  $result =$conn->query($sql);
  if ($result->num_rows > 0) {
    echo("
    <table>
      <tr>
        <th style='padding-right:20px;'>Desery</th>
        <th>Cena</th>
        <th>ID</th>
      </tr>
    ");
  while($row = $result->fetch_assoc()) {
    echo("
      <tr>
        <td>".$row["nazwa"]."</td>
        <td class='text-center'>".$row["cena"]." zł</td>
        <td class='text-center'>".$row["id"]."</td>
      </tr>
    "); 
  }
  echo("</table>");
}
 else {
  echo "0 results";}


  $sql="
  select nazwa,cena,id
  from dania
  where typ=5;
  ";
  $result =$conn->query($sql);
  if ($result->num_rows > 0) {
    echo("
    <table>
      <tr>
        <th style='padding-right:20px;'>Napoje</th>
        <th>Cena</th>
        <th>ID</th>
      </tr>
    ");
  while($row = $result->fetch_assoc()) {
    echo("
      <tr>
        <td>".$row["nazwa"]."</td>
        <td class='text-center'>".$row["cena"]." zł</td>
        <td class='text-center'>".$row["id"]."</td>
      </tr>
    "); 
  }
  echo("</table>");
}
 else {
  echo "0 results";}
}
else{

  $sql="
  select nazwa,cena
  from dania
  where typ=1;
  ";
  $result =$conn->query($sql);
  if ($result->num_rows > 0) {
    echo("
    <table>
      <tr>
        <th style='padding-right:20px;'>Dania główne</th>
        <th>Cena</th>
      </tr>
    ");
  while($row = $result->fetch_assoc()) {
    echo("
      <tr>
        <td>".$row["nazwa"]."</td>
        <td class='text-center'>".$row["cena"]." zł</td>
      </tr>
    "); 
  }
  echo("</table>");
}
 else {
  echo "0 results";}


  $sql="
  select nazwa,cena
  from dania
  where typ=2;
  ";
  $result =$conn->query($sql);
  if ($result->num_rows > 0) {
    echo("
    <table>
      <tr>
        <th style='padding-right:20px;'>Zupy</th>
        <th>Cena</th>
      </tr>
    ");
  while($row = $result->fetch_assoc()) {
    echo("
      <tr>
        <td>".$row["nazwa"]."</td>
        <td class='text-center'>".$row["cena"]." zł</td>
      </tr>
    "); 
  }
  echo("</table>");
}
 else {
  echo "0 results";}


  $sql="
  select nazwa,cena
  from dania
  where typ=3;
  ";
  $result =$conn->query($sql);
  if ($result->num_rows > 0) {
    echo("
    <table>
      <tr>
        <th style='padding-right:20px;'>Dodatki</th>
        <th>Cena</th>
      </tr>
    ");
  while($row = $result->fetch_assoc()) {
    echo("
      <tr>
        <td>".$row["nazwa"]."</td>
        <td class='text-center'>".$row["cena"]." zł</td>
      </tr>
    "); 
  }
  echo("</table>");
}
 else {
  echo "0 results";}


  $sql="
  select nazwa,cena
  from dania
  where typ=4;
  ";
  $result =$conn->query($sql);
  if ($result->num_rows > 0) {
    echo("
    <table>
      <tr>
        <th style='padding-right:20px;'>Desery</th>
        <th>Cena</th>
      </tr>
    ");
  while($row = $result->fetch_assoc()) {
    echo("
      <tr>
        <td>".$row["nazwa"]."</td>
        <td class='text-center'>".$row["cena"]." zł</td>
      </tr>
    "); 
  }
  echo("</table>");
}
 else {
  echo "0 results";}


  $sql="
  select nazwa,cena
  from dania
  where typ=5;
  ";
  $result =$conn->query($sql);
  if ($result->num_rows > 0) {
    echo("
    <table>
      <tr>
        <th style='padding-right:20px;'>Napoje</th>
        <th>Cena</th>
      </tr>
    ");
  while($row = $result->fetch_assoc()) {
    echo("
      <tr>
        <td>".$row["nazwa"]."</td>
        <td class='text-center'>".$row["cena"]." zł</td>
      </tr>
    "); 
  }
  echo("</table>");
}
 else {
  echo "0 results";}

}
}
/*********************************************************

skrypy powyżej odpowiadają za wyświetlanie tabel z potrawami

*********************************************************/


?>
            </div>
            <div class='col-5'>
<?php

if(isset($_COOKIE['pracownik'])){ //sprawdza czy ciasteczko pracownik istnieje, jesli tak to pokazuje na stronie rzeczy przeznaczone dla pracownika
  echo("
  <br/>
  <h1 style='color:green;'>Witaj w panelu administracyjnym</h1>
  <br/>
  <form action='' method='post'>
    <h3>Edytuj status zamówień</h3>
    <label>Podaj ID zamówienia</label><br/>
      <input type='number' name='id'><br/>
    <label>Podaj status zamówienia</label><br/>
      <input type='number' name='status'><br/>
      <input style='margin-top:30px;' class='btn btn-dark d-flex justify-content-center' type='submit' value='Edytuj' name='edycja'/>
  </form>

  ");

if(isset($_POST["edycja"])){ //komendy kiedy wciśnięto przycisk o nazwie "edycja"

  $id=$_POST["id"]; 
  $status=$_POST["status"];

  //przechowywanie danych z formularza

  if(empty($id)==TRUE || empty($status)==TRUE){ //sprawdza czy podano w formularzu dane
    echo "<div class='text-center' style='color:red'>Uzupełnij wsztstkie rubryki</div>";
  }
  else{

    $sql="
    UPDATE zamowienia
    SET status=$status
    WHERE id=$id;
    ";

    $result =$conn->query($sql);
    if ($result==TRUE){ //sprawdza czy są wyniki komendy sql
      echo "
      <br/><form action='' method='post'>
      <div class='text-center' style='color:green'>Edycja udana,
      <input type='submit'name='reload' value='odśwież'>
      by zobaczyć zmiany</div>
      </form>
      ";
    }
    else{
      echo "<div class='text-center' style='color:red'>Edycja nieudana</div>";
    }
  }
}

echo("

<br/><div style='color:purple'>STATUS ZAMÓWIENIA:</div>
<div style='color:purple'>1 - zamówienie czeka na zatwierdzenie</div>
<div style='color:purple'>2 - zamówienie w trakcie realizowania</div>
<div style='color:purple'>3 - zamówienie jest gotowe</div>
<div style='color:purple'>4 - zamówienie odebrane przez klienta</div><br/>

<form action='' method='post'>
  <h3>Usuń zamówienie</h3>
  <label>Podaj ID zamówienia</label><br/>
    <input type='number' name='id'>
    <input style='margin-top:30px;' class='btn btn-dark d-flex justify-content-center' type='submit' value='Usuń' name='p_usun'/>
</form>

");

if(isset($_POST["p_usun"])){ //komendy kiedy wciśnięto przycisk o nazwie "p_usun"

  $id=$_POST["id"];

  //przechowywanie danych z formularza

  if(empty($id)==TRUE){
    echo "<div class='text-center' style='color:red'>Wpisz id zamówienia</div>";
  }
  else{

    $sql="
    DELETE FROM zamowienia
    WHERE id=$id;
    ";

    $result =$conn->query($sql);
    if ($result==TRUE){
      $int=$conn->affected_rows;
      if($int>0){
      echo "
        <br/><form action='' method='post'>
        <div class='text-center' style='color:green'>Usunięto zamówienie,
        <input type='submit'name='reload' value='odśwież'>
        by zobaczyć zmiany</div>
        </form>
      ";
      }
      else{
      echo "
      <div class='text-center' style='color:red'>Nie ma zamówienia o takim ID</div>
      ";
      }
    }
    else{
      echo "<div class='text-center' style='color:red'>Nie udało się usunąć zamówienia</div>";
    }
  }
}

echo("

  <form action='' method='post'>
    <h3>Dodawanie dań do menu</h3>
    <label>Nazwa</label><br/>
      <input type='text' name='nazwa'><br/>
    <label>Cena</label><br/>
      <input type='number' name='cena'><br/>
    <label>Typ</label><br/>
      <input type='number' name='typ'><br/>
      <input style='margin-top:30px;' class='btn btn-dark d-flex justify-content-center' type='submit' value='Dodaj' name='dodawanie_d'/>
  </form>

");

if(isset($_POST['dodawanie_d'])){ //komendy kiedy wciśnięto przycisk o nazwie "dodawanie_d"
  $nazwa=$_POST['nazwa'];
  $cena=$_POST['cena'];
  $typ=$_POST['typ'];

  //przechowywanie danych z formularza

  if(empty($nazwa)==TRUE || empty($cena)==TRUE || empty($typ)==TRUE){
    echo "<div class='text-center' style='color:red'>Uzupełnij wszystkie rubryki</div>";
  }
  else{
    $sql="
    INSERT INTO dania(nazwa,cena,typ)
    VALUES
    ('$nazwa',$cena,$typ);
    ";
    $result =$conn->query($sql);
    if ($result==TRUE){
      echo("
      
      <br/><form action='' method='post'>
        <div class='text-center' style='color:green'>Dodano danie,
        <input type='submit'name='reload' value='odśwież'>
        by zobaczyć zmiany</div>
      </form>

      ");
    }
    else{
      echo "<div class='text-center' style='color:red'>Nie udało się dodać dania</div>";
    }
  }
}

echo("

<br/><div style='color:purple'>TYP DANIA:</div>
<div style='color:purple'>1 - Danie główne</div>
<div style='color:purple'>2 - Zupa</div>
<div style='color:purple'>3 - Dodatek</div>
<div style='color:purple'>4 - Deser</div>
<div style='color:purple'>4 - Napój</div><br/>

");



echo("

<form action='' method='post'>
  <h3>Usuń danie</h3>
  <label>Podaj ID dania</label><br/>
    <input type='number' name='id'>
    <input style='margin-top:30px;' class='btn btn-dark d-flex justify-content-center' type='submit' value='Usuń' name='p_usun_danie'/>
</form>

");

if(isset($_POST["p_usun_danie"])){ //komendy kiedy wciśnięto przycisk o nazwie "p_usun_danie"

  $id=$_POST["id"];

  //przechowywanie danych z formularza

  if(empty($id)==TRUE){
    echo "<div class='text-center' style='color:red'>Wpisz ID dania</div>";
  }
  else{

    $sql="
    DELETE FROM dania
    WHERE id=$id;
    ";

    $result =$conn->query($sql);
    if ($result==TRUE){
      $int=$conn->affected_rows;
      if($int>0){
      echo "
        <br/><form action='' method='post'>
        <div class='text-center' style='color:green'>Usunięto danie,
        <input type='submit'name='reload' value='odśwież'>
        by zobaczyć zmiany</div>
        </form>
      ";
      }
      else{
      echo "
      <div class='text-center' style='color:red'>Nie ma dania o takim ID</div>
      ";
      }
    }
    else{
      echo "<div class='text-center' style='color:red'>Nie udało się usunąć dania</div>";
    }
  }
}

}

else{

if(isset($_COOKIE['imie'])&& isset($_COOKIE['nazwisko'])){ //sprawdza czy siasteczka dla klienta istnieją, jeśli tak wyświetla wersję strony dla klienta
  $imie=$_COOKIE['imie'];
  $nazwisko=$_COOKIE['nazwisko'];

  //zmiennym przypisuje się wartości ciasteczek

  echo("
  <br/>
  <h1 style='color:green;'>Witaj $imie $nazwisko</h1>
  <br/>
  <form action='' method='post'>
    <h3>Składanie zamówień</h3>
    <label>Podaj ID dania</label>
      <input type='number' name='id'>
      <input style='margin-top:30px;' class='btn btn-dark d-flex justify-content-center' type='submit' value='Złóż zamówienie' name='zamowienie'/>
  </form>
");


echo("
  <h3>Twoje zamówienia</h3>
  ");

  $imie=$_COOKIE['imie'];
  $nazwisko=$_COOKIE['nazwisko'];

  $sql="
  select id,id_dania,status
  from zamowienia
  where
  klient='$imie $nazwisko';
  ";
  $result =$conn->query($sql);
  if ($result->num_rows > 0) {
    echo("
    <table class='zamowienia'>
      <tr>
        <th style='padding-right:0px;'>ID zamówienia</th>
        <th>Danie</th>
        <th>Status</th>
      </tr>
    ");
  while($row = $result->fetch_assoc()) {
    $status=$row["status"];
    $sql1="
      select opis
      from status
      where
      ID=$status;
      ";
    $result11 =$conn->query($sql1);
    if($result11==TRUE){
      $result22 = $result11->fetch_assoc();
      $opis=$result22['opis'];
    }
    else{
      $opis=$status;
    }

    $id=$row["id_dania"];
    $sql1="
      select nazwa
      from dania
      where
      ID=$id;
      ";
    $result1 =$conn->query($sql1);
    if($result1==TRUE){
      $result2 = $result1->fetch_assoc();
      $danie=$result2['nazwa'];
    }
    else{
      $danie=$id;
    }
    echo("
      <tr>
        <td class='text-center'>".$row["id"]."</td>
        <td class='text-center'>".$danie."</td>
        <td class='text-center'>".$opis."</td>
      </tr>
    "); 
  }
  echo("</table>");
}
 else {
  echo "Brak posiadanych zamówień";
}

/*********************************************************

Skrypy powyżej odpowiadają za wyświetlanie zamówień danego klienta

*********************************************************/

  echo("
  <br/>
  <form action='' method='post'>
    <h3>Usuń zamówienie</h3>
    <label>Podaj ID zamówienia</label>
      <input type='number' name='id'>
      <div>Pamiętaj, że <span style='color:red'>nie można</span> usunąć zamówienia które zostało już zatwierdzone</div>
      <input style='margin-top:30px;' class='btn btn-dark d-flex justify-content-center' type='submit' value='Usuń' name='usun'/>
  </form>
  
  ");

  if(isset($_POST["usun"])){ //komendy kiedy wciśnięto przycisk o nazwie "usun"

    $id=$_POST["id"];
    $imie=$_COOKIE['imie'];
    $nazwisko=$_COOKIE['nazwisko'];

    //przechowywanie danych z formularza i ciasteczek
  
    if(empty($id)==TRUE){
      echo "<div class='text-center' style='color:red'>Wpisz id zamówienia</div>";
    }
    else{
  
      $sql="
      DELETE FROM zamowienia
      WHERE id=$id AND klient='$imie $nazwisko' AND status=1;
      ";
      
      $result =$conn->query($sql);
      if ($result==TRUE){
        $int=$conn->affected_rows;
        if($int>0){
          echo "
            <br/><form action='' method='post'>
            <div class='text-center' style='color:green'>Usunięto zamówienie,
            <input type='submit'name='reload' value='odśwież'>
            by zobaczyć zmiany</div>
            </form>
          ";
          }
          else{
          echo "
          <div class='text-center' style='color:red'>Nie masz zamówienia o takim ID albo nie możesz juz go usunąć</div>
          ";
          }
      }
      else{
        echo "<div class='text-center' style='color:red'>Nie udało się usunąć zamówienia</div>";
      }
    }
  }

}
 
else{
echo(" 
          <div class='row'>
            <div class='col-lg-6 col-12'>
              <img class='img-fluid imdania' src='img/j1.jpg' alt='danie'>
            </div>
            <div class='col-lg-6 col-12'>
              <img class='img-fluid imdania' src='img/j2.jpg' alt='danie'>
            </div>
          </div>
          <div class='row'>
            <div class='col-lg-6 col-12'>
              <img class='img-fluid imdania' src='img/j3.jpg' alt='danie'>
            </div>
            <div class='col-lg-6 col-12'>
              <img class='img-fluid imdania' src='img/j4.jpg' alt='danie'>
            </div>
          </div>
");
}

}

if(isset($_POST["zamowienie"])){ //komendy kiedy wciśnięto przycisk o nazwie "zamowienie"
  $klient=$_COOKIE['imie'].' '.$_COOKIE['nazwisko'];
  $id=$_POST['id'];
  $telefon=$_COOKIE['telefon'];

  //przechowywanie danych z formularza i ciasteczek

  $sql="
  INSERT INTO zamowienia(klient,ID_dania,telefon,status)
  VALUES
  ('$klient',$id,$telefon,1);
  ";
  $result =$conn->query($sql);
  if ($result==TRUE){
    echo("
    
    <form action='' method='post'>
    <div class='text-center' style='color:green'>Zamówienie złożone pomyślnie,
    <input type='submit'name='reload' value='odśwież'>
    by zobaczyć zmiany</div><br/><br/><br/>
    </form>

    ");
  }
  else{
    echo("
    <br/><br/><div class='text-center' style='color:red'>Nie udało się złożyć zamówienia</div>
    ");
  }
}

?>
            </div>
            <div class="col-2">
<?php

if(isset($_COOKIE['pracownik'])){
  echo("
    <form action='' method='post'>
      <input type='submit' class='btn btn-outline-dark' style='margin-top:30px; width:12vw' name='wyloguj' value='Wyloguj się'>
    </form>
  ");
}
else{

if(isset($_COOKIE['imie'])&& isset($_COOKIE['nazwisko'])){
    echo("
    <form action='' method='post'>
      <input type='submit' class='btn btn-outline-dark' style='margin-top:30px; width:12vw' name='wyloguj' value='Wyloguj się'>
    </form>
    ");
  }
  else{
    echo("
    
    <a href='logowanie.php' class='btn btn-outline-success' style='margin-left:10%; margin-top:30px'>Zaloguj się</a>

    ");
  }

}
?>
                <br/><br/><h3>Kontakt:</h3>
                <br/><div>Telefon:</div><br/>
                <div>231-555-1221</div>
                <br/><h3>Adres:</h3>
                <br/><div>Warszawa 03-901</div>
                <div>Poniatowskiego 12</div>
            </div>
        </div><br/><br/><br/>       
    </div></br></br></br></br></br>
    <footer class="container-fluid bg-info">
      <div class="row">
        <div class="col-3">
          <h5>Adres: Warszawa 03-901 Poniatowskiego 12</h5>
        </div>
        <div class="col-7 text-center">
          <div>Pizzeria czynna codziennie od godziny 12.00 do 22.00, a w piątki, soboty i niedziele od 12.00 do 23.00</div>
        </div>
        <div class="col-2">
          <h5>Telefon: 231-555-1221</h5>
        </div>
      </div>
    </footer>
  </body>
</html>