<?php function head() { ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nestwerk: Spielplätze in Münster</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="spielplatz.css" type="text/css">
    
       <script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  crossorigin="anonymous"></script>
    <script src="jquery.csv.js"></script>


<!--    
    <link rel="stylesheet" href="leaflet.css" type="text/css"/>
    <script src="leaflet.js" type="text/javascript"></script>
-->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
  integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
  crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
  integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
  crossorigin=""></script>
   
   <script src="spielplatz.js" type="text/javascript"></script>
</head>
<body>
 <div class="overlay" id="top">
 <?php
} /* End of function */
    function contains($haystack, $needle) { return strpos( $haystack, $needle ) !== false; }
 
     if($_SERVER["QUERY_STRING"]!="") {
         $soap = $_SERVER["QUERY_STRING"];

        if (($handle = fopen("spielplaetze-secrets.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE) {
                # 0, 1, 2 = ID, Name, Secret
                if(contains($soap, $data[0]) && contains($soap, $data[2])) {
                    if($_POST) {
                        $sep = ","; # thanks to jquery csv :(
                        $txt = time() . $sep . $data[0] . $sep . htmlentities($_POST["msg"]);
                        $myfile = file_put_contents('msg.log', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
                        #print "Posted: ".htmlentities($_POST["msg"]);
                        header("Location: ./"); // the thing without query string ".$_SERVER["REQUEST_URI"]);
                        exit; 
                    } else {
                        head();
                    ?><form method="post" action="<?php print($_SERVER['REQUEST_URI']); ?>">
                        <input type="hidden" name="soap" value="<?php print(htmlentities($soap)); ?>">
                        <input name="msg" placeholder="Dein Interesse...">
                        <input type="submit" value="Für 1h Posten">
                    </form>
                    <?php
                    }
                }
            }
        }/* end loop csv */
    } else {
        head();
        ?>
        <a class="button" href="#" onclick="$('#howto').slideToggle();">Announcieren?</a>
        <div id="howto" style="display:none;">
            Gehe auf einen Münsteraner Spielplatz deiner Wahl und suche den QR-Code von
            <em>Nestwerk</em>. Scanne ihn mit deinem Handy, um ein Thema einzutragen
            welches dich interessiert.
        </div>
        <?php
    }
 ?>
 </div>
 <div class="overlay" id="bottom">
    <strong>Nestwerk</strong>: Spielplätze in Münster.
    <a class="button" href="#">Mehr Funktionen...</a>
 </div>
 <div id="mapid"></div>

</body>
</html>
