<?php
// show FAQ in index.php
$file = basename($_SERVER['PHP_SELF']);
if($file == "index.php"){ ?>
<h1>FAQ (Frequently Asked Questions)</h1>
<p>Ihr seid bei den häufig-gestellten-Fragen gelandet. Es werden <b>alle</b> Fragen <br />
beantwortet, die für die Benutzung und das Betrachten der Kamerakarte notwendig sind. <br />
Sollten neben der alles beantwortenden Antwort noch Fragen offen bleiben schreibt uns eine <br />
Mail an <a href="mailto:<?php echo $mail_to_shown;?>"><?php echo $mail_to_shown;?></a> .</p>

<br />
<h2>Wie kann ich Überwachungsobjekte eintragen?</h2>
<p>Im Menü auf der linken Seite steht "Eintrag hinzufügen". Der Rest ist selbsterklärend! <br />
Soforteintragungswillige drücken <a href="form.php">hier</a>.</p>

<br />
<h2>Die Karte wird nicht angezeigt. Was soll diese Seite?</h2>
<p>Für das korrekte Anzeigen der Karte muß JavaScript eingeschaltet werden. Möglicherweise <br />
blockt eine Software (NoScript, Torbutton, ...) das Ausführen von JavaScript. Oder<br />
JavaScript ist im Browser ausgeschaltet.</p>

<br />
<h2>Warum wird auch JavaScript von Google genutzt?</h2>
<p>Neben den Layern von openstreetmap können auf der rechten Seite auch die Satellitenbilder <br />
von Google Maps eingeschaltet werden. Beim Verorten von neuen Kameras kann die <br />
Satellitenansicht durchaus helfen.<br />
Mit Hilfe von Browsererweiterungen (z.B. <a href="http://noscript.net">NoScript</a> ) ist es möglich Googles und viele andere <br />
Skripte zu blocken.</p>

<br />
<h2>Welche Kameras werden aufgenommen?</h2>
<p>Wir nehmen alle Kameras auf, die den öffentlichen Raum überwachen. Die Bewertung der <br />
jeweiligen Kameras steht bei diesem Projekt nicht im Fokus, sondern das Schaffen eines <br />
Bewusstseins für das Ausmaß der täglichen Überwachung.</p>

<br />
<h2>Was definiert ihr als öffentlichen Raum?</h2>
<p>Öffentlicher Raum bedeutet im Kontext dieser Karte: Alles, was für Menschen im Alltag frei <br />
zugänglich ist, d.h. neben Straßen und Plätzen auch Parkhäuser, Einkaufspassagen, Bahnhöfe, <br />
Cafes und Geschäfte.</p>

<br />
<h2>Was ist mit Kameras außerhalb des öffentlichen Raums?</h2>
<p>Kameras, die nicht den von uns definierten öffentlichen Raum überwachen, sollten auf dieser <br />
Karte zunächst nicht eingetragen werden.<br />
Wenn also eure Vermieter_in im Treppenhaus eine Kamera installiert hat, wendet euch direkt an <br />
uns. Kameras die beispielsweise in Hauseingängen oder Einfahrten hängen können auch <br />
eingetragen werden, wenn die Kamera den öffentlichen Raum erfasst.</p>

<br />
<h2>Wie sieht es mit anderen überwachungstechnischen Maßnahmen aus?</h2>
<p>Da sich in Zukunft die Sicherheitsarchitekturen (hoffentlich nicht) weiterentwickeln werden, <br />
möchten wir diese Karte nicht nur auf Kameras festlegen. Um weitere technische <br />
Errungenschaften der Sicherheitsindustrie (zum Beispiel RFID-Leser, ...) zu erfassen, werden <br />
wir bei Bedarf weitere Kategorien hinzufügen.</p>

<br />
<h2>Meine Kamera steht bei euch zu Unrecht, ich will weg hier.</h2>
<p>Wir versuchen, jeden Eintrag auf dieser Karte zu prüfen um Falscheintragungen zu vermeiden. <br />
Sollte uns dies einmal nicht gelingen oder unsere Einschätzung entspricht nicht den der <br />
Betreiber_innen, bitten wir darum, uns direkt anzusprechen <a href="mailto:<?php echo $mail_to_shown;?>"><?php echo $mail_to_shown;?></a>, um die <br />
Sache zu klären.</p>

<br />
<h2>Können auch Bilder zur Dokumentation hochgeladen werden?</h2>
<p>Automatisiert können keine Bilder hochgeladen werden. Wir nehmen aber gerne Bilder per Mail <br />
in Empfang.<br />
Wir werden allerdings Gesichter unkenntlich machen und die Größe anpassen.</p>

<br />
<h2>Können wir eine ausgedruckte Liste haben (Stichwort Internetausdrucker)? </h2>
<p>Da die Karte auf Openstreetmap basiert, steht allen frei diese auszudrucken.<br />
Aber mal im Ernst: Wer rennt mit so einem Ausdruck rum?</p>

<br />
<h2>Wie kann ich gegen unzulässige Kameras vorgehen?</h2>
<p>Viele der installierten Kameras bestehen eine Prüfung nach den Vorgaben des <br />
Bundesdatenschutzgesetzes oder des Verwaltungsgesetzes in der Tat nicht. Deshalb lohnt es <br />
sich immer wieder, Kameras hinsichtlich ihrer Zulässigkeit zu untersuchen. Eine solche <br />
Prüfung muss immer im Einzelfall erfolgen und wird in der Regel durch den/die <br />
Landesdatenschutzbeauftragte/n durchgeführt und durchgesetzt. Schickt uns eine Mail, wir <br />
beraten gerne in solchen Fällen.<br />
Oftmals reicht eine informelle Anfrage an die Betreiber_innen bereits aus, um die die <br />
Situation zu verbessern. Einen groben Rahmen für die Zulässigkeit einer Videoüberwachung <br />
findet ihr beim <a href="https://www.ldi.nrw.de/mainmenu_Datenschutz/submenu_Datenschutzrecht/Inhalt/Videoueberwachung/">Landesdatenschutzbeauftragten NRW</a></p>
<?php } ?>
