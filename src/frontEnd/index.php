<html>
    <?php
        session_start();
    ?>
    <script>
        window.onload = function () {
            window.scrollTo({top: 0,});

            console.log(`
                :'######::'##::::'##:'########::'####::'######::'########:
                '##... ##: ##:::: ##: ##.... ##:. ##::'##... ##: ##.....::
                ##:::..:: ##:::: ##: ##:::: ##:: ##:: ##:::..:: ##:::::::
                . ######:: ##:::: ##: ########::: ##:: ##::::::: ######:::
                :..... ##: ##:::: ##: ##.. ##:::: ##:: ##::::::: ##...::::
                '##::: ##: ##:::: ##: ##::. ##::: ##:: ##::: ##: ##:::::::
                . ######::. #######:: ##:::. ##:'####:. ######:: ########:
                :......::::.......:::..:::::..::....:::......:::........::
            `);
        }

        async function anayltic(){
            if(!sessionStorage['exists']){
                var cont = {content: navigator}
                console.log(cont);
                var xml = new XMLHttpRequest();
                xml.open("POST", "https://sebastian-web.de/api/v1/userInfo");
                xml.send(cont);
                sessionStorage['exists'] = true;
            }
        }
    </script>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale = 1">
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="./style.css">
        <script src="./index.js"></script>

        <link rel="stylesheet" href="./fontawesome/css/all.min.css">
<!--        <a href="#anchor-hash" class="anchor-scrolls"></a> -->

    <!-- Import Bootstrap -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <title>Sebastian-Web</title>
        <link rel="shortcut icon" type="image/x-icon" href='./img/SU_Logo_2.0_render.ico'>
    </head>

    <body>
        <div class="navbar" id="navbar">
            <a href="#home" class="navbar-link">Home</a>
            <a href="#intro" class="navbar-link">Introduction</a>
            <a href="#proj" class="navbar-link">Projects</a> 
            <a href="#comming" class="navbar-link">Comming soon...</a>
            <a href="#impressum" class="navbar-link">Impressum</a>
        </div>


        <!-- Cookie Consent by https://www.PrivacyPolicies.com -->
        <script type="text/javascript" src="//www.privacypolicies.com/public/cookie-consent/3.1.0/cookie-consent.js"></script>
        <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
        cookieconsent.run({"notice_banner_type":"interstitial","consent_type":"express","palette":"light","language":"en","website_name":"sebastian-web.de","cookies_policy_url":"https://sebastian-web.de#impressum","change_preferences_selector":""});
        });
        </script>

        <!-- Analytics -->
        <script type="text/plain" cookie-consent="tracking">anayltic()</script>
        <!-- end of Analytics-->

        <noscript>Cookie Consent by <a href="https://www.PrivacyPolicies.com/cookie-consent/" rel="nofollow">PrivacyPolicies.com</a></noscript>
        <!-- End Cookie Consent -->

        
        <div class="container" data-spy="scroll" data-target="#navbar" data-offset="0">
            <section id="home">
                <div class="welcome-txt">
                    <h5>Hello, my name is Sebastian.</h5>
                    <h1> Welcome to my Page</h1>
                </div>
            </section>
            <section id="intro">
                <h1 class="intro-head">Introduction</h1>
                <span>
                    <div class="intro-txt">
                        <p>This is my website for all kinds of coding projects.<br>for more informations have a look at the 'Projects' page</p>
                    </div>
                    <br>
                    
                    <table class="social-table">
                        <tr class="social-table-head">
                            <td><strong>My Social Media</strong></td>
                        </tr>
                        <br>
                        <tr>
                            <td>
                                <a href="https://www.discord.com/users/279230092167872512" target="_blank" class="fab fa-discord fa-3x"></a>
                                <a href="https://www.instagram.com/thesurice" target="_blank" class="fab fa-instagram fa-3x"></a>
                                <a href="https://open.spotify.com/user/surice99?si=bOENDn2yTjqoLYGaEq_X4g" target="_blank" class="fab fa-spotify fa-3x"></a>
                                <a href="https://www.twitch.tv/surice_gaming" target="_blank" class="fab fa-twitch fa-3x"></a>
                                <a href="https://github.com/Surice" target="_blank" class="fab fa-github fa-3x"></a>
                            </td>
                        </tr>
                    </table>
                </span>
            </section>
            <section id="proj">
                <h1 class="proj-head">Projects</h1>
                
                <div class="proj-table">
                        <a href="./subSites/steamSearch.php"><button class="btn-dum">Steam-Games</button></a>
                        <a href="./dev/index.php"><button class="btn-dum">Dev-Portal</button></a>
                        <a href="#"><button class="btn-dum">User-Portal<br>(comming soon)</button></a>
                        <a href="./subSites/mcCraftingGuide.php"><button class="btn-dum">MC Crafting Guide<br>(in progress...)</button></a>
                        <a href="#"><button class="btn-dum">ACC-Helper<br>(in progress...)</button></a>
                </div>
                <div class="proj-table">
                    <a href="#"><button class="btn-dum">dummy</button></a>
                    <a href="#"><button class="btn-dum">dummy</button></a>
                    <a href="#"><button class="btn-dum">dummy</button></a>
                    <a href="#"><button class="btn-dum">dummy</button></a>
                    <a href="#"><button class="btn-dum">dummy</button></a>
                </div>
            </section>
            <section id="comming">
                <div class="comming-txt">
                    <h1>more content will be comming soon...</h1>
                </div>
            </section>
            <section id="impressum">
                <div class='impressum-txt'>
                    <br>
                    <h1>Impressum</h1>
                    <p>Angaben gemäß § 5 TMG</p>
                    <p>Sebastian Ulrich <br>
                        Beethovenstraße 99<br>
                        22941 Bargteheide <br>
                    </p>
                    <p><strong>Kontakt:</strong> <br>
                        Telefon: +49 15780392596<br>
                        E-Mail: <a href='mailto:info@sebastian-web.de'>info@Sebastian-Web.de</a></br></p>
                    <p><strong>Haftungsausschluss: </strong><br><br><strong>Haftung für Inhalte</strong><br><br>
                        Die Inhalte unserer Seiten wurden mit größter Sorgfalt erstellt. Für die Richtigkeit,
                        Vollständigkeit und Aktualität der Inhalte können wir jedoch keine Gewähr übernehmen. Als
                        Diensteanbieter sind wir gemäß § 7 Abs.1 TMG für eigene Inhalte auf diesen Seiten nach den
                        allgemeinen Gesetzen verantwortlich. Nach §§ 8 bis 10 TMG sind wir als Diensteanbieter jedoch nicht
                        verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen
                        zu forschen, die auf eine rechtswidrige Tätigkeit hinweisen. Verpflichtungen zur Entfernung oder
                        Sperrung der Nutzung von Informationen nach den allgemeinen Gesetzen bleiben hiervon unberührt. Eine
                        diesbezügliche Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis einer konkreten
                        Rechtsverletzung möglich. Bei Bekanntwerden von entsprechenden Rechtsverletzungen werden wir diese
                        Inhalte umgehend entfernen.<br><br><strong>Haftung für Links</strong><br><br>
                        Unser Angebot enthält Links zu externen Webseiten Dritter, auf deren Inhalte wir keinen Einfluss
                        haben. Deshalb können wir für diese fremden Inhalte auch keine Gewähr übernehmen. Für die Inhalte
                        der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich. Die
                        verlinkten Seiten wurden zum Zeitpunkt der Verlinkung auf mögliche Rechtsverstöße überprüft.
                        Rechtswidrige Inhalte waren zum Zeitpunkt der Verlinkung nicht erkennbar. Eine permanente
                        inhaltliche Kontrolle der verlinkten Seiten ist jedoch ohne konkrete Anhaltspunkte einer
                        Rechtsverletzung nicht zumutbar. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Links
                        umgehend entfernen.</p>
                    Website Impressum erstellt durch <a href="https://www.impressum-generator.de">impressum-generator.de</a>
                    von der <a href="https://www.kanzlei-hasselbach.de/">Kanzlei Hasselbach</a>
                </div>
                <div class="dat-txt">

                    <p><strong><big>Datenschutzerklärung</big></strong></p>
                    <p><strong>Allgemeiner Hinweis und Pflichtinformationen</strong></p>
                    <p><strong>Benennung der verantwortlichen Stelle</strong></p>
                    <p>Die verantwortliche Stelle für die Datenverarbeitung auf dieser Website ist:</p>
                    <p><br><span id="s3-t-ansprechpartner">Sebastian
                            Ulrich</span><br><span id="s3-t-strasse">Beethovenstr. 99</span><br><span
                            id="s3-t-plz">22941</span>
                        <span id="s3-t-ort">Bargteheide</span></p>
                    <p></p>
                    <p>Die verantwortliche Stelle entscheidet allein oder gemeinsam mit anderen über die Zwecke und Mittel
                        der
                        Verarbeitung von personenbezogenen Daten (z.B. Namen, Kontaktdaten o. Ä.).</p>

                    <p><strong>Widerruf Ihrer Einwilligung zur Datenverarbeitung</strong></p>
                    <p>Nur mit Ihrer ausdrücklichen Einwilligung sind einige Vorgänge der Datenverarbeitung möglich. Ein
                        Widerruf Ihrer bereits erteilten Einwilligung ist jederzeit möglich. Für den Widerruf genügt eine
                        formlose Mitteilung per E-Mail. Die Rechtmäßigkeit der bis zum Widerruf erfolgten Datenverarbeitung
                        bleibt vom Widerruf unberührt.</p>

                    <p><strong>Recht auf Beschwerde bei der zuständigen Aufsichtsbehörde</strong></p>
                    <p>Als Betroffener steht Ihnen im Falle eines datenschutzrechtlichen Verstoßes ein Beschwerderecht bei
                        der
                        zuständigen Aufsichtsbehörde zu. Zuständige Aufsichtsbehörde bezüglich datenschutzrechtlicher Fragen
                        ist
                        der Landesdatenschutzbeauftragte des Bundeslandes, in dem sich der Sitz unseres Unternehmens
                        befindet.
                        Der folgende Link stellt eine Liste der Datenschutzbeauftragten sowie deren Kontaktdaten bereit: <a
                            href="https://www.bfdi.bund.de/DE/Infothek/Anschriften_Links/anschriften_links-node.html"
                            target="_blank">https://www.bfdi.bund.de/DE/Infothek/Anschriften_Links/anschriften_links-node.html</a>.
                    </p>

                    <p><strong>Recht auf Datenübertragbarkeit</strong></p>
                    <p>Ihnen steht das Recht zu, Daten, die wir auf Grundlage Ihrer Einwilligung oder in Erfüllung eines
                        Vertrags automatisiert verarbeiten, an sich oder an Dritte aushändigen zu lassen. Die Bereitstellung
                        erfolgt in einem maschinenlesbaren Format. Sofern Sie die direkte Übertragung der Daten an einen
                        anderen
                        Verantwortlichen verlangen, erfolgt dies nur, soweit es technisch machbar ist.</p>

                    <p><strong>Recht auf Auskunft, Berichtigung, Sperrung, Löschung</strong></p>
                    <p>Sie haben jederzeit im Rahmen der geltenden gesetzlichen Bestimmungen das Recht auf unentgeltliche
                        Auskunft über Ihre gespeicherten personenbezogenen Daten, Herkunft der Daten, deren Empfänger und
                        den
                        Zweck der Datenverarbeitung und ggf. ein Recht auf Berichtigung, Sperrung oder Löschung dieser
                        Daten.
                        Diesbezüglich und auch zu weiteren Fragen zum Thema personenbezogene Daten können Sie sich jederzeit
                        über die im Impressum aufgeführten Kontaktmöglichkeiten an uns wenden.</p>

                    <p><strong>SSL- bzw. TLS-Verschlüsselung</strong></p>
                    <p>Aus Sicherheitsgründen und zum Schutz der Übertragung vertraulicher Inhalte, die Sie an uns als
                        Seitenbetreiber senden, nutzt unsere Website eine SSL-bzw. TLS-Verschlüsselung. Damit sind Daten,
                        die
                        Sie über diese Website übermitteln, für Dritte nicht mitlesbar. Sie erkennen eine verschlüsselte
                        Verbindung an der „https://“ Adresszeile Ihres Browsers und am Schloss-Symbol in der Browserzeile.
                    </p>

                    <p><strong>Server-Log-Dateien</strong></p>
                    <p>In Server-Log-Dateien erhebt und speichert der Provider der Website automatisch Informationen, die
                        Ihr
                        Browser automatisch an uns übermittelt. Dies sind:</p>
                    <ul>
                        <li>Besuchte Seite auf unserer Domain</li>
                        <li>Datum und Uhrzeit der Serveranfrage</li>
                        <li>Browsertyp und Browserversion</li>
                        <li>Verwendetes Betriebssystem</li>
                        <li>Referrer URL</li>
                        <li>Hostname des zugreifenden Rechners</li>
                        <li>IP-Adresse</li>
                    </ul>
                    <p>Es findet keine Zusammenführung dieser Daten mit anderen Datenquellen statt. Grundlage der
                        Datenverarbeitung bildet Art. 6 Abs. 1 lit. b DSGVO, der die Verarbeitung von Daten zur Erfüllung
                        eines
                        Vertrags oder vorvertraglicher Maßnahmen gestattet.</p>

                    <p><strong>Google Web Fonts</strong></p>
                    <p>Unsere Website verwendet Web Fonts von Google. Anbieter ist die Google Inc., 1600 Amphitheatre
                        Parkway,
                        Mountain View, CA 94043, USA.</p>
                    <p>Durch den Einsatz dieser Web Fonts wird es möglich Ihnen die von uns gewünschte Darstellung unserer
                        Website zu präsentieren, unabhängig davon welche Schriften Ihnen lokal zur Verfügung stehen. Dies
                        erfolgt über den Abruf der Google Web Fonts von einem Server von Google in den USA und der damit
                        verbundenen Weitergabe Ihre Daten an Google. Dabei handelt es sich um Ihre IP-Adresse und welche
                        Seite
                        Sie bei uns besucht haben. Der Einsatz von Google Web Fonts erfolgt auf Grundlage von Art. 6 Abs. 1
                        lit.
                        f DSGVO. Als Betreiber dieser Website haben wir ein berechtigtes Interesse an der optimalen
                        Darstellung
                        und Übertragung unseres Webauftritts.</p>
                    <p>Das Unternehmen Google ist für das us-europäische Datenschutzübereinkommen "Privacy Shield"
                        zertifiziert.
                        Dieses Datenschutzübereinkommen soll die Einhaltung des in der EU geltenden Datenschutzniveaus
                        gewährleisten.</p>
                    <p>Einzelheiten über Google Web Fonts finden Sie unter: <a
                            href="https://www.google.com/fonts#AboutPlace:about">https://www.google.com/fonts#AboutPlace:about</a>
                        und weitere Informationen in den Datenschutzbestimmungen von Google: <a
                            href="https://policies.google.com/privacy/partners?hl=de">https://policies.google.com/privacy/partners?hl=de</a>
                    </p>
                    <p><small>Quelle: Datenschutz-Konfigurator von <a href="http://www.mein-datenschutzbeauftragter.de"
                                target="_blank">mein-datenschutzbeauftragter.de</a></small></p>
                </div>
            </section>
        </div>
    </body>
</html>