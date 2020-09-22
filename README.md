# test-system-php - Projekt testowy
> System zaczął powstawać jako odpowiedź na potrzeby których system ERP nie spełniał.
> Funkcjonalność miała obejmować większość aspektów, które były robione ręcznie i pomagać w organizacji firmy.
> Był tworzony w wolnych chwilach więc udało się zrobić tylko szkielet programu i wstępny interfejs użytkownika.

## Technologie użyte w programie
* PHP - głównie strukturalne
* jQuery - dołączony plik w wersji 3.3.1
* MySQL
* Node.js - było w planach żeby utworzyć czat
* ODBC - połączenie do systemu ERP i odczytywanie informacji poprzez zapytania
* HTML i CSS - interfejs użytkownika

## Instalacja
Do uruchomienia programu może posłużyć dowolny serwer apache (xampp/wamp/lamp) oraz baza danych MySQL (MariaDB/Oracle)
1. Cały projekt wypakować do folderu na serwerze
2. W pliku .htaccess ustawić ścieżkę do folderu (php_value include_path)
3. W bazie danych utworzyć bazę danych (system) i zaimportować tą znajdującą się w folderze 'baza/system.sql'
4. W przypadku zajętej nazwy bazy danych lub zmienionych danych logowania zedytowac plik 'php/dane/dane.php'

## Dodatki
W programie użyte są moduły zewnętrzne takie jak
* PHPMailer - do wysyłania i odbierania maili
* PHPPDF - PHP'owy moduł tcpdf do tworzenia PDF'ów

## Status
Projekt nie jest kontynuowany.

## Autor
Arkadiusz Orgaś -  org.arkadiusz@gmail.com
