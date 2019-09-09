<?php
	header('Content-type: text/calendar; charset=utf-8');
	header('Content-Disposition: inline; filename=calendar.ics');
  
	echo "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//hacksw/handcal//NONSGML v1.0//EN";
	require_once "error.php";
	require_once "connect.php";
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;

	}
	else
	{

$sql = "SELECT     Rezerwacje.RezerwacjaID, 
     DATE_FORMAT(Rezerwacje.DataOd,'%Y%m%d') AS DataOd,
    DATE_FORMAT(Rezerwacje.DataDo, '%Y%m%d') AS DataDo,
        Rezerwacje.Osob,    Rezerwacje.Cena FROM    Rezerwacje,    Pokoje,    Klienci WHERE    Rezerwacje.PokojID = Pokoje.PokojID        AND Rezerwacje.KlientID = Klienci.KlientID AND Rezerwacje.PokojID = 1  ORDER BY Rezerwacje.DataOd ASC;";

$result = mysqli_query($polaczenie, $sql);
if (mysqli_num_rows($result) > 0)
 {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
     echo "\r\nBEGIN:VEVENT\r\nDTSTART;VALUE=DATE:". $row["DataOd"]. "\r\nDTEND;VALUE=DATE:". $row["DataDo"] ."\r\nUID:" . $row["RezerwacjaID"].  "@BAZA15.PL\r\nSUMMARY: Osob" .$row["Osob"] . ", Cena:" .$row["Cena"]. "\r\nEND:VEVENT";
    }
} else {
    echo "0 results";
}

		mysqli_close($polaczenie);
	}
	echo "\r\nEND:VCALENDAR";
?>

