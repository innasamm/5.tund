<?php

  require ("function.php");

  //lisame kontrolli, kas on kasutaja sisse loginud. kui ei ole, siis
  //suunata login lehele

//kas ?logout on aadressireal

if (isset ($_GET["logout"])) {
  session_destroy();

  header ("Location: login5_tund.php");
}

//väljad "naine" ja "toon" ei ole tühjad kontroll
if ( isset ($_POST ["campusGender"]) &&
   isset ($_POST ["campusColor"]) &&
   !empty ($_POST ["campusGender"]) &&
   !empty ($_POST ["campusColor"])
) {

  savePeople ($_POST["campusGender"], $_POST ["campusColor"]);
// login sisse
}

  $people = getAllPeople(); //käivitan funktsiooni
  var_dump($people);
?>



<h1> Data </h1>
<p>Tere tulemast! <?=$_SESSION ["email"];?> </p>

<a href = "?logout=1"> Logi välja    </a>

<h1> Salvesta mööduv tudeng </h1>

<form method = "POST">
  <label> Kirjuta sugu </label>
  <input name ="campusGender" type = "text" placeholder="sugu" >

  <br> <br>
  <label> Kirjuta värv </label>

  <input  name = "campusColor" type = "color" placeholder="toon" >

  <br> <br>

  <input type = "submit" value = "SALVESTA">

</form>


<h2>Arhiiv</h2>
<?php
	foreach($people as $p){

		echo 	"<h3 style=' color:".$p->campusColor."; '>"
				.$p->gender
				."</h3>";
	}
?>

<h2>Arhiivtabel</h2>
<?php

	$html = "<table>";
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>Sugu</th>";
			$html .= "<th>Värv</th>";
			$html .= "<th>Loodud</th>";
		$html .= "</tr>";
		foreach($people as $p){
			$html .= "<tr>";
				$html .= "<td>".$p->id."</td>";
				$html .= "<td>".$p->gender."</td>";
				$html .= "<td style=' background-color:".$p->campusColor."; '>"
						.$p->campusColor
						."</td>";
				$html .= "<td>".$p->created."</td>";
			$html .= "</tr>";
		}

	$html .= "</table>";
	echo $html;
?>
