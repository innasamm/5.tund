

<?php

// võtab ja kopeerig config.php faili config.php

require ("function.php");
//kas kasutaja on sisse logitud

if  (isset ($_SESSION ["userId"])) {
      header ("Location: data.php");

}

    //var_dump ($_GET); //var_dump näitab kõike, mis on muutujaks määratud-
    // näitab andmetüüpi ja väärtust

    //echo "<br>"; echo trükib stringi sõnumina välja

    //var_dump ($_POST);



    // kontrollin, kas vajalikud andmed olid olemas:

    // MUUTUJAD:

$signUpEmail = ""; //alguses on ta tühi väärtus
$signUpEmailError = "";
$signUpPasswordError = "";
$signUpNameError = "";
$signUpFamilyNameError = "";
$signUpBirthdayError = "";
$signUpCodeError = "";
$gender = "";
$loginEmail = "";
$loginPassword = "";
$loginEmailError = "";
$loginPasswordError = "";



    if (isset ($_POST["loginEmail"]) ) {
//kas keegi vajutas submit nuppu nii, et e-mail oli olemas!
            if (empty ($_POST["loginEmail"] ) ) {
            // e-maili koht oli TÜHI!
                $loginEmailError =  "See väli on kohustuslik";

            } else {

              //e-mail on õige, oli olemas!
              $loginEmail = $_POST["loginEmail"];
            }

       }
      if (isset ($_POST["loginPassword"]) ) {

            if (empty ($_POST["loginPassword"] ) ) {

                    $loginPasswordError =  "See väli on kohustuslik";

      } else {

          //tean, et parool oli ja see ei olnud tühi. vähemalt 8!

                if (strlen($_POST["loginPassword"]) < 8 ) {

                    $loginPasswordError = "Parool peab olema vähemalt 8 tähemärki pikk";
                    }

                }
              }



//SIIAMAANI!!!!!!!!!!!!!


























    if (isset ($_POST["signUpEmail"]) ) {
//kas keegi vajutas submit nuppu nii, et e-mail oli olemas!
            if (empty ($_POST["signUpEmail"] ) ) {
            // e-maili koht oli TÜHI!
                $signUpEmailError =  "See väli on kohustuslik";

            } else {

              //e-mail on õige, oli olemas!
              $signUpEmail = $_POST["signUpEmail"];
            }

       }
              if (isset ($_POST["signUpPassword"]) ) {

                  if (empty ($_POST["signUpPassword"] ) ) {

                $signUpPasswordError =  "See väli on kohustuslik";

                } else {

          //tean, et parool oli ja see ei olnud tühi. vähemalt 8!

                if (strlen($_POST["signUpPassword"]) < 8 ) {

                    $signUpPasswordError = "Parool peab olema vähemalt 8 tähemärki pikk";
                    }
                    }
                    }

      if (isset ($_POST["signUpName"]) ) {

            if (empty ($_POST["signUpName"] ) ) {
          // oli nimi, kuid see oli tühi
            $signUpNameError =  "See väli on kohustuslik";

                }
              }

                if (isset ($_POST["signUpFamilyName"]) ) {

                    if (empty ($_POST["signUpFamilyName"] ) ) {
          // oli e-mail, kuid see oli tühi
                $signUpFamilyNameError =  "See väli on kohustuslik";

                    } else {

          //tean, et perekonnanimi oli ja see ei olnud tühi

                    if (strlen($_POST["signUpFamilyName"]) < 1 ) {

                    $signUpFamilyNameError = "Perekonnanimi peab olema vähemalt 1 tähemärk pikk!";
                  }
                }
              }

              if (isset ($_POST["signUpBirthday"]) ) {

                            if (empty ($_POST["signUpBirthday"] ) ) {
                      // oli sünniaeg, kuid see oli tühi
                          $signUpBirthdayError =  "See väli on kohustuslik";

                      }
                      }

                      if (isset ($_POST["signUpCode"])) {

                              if (empty ($_POST["signUpCode"] ) ) {
                                  $signUpCodeError =  "Kontrolli kontrollkoodi";

                              }
                              }

 if (isset ($_POST["gender"]) ) {
         if (empty ($_POST["gender"] ) ) {
             $genderError =  "See väli on kohustuslik";
         } else {
           $gender = $_POST["gender"];
         }

    }




//Tean, et ühtegi viga ei olnud ja saan kasutaja andmed salvestada:

if (  isset($_POST["signUpPassword"]) &&
      isset($_POST["signUpEmail"]) &&
      empty ($signUpEmailError) &&
      empty ($signUpPasswordError) )
      {

      echo "Salvestan... <br>";
      echo "email ".$signUpEmail."<br>";

      $password = hash ("sha512", $_POST["signUpPassword"]);

      echo "parool" .$_POST["signUpPassword"]. "<br>";
      echo "räsi ".$password."<br>";
      // echo $serverUsername;  ECHO ON PRINTIMINE!!
      signup ($signUpEmail, $password);

}
$error = " ";
// kontrollin, et kasutaja täitis väljad ja võib sisse logida
if ( isset ($_POST ["loginEmail"]) &&
   isset ($_POST ["loginPassword"]) &&
   !empty ($_POST ["loginEmail"]) &&
   !empty ($_POST ["loginPassword"])
) {

// login sisse
  $error = login ($_POST["loginEmail"], $_POST["loginPassword"]);
}

?>
<!DOCTYPE html>
<html>
  <head>
  <title>Sisselogimise lehekülg</title>
  </head>
  <body>



    <h1>Logi sisse</h1>

      <form method = "POST">
        <p style = "color:red;"> <?=$error;?> </p>
        <input name ="loginEmail" type = "email" placeholder="e-posti aadress" value= "<?=$loginEmail;?>"> <?php echo $loginEmailError; ?>

        <br> <br>

        <input  name = "loginPassword" type = "password" placeholder="parool" <?=$loginPassword; ?> <?php echo $loginPasswordError; ?>

        <br> <br>

        <input type = "submit" value = "LOGI SISSE"

      </input>
      </form>


  <h1>Loo kasutaja</h1>

      <form method = "POST">
        <input name ="signUpEmail" type = "email" placeholder="e-posti aadress" value="<?=$signUpEmail;?>"> <?php echo $signUpEmailError; ?>
        <br><br>
        <!--type input ja value on atribuudid -->
        <!--type määrab tüübi, value on väärtus-->


        <input  name = "signUpPassword" type = "password" placeholder="parool"> <?php echo $signUpPasswordError; ?>

        <br><br>

        <input name = "signUpName" type = "name" placeholder ="Sinu nimi"> <?php echo $signUpNameError; ?>

        <br><br>

        <input name = "signUpFamilyName" type = "familyname" placeholder = "Sinu perekonnanimi"> <?php echo $signUpFamilyNameError; ?>
        <br><br>

        <input name = "signUpBirthday" type = "birthday" placeholder= "Sinu sünniaeg pp/kk/aaaa"> <?php echo $signUpBirthdayError; ?>
        <br><br>

        <label>Sisesta kontrollkood</label> <br>
        <input name = "signUpCode" type = "controlcode" placeholder = "XgT64Hrf"> <?php echo $signUpCodeError; ?>
        <br><br>

        <?php if($gender == "male") { ?>
                <input type="radio" name="gender" value="male" checked> Mees<br>
               <?php } else { ?>
                <input type="radio" name="gender" value="male" > Mees<br>
               <?php } ?>

               <?php if($gender == "female") { ?>
                <input type="radio" name="gender" value="female" checked> Naine<br>
               <?php } else { ?>
                <input type="radio" name="gender" value="female" > Naine<br>
               <?php } ?>

               <?php if($gender == "other") { ?>
                <input type="radio" name="gender" value="other" checked> Muu<br>
               <?php } else { ?>
                <input type="radio" name="gender" value="other" > Muu<br>
               <?php } ?>
        <input type = "submit" value = "REGISTREERU">

      </input>
      </form>




      <p> Wanna go clubbing? Can't find a proper place? Me aitame Sind! ClubOGo aitab valida soovitud distantsile jäävate klubide seast <br>
        külastajate
        hinnangutele tuginedes selle õige. Et ükski pilet poleks "waste of money". Liitu kohe!</p>
</html>
