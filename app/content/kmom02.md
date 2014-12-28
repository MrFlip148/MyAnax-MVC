Kmom02: Kontroller och modeller
------------------------------------

Då har man utvecklat sidan med möjligheter att lämna kommentarer. Det var ett mycket intressant moment med en del steg som jag inte räknade med att man skulle behöva ta. Momentet var frustrerande på vissa delar då jag inte kunde installera composer på min egen dator, något med att wamp inte kunde uppgradea sin php version eftersom apache inte kunde uppdatera. Användandet av PHP CLI vart något som jag inte visste fanns förens nu, och jag såg inte några större användning för det, men man får se hur mycket man behöver använda det i framtiden. Eftersom jag inte kunde installera composer i min utvecklingsmijlö så fick jag jobba helt från studentservern.

**Composer:** Till en början så hade jag problem med att validera composer.json men det lyckades jag fixa efter en, till synes, meningslös redigering av:
 
		"require-dev": {
			"satooshi/php-coveralls": "dev-master"
		},
		"require": {
			"phpmvc/comment": "dev-master"
		}

Efter redigeringen och valideringen av composer.json så var det inte så mycket man behövde göra med Composer. Så efter detta försök så känner jag att Composer inte var så farligt att jobba med, men kommer behöva jobba mer med den för att bygga en bättre uppfattning av Composer.

**Packagist:** Packagist var något intressant att arbeta med och paketen man kan hitta där kan definitivt vara något som jag använder i mitt ramverk för framtida bruk. Om jag skriver något som jag anser kan vara värt för andra att använda så kommer jag nog att använda Packagist för att göra mina lösningar tillgängliga. I och med att Packagist använder Composer så ser jag att användningen av Composer kommer öka i framtiden, för min del iallafall.

Det vart en del arbete att få hela kommentarsystemet att gå ihop och jag spenderade mycket tid med att läsa klasserna och de övriga filer som fanns med i paketet. Hela processen med att använda klasser som kontroll för tjänster som dispatchas var helt nytt för mig så jag fick ta en del tid för att läsa på och testa olika lösnignar för att få ihop det. Till slut så fick jag ihop hela kommentarsystemet men trots att systemet var solid så kände jag att något saknades. För en del at kraven för inlämningen så var jag tvungen att utöka kommentarklasserna med en del funktioner. Jag måste säga att detta moment var en mycket bra och nödvändig erfarenhet.