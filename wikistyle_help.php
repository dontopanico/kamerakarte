<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link rel="stylesheet" type="text/css" href="content.css" />
        <link rel="stylesheet" type="text/css" href="wikistyle.css" />
    </head>
<body>
<?php
// TODO: anscheinend ist das Charset hier nicht richtig!!!
include("wikistyle.php");

function wikihelp_long() {
    $text = <<<EOF
======Formatierungführer======
frei nach [[http://wikkawiki.org WikkaWiki]] übersetzt.
<<**Hinweis:** Alles zwischen 2 Gänsefüsschen wird nicht formatiert.<<::c::
----
=====Textformatierung=====

~##""**Fett**""##
~**Fett**

~##""//Kursiv//""##
~//Kursiv//

~##""__Unterstrichen__""##
~__Unterstrichen__!

~##""##Monospace##""##
~##Monospace##

~##""''Hervorgehoben''""## (2 einzelne Hochkommata)
~''Hervorgehoben''

~##""++Durchgestrichen++""##
~++Durchgestrichen++

~##""@@Zentrierter Text@@""##
~@@Zentrierter Text@@

=====Überschriften=====

~##""====== 1. Ordnung ======""##
~====== 1. Ordnung ======
  
~##""===== 2. Ordnung =====""##
~===== 2. Ordnung =====

~##""==== 3. Ordnung ====""##
~==== 3. Ordnung ====

~##""=== 4. Ordnung ===""##
~=== 4. Ordnung ===

~##""== 5. Ordnung ==""##
~== 5. Ordnung ==

=====Horizontaler Trenner=====
~##""----""##
----

=====erzwungener Zeilenumbruch=====
~##""---""##
---

=====Listen und Einrückungen=====

Einrückungen durch **~**, einem **<Tab>** oder **4 Leerzeichen**. (Es wird alles in einen Tab verwandelt.)

##""~Dieser Text ist eingerückt""##
##""~~Dieser Text ist doppelt eingerückt""##
##""~Und dieser Text ist wieder einfach eingerückt""##

~Dieser Text ist eingerückt
~~Dieser Text ist doppelt eingerückt
~Und dieser Text ist wieder einfach eingerückt


Um eine einfache Liste oder geordnete Liste zu erstellen, benutze folgende Symbolik (du kannst auch einfach 4 Leerzeichen setzen, anstatt immer diesen Kram da: ##**~**##):

**Einfache Liste**
##""~- Zeile eins ""##
##""~~- Zeile eins eins""##
##""~~~- Zeile eins eins eins""##
##""~~- Zeile eins zwei""##
##""~- Zeile zwei""##

~- Zeile eins 
~~- Zeile eins eins
~~~- Zeile eins eins eins
~~- Zeile eins zwei
~- Zeile zwei


**Nummerierte Liste**
##""~1)  Zeile eins""##
##""~1)  Zeile zwei""##

	1) Zeile eins
	1) Zeile zwei

**Großbuchstaben Liste**
##""~A) Zeile eins""##
##""~A) Zeile zwei""##

	A) Zeile eins
	A) Zeile zwei

**Kleinbuchstaben Liste**
##""~a) Zeile eins""##
##""~a) Zeile zwei""##

	a) Zeile eins
	a) Zeile zwei

**Römische Zahlen Liste**
##""~I) Zeile eins""##
##""~I) Zeile zwei""##

	I) Zeile eins
	I) Zeile zwei

**Kleinbuchstaben Römische Zahlen Liste**
##""~i) Zeile eins""##
##""~i) Zeile zwei""##

	i) Zeile eins
	i) Zeile zwei

===Kommentarliste===

Um eine Kommentarliste zu erstellen, benutze die Einrückung (**~**, a **tab** or **4 spaces**) gefolgt von einem **""&amp;""**:

##""~&amp; Kommentar""##
##""~~&amp; Kommentar auf das Kommentar""##
##""~~~&amp; Kommentar auf das Kommentar des Kommentars""##
##""~~&amp; 2. Kommentar auf das Kommentar""##

~& Kommentar
~~& Kommentar auf das Kommentar
~~~& Kommentar auf das Kommentar des Kommentars
~~& 2. Kommentar auf das Kommentar

=====Bilder=====

Um ein Bild einzubauen, benutze die ##image## Funktion.

**Einfaches Bild**
##""{{image url="pfad/zum/bild.jpg" alt="Alternativtext"}}""##

**Bild mit Tooltipp, Positionsangabe und Link**
##""{{image url="pfad/zum/bild.jpg" alt="Alternativtext" title="Tooltip" class="center" link="http://homepagepfad.org"}}""##

##url## und ##alt## sollten angegeben werden, weitere Angaben sind optional.

##url## akzeptiert folgende Dateiendungen: ##.jpg##, ##.gif## und ##.png##.
In ##alt## steht der Text, der, sollte das Bild nicht gefunden werden, angezeigt wird.
In ##title## steht der Text, der, wenn die Maus über das Bild gehalten wird, aufpoppt.
##class## hat die Optionen: ##left##, ##center##, ##right##.
##link## verwandelt das Bild optional in einen Link. Bei externen Adressen wie im obigen Beispiel immer ##""http://""## hinzufügen.

=====Links=====

Um einen Link zu erstellen benutze diese Symbolik: ##""[[Link Alternativtext]]""##

**Externe Links**
##""[[http://www.scroogle.com]]""##
[[http://www.scroogle.com]]

##""[[http://www.scroogle.com böses Google]]""##
[[http://www.scroogle.com böses Google]]

**Interne Links**
Alternativ zu ##cat## kann auch ##""+""## genutzt werden
##""[[cat5 Kategorie mit ID 5]]""##
##""[[+5 Kategorie mit ID 5]]""##
[[cat5 Kategorie mit ID 5]]

Alternativ zu ##ent## kann auch ##""*""## genutzt werden
##""[[ent42 Eintrag mit ID 42]]""##
##""[[*42 Eintrag mit ID 42]]""##
[[*42 Eintrag mit ID 42]]

**Mailadressen**
##""[[email@adresse.com]]""##
[[email@adresse.com]]

##""[[email@adresse.com mit Unsichtbartext]]""##
[[email@adresse.com mit Unsichtbartext]]

=====Tabellen=====

Tabellen können durch zwei vert. Linien (##""||""##) kreirt werden. Alles was in einer einfachen Zeile wird als Tabelle geschrieben.

**Beispiel:**

##""||Spalte 1||Spalte 2||""##

||Spalte 1||Spalte 2||

Kopfzeilen können durch Gleichheitszeichen zwischen vert. Linien definiert werden (##""|=|""##).

**Beispiel:**

##""|=|Kopfzeile 1|=|Kopfzeile 2||""##
##""||Spalte 1||Spalte 2||""##

|=|Kopfzeile 1|=|Kopfzeile 2||
||Spalte 1||Spalte 2||

Zusammenfügen von Zeilen und Spalten kann durch ##x:## und ##y:## in runden Klammern nach der vert. Linie.

**Example:**

##""|=| |=|(x:2)Spalte||""##
##""|=|(y:2) Zeile||Zelle 1||Zelle 2||""##
##""||Zelle 3||Zelle 4||""##

|=| |=|(x:2)Spalte||
|=|(y:2) Zeile||Zelle 1||Zelle 2||
||Zelle 3||Zelle 4||

<<Noch mehr Infos zum [[http://demo.wikkawiki.org/TableMarkup TableMarkup]] gibt es auf der Homepage von [[http://wikkawiki.org WikkaWiki]], deren Formatierungs-Engine wir benutzen.<<::c::

=====farbiger Text=====

Farbiger Text kann durch ##color## ergänzt werden:

**Beispiel:**

~##""{{color c="blue" text="bescheuerter Test"}}""##
~{{color c="blue" text="bescheuerter Test"}}

Oder mit hexadezimalen Zahlen:

**Beispiel:**

~##""{{color hex="#DD0000" text="Ein anderer völlig bescheuerter Test"}}""##
~{{color hex="#DD0000" text="Ein anderer völlig bescheuerter Test"}}

Alternativ können Vordergrund und Hintergrund durch ##fg## und ##bg## geändert werden (wie oben kann ##c=" ... "## oder ##hex=" ... "## verwendet werden).

**Beispiele:**

~##""{{color fg="#FF0000" bg="#000000" text="Wie einfach muss sich jemand vorkommen der nur sowas anzeigen kann."}}""##
~{{color fg="#FF0000" bg="#000000" text="Wie einfach muss sich jemand vorkommen der nur sowas anzeigen kann."}}

~##""{{color fg="yellow" bg="black" text="Und dies erst."}}""##
~{{color fg="yellow" bg="black" text="Und dies erst."}}


=====umfliessende Boxen=====

Um eine **links umflossene Box** zu erhalten, benutze ##""<<""## vor und nach dem Block.

**Beispiel:**

##""<<Wollen sich die Massen befreien, ... auszuarbeiten. ''P. Kropotkin (vermutlich übersetzt von G. Landauer)'' << 
Datenautobahn: 
Veraltend, dient dazu, Nichtmitg ... Chaos.
''Martin Haase. Zitat von [[http://neusprech.org/index.php/2010/04/datenautobahn/ http://neusprech.org]]''""##

<<Wollen sich die Massen befreien, welche alle Güter erzeugen, ohne daß ihnen gestattet wird, die Verteilung und den Konsum dessen, was sie erzeugen, zu regeln, so ist es durchaus erforderlich, daß sie die Mittel und Wege finden, die es ihnen möglich machen, ihre schöpferischen Kräfte zu entbinden und selbst die neuen und gleichheitlichen Formen des Konsums und der Produktion auszuarbeiten.
''P. Kropotkin (vermutlich übersetzt von G. Landauer)'' << Datenautobahn:
Veraltend, dient dazu, Nichtmitgliedern der Internetcommunity das Internet als Ort des schnellen Austausches von Daten bildlich (also metaphorisch) zu erläutern. Wie viele sprachliche Bilder ist auch die D. ungenau, bedeutete sie doch beispielsweise, dass die Daten nur in eine festgelegte Richtung fließen würden und es keinen Austausch, auch Kommunikation genannt, geben könnte. Auf dem Höhepunkt ihrer Nutzung fand die D. 1996 mit einem Schlager sogar Eingang in die Populärkultur und es entstand eine ganze Metaphernfamilie. So träumten Politiker und Unternehmer in der Euphorie der 1990er auf der sowieso schon schnellen D. beispielsweise noch von einer gesonderten Überholspur. Inzwischen jedoch ist die Euphorie der Angst gewichen, was sich unter anderem in den Metaphern zeigt. So fordern Politiker nun Verkehrsregeln für das Internet, verlangen das Aufstellen von Leitplanken oder gar von Stoppschildern. An letzteren zeigt sich gut, wie schwierig solche Bilder sein können, sind Stoppschilder auf Autobahnen doch eher selten und würden bestenfalls Verwirrung stiften, schlimmstenfalls aber lebensgefährliches Chaos.
''Martin Haase. Zitat von [[http://neusprech.org/index.php/2010/04/datenautobahn/ http://neusprech.org]]''

::c::Um eine **rechts umflossene Box** zu erhalten, benutze ##"">>""##, statt ##""<<""## (für die links umflossene Box), bevor und nach dem Block.

Benutze ##""::c::""## um dich von der Box zu distanzieren.

----
Wie oben schon erwähnt, wurde das Parsen vom [[http://wikkawiki.org WikkaWiki-Projekt]] übernommen. Für die Verfügbarkeit des Quelltextes (der unter der GNU General Public License Version 2 steht) bedanken wir uns vielmals bei den [[http://wikkawiki.org/CreditsPage Entwicklern]]. Wir haben uns an Version 1.2 des Projekts orientiert, einiges eingekürzt und anderes hinzugefügt.
EOF;
    /* EOF must stay in the beginning of the line !! */
    return parse_wikistyle($text);
}

echo wikihelp_long();
?>
</body>
</html>
