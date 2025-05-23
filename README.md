README - Robocorns-site de prezentare
Descriere:
Acest proiect este un o aplicatie web dezvoltată în limbaje de programare specifice folosind biblioteca PHPMailer. Proiect realizat și dezvoltat de la "zero" de Mihali Andrei.
Scop:
Scopul acestui proiect este promovarea echipei de robotică Robocorns prin realizarea unui site web interactiv, modern și ușor de utilizat. Platforma oferă informații despre echipă, activitățile desfășurate și participările la competiții, punând accent pe vizibilitatea și popularizarea echipei în rândul comunității STEAM(Science, Tehnology, Engineering, Art, Math).
 Functionalități ale site-ului Robocorns
-Pagini Publice
 Home – Prezentare generală a echipei și proiectului

 Sponsor Us – Listă sponsori + call-to-action pentru sponsorizări

 AkinaCorns - un mic joculeț care creează legături între echipele care participă in FTC

 Team – Pagina membrilor echipei, cu roluri și biografii

 Funcționalități Admin (Backend)
 Autentificare admin (PHP + MySQL)

 Adăugare, ștergere și editare:

Membri (nume, rol, imagine, descriere)

Sezoane (an, nume, descriere, imagini)

Sponsori (nume, logo, site, nivel sponsorizare)

 Upload imagini securizat (cu validare extensii)

 Validări server-side și client-side

 Extra (pentru experiență completă)
 Toggle Dark/Light Mode

 Design responsive (mobil-friendly)

 Slider/galerie imagini pentru robot & echipă

Cum se utilizează:
    Adaugati in folderul htdocs/ al unui hosting ce suportă atat PHP cât și MySql, iar in folderul data/ salvați baza de date aferentă siteului.
    Deschideti http://localhost/Ro-004/ sau adresa hostului public.

    Navigare
    Meniul include paginile: Acasă, Galerie, Despre noi, Contact și Autentificare.

    Autentificare
    Adminul înregistrat poate accesa un panou de administrare pentru a adăuga, edita sau șterge conținut (CRUD).

    Formular de contact
    Oricine poate trimite un mesaj prin formular, care ajunge prin email folosind PHPMailer.

    Validări
    Client-side: JavaScript (ex: verificare câmpuri completate)

    Server-side: PHP (ex: email valid, parolă minim 8 caractere)
Structura fișierelor:
/ (rădăcina proiectului)
│
├── index.php            
├── sponsoris.php        
├── akinacorns.php        
├── team.php              
│
├── /css               
│   ├ akinacorns.css 
│   ├ footer.css
│   ├ index.css
│   ├ sponsori.css
│   ├ team.css
│   ├── /script               
│   └── /inuse            
│
├── /admin 
│   ├ css.css
│   ├ team.css
│   ├── /script               
│   └── /inuse    
│
├── /includes             
│   ├── /PHPMailer            - Bibliotecă pentru trimiterea emailurilor
│   │ ├── PHPMailer.php     - Clasa principală PHPMailer
│   │ ├── SMTP.php          - Suport pentru trimitere prin SMTP
│   │ └── Exception.php     - Gestionarea erorilor PHPMailer
│   ├──/navbar.php
│   ├──/footer.php
│   └──/mail.php
Autori:
 - Elev: Mihali Andrei-Sebastian
 - Profesori coordonatori:
    - Maidan Alin prof. Informatică
    - Mureșan Ioana Claudia prof. Informatică

            Bibliografie:
                W3schools: https://www.w3schools.com/php/
                Learncodeacadamey: https://www.youtube.com/@learncodeacademy
                Danikrossing: https://www.youtube.com/playlist?list=PL0eyrZgxdwhwwQQZA79OzYwl5ewA7HQih
                Funda of Web IT: https://www.youtube.com/playlist?list=PLRheCL1cXHrvOzRYgiV8qOz8j_dCzffvK
                Traian Anghel :Programarea în PHP ghid practic

            Inspirație și conținut:
                Datele altor echipe: https://ftcscout.org/events/2024/RONLT/rankings
                Site Peppers: https://www.peppers-robotics.ro/
                Site Alphatronic: https://www.alphatronic.ro/
                Site Tech-X: https://tech-x.ro/, https://github.com/Tech-X-CNDV/codWebsite
                Codepen.io: https://codepen.io/ramzibach-the-styleful/pen/LYoYejb   
                


Licență: 
Acest proiect este realizat în scop educațional și este protejat de drepturile de autor. Toate drepturile rezervate.