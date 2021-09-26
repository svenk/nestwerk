<html>
<h3>Direktlinks zu Spielplatz-Announcen</h3>
<p>Eigentlich nicht zum öffentlichen Teilen gedacht. Eignet sich aber, um
zu Demonstrationszwecken die Karte zu füllen.

<ul>
<?php

$base = "https://spielplatz.muenster.dev/?";

if (($handle = fopen("spielplaetze-secrets.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE) {
        # 0, 1, 2 = ID, Name, Secret
        $clean_name = preg_replace("/[^a-zA-Z0-9]/", "", $data[1]);
        $suffix = $clean_name . "-" . $data[0] . "-" . $data[2];
        
        print "<li><a target='_blank' href='$base$suffix'>Spielplatz ".$data[1]."</a>";
    }
}

?>
