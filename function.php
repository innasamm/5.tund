<?php

  require ("../../config.php");

	//function.php

  //alustan sessiooni, et saaks kasutada $_SESSION muutujaid

  session_start();

	//********************
	//****** SIGNUP ******
	//********************
	//$name = "innasamm";
	//var_dump($GLOBALS);

	$database = "if16_innasamm";

	function signup ($email, $password) {

		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("ss", $email, $password);

		if ($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}

	}




function login ($email, $password) {
  $error = " ";
  $mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
  $stmt = $mysqli->prepare("

  SELECT id, email, password, created
  FROM user_sample
  WHERE email = ?");

  echo $mysqli->error;

  // asendan küsimärgi
  $stmt->bind_param("s", $email);
  // määran tulpadele muutujaid, kus ma tulpade andmeid http_negotiate_content_type

  $stmt->bind_result($id, $emailFromDatabase, $passwordFromDb, $created);
  $stmt->execute(); //paneb päringu teele, tulemus igal juhul tõene, päring õnnestub igal juhul
  //küsin rea andmeid
  if($stmt->fetch()) {
      //oli rida
      //võrdlen paroole
      $hash = hash("sha512", $password);
      if($hash == $passwordFromDb) {
          echo "kasutaja " .$id." logis sisse";

          $_SESSION ["userId"] = $id;
          $_SESSION ["email"] = $emailFromDatabase;


          header ("Location: data.php ");

      } else {
            $error =  "parool vale";
      }

  }  else {
    //ei olnud
    $error =  "sellise emailiga " .$email." kasutajat ei olnud";

  }

  return $error;
}


//uus funktsioon nimega savePeople nt, kuhu saadame andmed color ja soo kohta tabelisse. aluseks signUp funktsioon


function savePeople ($campusGender, $campusColor) {

  $mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
  $stmt = $mysqli->prepare("INSERT INTO clothingOnTheCampus (gender, color) VALUES (?, ?)");
  echo $mysqli->error;
  $stmt->bind_param("ss", $campusGender, $campusColor);

  if ($stmt->execute()) {
    echo "salvestamine õnnestus";
  } else {
    echo "ERROR ".$stmt->error;
  }

}

function getAllPeople () {
  $error = " ";
  $mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
  $stmt = $mysqli->prepare("

      SELECT id, gender, color, created
      FROM clothingOnTheCampus

      ");
      echo $mysqli->error;

      $stmt->bind_result($id, $gender, $color, $created);
      $stmt->execute(); //paneb käsu tööle! saame teada, kas käsk läks läbi või mitte

      // array ("Inna", "I")
      $result = array ();

      //tingimus: seni, kuni on üks rida andmeid saada. 10 rida = 10 korda
      while ($stmt->fetch()) { //üks rida andmeid andmebaasist ja paneb need muutujate asemele
          //echo $color. "<br>";
          $person = new StdClass();
          $person->id = $id;
          $person->gender = $gender;
          $person->campusColor = $color;
          $person->created = $created;


          array_push($result, $person);
      }

      $stmt->close();
      $mysqli->close();
      return $result;

}





	/*function sum ($x, $y) {

		return $x + $y;

	}

	function hello ($firstname, $lastname) {

		return "Tere tulemast ".$firstname." ".$lastname."!";

	}

	echo sum(5476567567,234234234);
	echo "<br>";
	$answer = sum(10,15);
	echo $answer;
	echo "<br>";
	echo hello ("Inna", "S.");
	*/
?>
