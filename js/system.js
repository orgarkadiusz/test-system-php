$(document).ready(function() {
	// Zmienne
	var wlaczoneOpcje = 0,
		dzisiaj = new Date(),
		dd = dzisiaj.getDate(),
		mm = dzisiaj.getMonth() + 1,
		yyyy = dzisiaj.getFullYear();
	if(dd < 10) {
		dd = '0' + dd;
	}
	if(mm < 10) {
		mm = '0' + mm;
	}
	dzisiaj = yyyy + '-' + mm + '-' + dd;
	// Funkcje
	// Pierwsza wywoływana funkcja po starcie aplikacji
	function init() {
		$('#navBarRight').load('prawemenu.php');
		$('#navBar').load('menu.php');
		rozmiary();
		zaladujStrone('main', '#maincontent');
	};
	// Funkcja wyliczająca rozmiar okna contentu z paddingiem
	function rozmiary() {
		wysokoscOkna = $(window).height();
		szerokoscOkna = $(window).width();
	};
	// Funkcja do dodatkowego zakodowania danych 
	function code(str) {
		return btoa(str);
	};
	// Funkcja do odkodowania danych
	function decode(str) {
		return atob(str);
	};
	// Funkcja ładująca stronę o danej nazwie
	function zaladujStrone(str, place) {
		str = str.replace(/ą/ig, 'a');
		str = str.replace(/ć/ig, 'c');
		str = str.replace(/ę/ig, 'e');
		str = str.replace(/ł/ig, 'l');
		str = str.replace(/ń/ig, 'n');
		str = str.replace(/ó/ig, 'o');
		str = str.replace(/ś/ig, 's');
		str = str.replace(/ż/ig, 'z');
		str = str.replace(/ź/ig, 'z');
		nazwastr = str.split('_');
		if(nazwastr.length == 1) {
			var strona = 'strony/' + str + '.php';
		}
		else if(nazwastr.length == 2) {
			var strona = 'strony/aplikacje/' + nazwastr[0] + '/' + nazwastr[1] + '.php';
		}
		$(place).css("cursor", "progress");
		$.ajax({
			type: 'POST',
			url: strona,
			dataType: 'html',
			contentType: 'html',
			
			success: function(tresc) {
				$(place).stop().fadeOut(100, function() {
					$(this).empty().html(tresc).css("cursor", "auto");
					setTimeout(function() {}, 0);
				}).fadeIn(200);
			}
			
		});
	};
	// Funkcja ładująca podstronę o danej nazwie
	function zaladujPodstrone(rodzic, str, place) {
		str = str.replace(/ą/ig, 'a');
		str = str.replace(/ć/ig, 'c');
		str = str.replace(/ę/ig, 'e');
		str = str.replace(/ł/ig, 'l');
		str = str.replace(/ń/ig, 'n');
		str = str.replace(/ó/ig, 'o');
		str = str.replace(/ś/ig, 's');
		str = str.replace(/ż/ig, 'z');
		str = str.replace(/ź/ig, 'z');
		str = str.replace(' ', '');
		var strona = 'strony/aplikacje/' + rodzic + '/' + str + '.php';
		$(place).css("cursor", "progress");
		//startload();
		$.ajax({
			type: 'POST',
			url: strona,
			dataType: 'html',
			contentType: 'html',
			
			success: function(tresc) {
				//stopload();
				$(place).stop().fadeOut(100, function() {
					$(this).empty().html(tresc).css("cursor", "auto");
					setTimeout(function() {}, 0);
				}).fadeIn(200);
			}
			
		});
	}
	// Funkcja ładująca stronę ustawien o danej nazwie
	function zaladujStroneUstawien(przycisk, str) {
		if($('#' + przycisk).hasClass('selectedSetting')) {
			$('#' + przycisk).removeClass('selectedSetting');
			$('#' + przycisk + ' > button').removeClass('selectedSetting');
			$('#settingsContent').fadeOut(100, function() {
				$(this).empty();
			});
			$('#settingsContent').hide();
			$('.zakladka.act').show();
			$('#' + przycisk + ' > img').remove();
			$('.navHide').remove();
			$('.settingsHide').remove();
			$('.stopkaHide').remove();
			wlaczoneOpcje = 0;
		}
		else {
			$('#' + przycisk).addClass('selectedSetting');
			$('#' + przycisk + ' > button').addClass('selectedSetting');
			$('#' + przycisk).append('<img id="img" src="/img/activeBackground.svg" />');
			$('#maincontent').hide();
			$('.zakladka').hide();
			$('#navBar').append('<div class=navHide></div>');
			$('#navBarRight').append('<div class=settingsHide></div>');
			$('#stopka').append('<div class=stopkaHide></div>');
			wlaczoneOpcje = 1;
			str = str.replace(/ą/ig, 'a');
			str = str.replace(/ć/ig, 'c');
			str = str.replace(/ę/ig, 'e');
			str = str.replace(/ł/ig, 'l');
			str = str.replace(/ń/ig, 'n');
			str = str.replace(/ó/ig, 'o');
			str = str.replace(/ś/ig, 's');
			str = str.replace(/ż/ig, 'z');
			str = str.replace(/ź/ig, 'z');
			var strona = 'strony/' + str + '.php';
			$("#settingsContent").css("cursor", "progress");
			$.ajax({
				type: 'POST',
				url: strona,
				dataType: 'html',
				contentType: 'html',
				
				success: function(tresc) {
					$('#settingsContent').stop().css({'display': 'block'}).fadeOut(100, function() {
						$(this).html(tresc).css("cursor", "auto");
						setTimeout(function() {}, 0);
					}).fadeIn(200);
				}
				
			});
		}
	}
	// Funkcja logująca
	function zalogujDoAplikacji() {
		var login = code($('#Login').val()),
			haslo = code($('#Password').val());
		$.ajax({
			type: 'POST',
			url: 'php/skrypty/zaloguj.php',
			data: {login: login, haslo: haslo},
			dataType: 'html',
			
			success: function(odp) {
				console.log(odp);
				if(decode(odp) == 'Zalogowano') {
					location.reload();
					zalogowany = decode(odp);
					$('#navBar').empty();
					$('#navBar').load('menu.php');
					$('#navBarRight').load('prawemenu.php');
					zaladujStrone('main');
				}
			}
		});
	}
	// Funkcja do obsługi przycisków prawego Menu
	function praweMenuFix(przycisk, strona) {
		if($('#' + przycisk).hasClass('selectedSetting')) {
			$('#Settings').removeClass('settingsField').empty();
			$('#' + przycisk).removeClass('selectedSetting');
			$('#' + przycisk + ' > button').removeClass('selectedSetting');
			$('#' + przycisk + ' > img').remove();
			wlaczoneOpcje = 0;
		}
		else {
			$('#Settings').addClass('settingsField').html('<h1 style="color: red">TEST</h1>');
			$('#' + przycisk).addClass('selectedSetting');
			$('#' + przycisk + ' > button').addClass('selectedSetting');
			$('#' + przycisk).append('<img id="img" src="/img/activeBackground.svg" />');
			wlaczoneOpcje = 1;
			/*$.ajax({
				type: 'POST',
				url: 'cgi/test.exe',
				
				success: function(wartosc) {
					$('#Settings').append(wartosc);
				}
			});*/
		}
	}
	// Funkcja dodająca animacje ładowania
	function startload() {
		var loading = "<div class='sk-circle'>"
			+ "<div class='sk-circle1 sk-child'></div>"
			+ "<div class='sk-circle2 sk-child'></div>"
			+ "<div class='sk-circle3 sk-child'></div>"
			+ "<div class='sk-circle4 sk-child'></div>"
			+ "<div class='sk-circle5 sk-child'></div>"
			+ "<div class='sk-circle6 sk-child'></div>"
			+ "<div class='sk-circle7 sk-child'></div>"
			+ "<div class='sk-circle8 sk-child'></div>"
			+ "<div class='sk-circle9 sk-child'></div>"
			+ "<div class='sk-circle10 sk-child'></div>"
			+ "<div class='sk-circle11 sk-child'></div>"
			+ "<div class='sk-circle12 sk-child'></div>"
			+ "</div>";
		$(loading).insertBefore('#stopka');
	}
	// Funkcja kasująca animacje ładowania
	function stopload() {
		$('.sk-circle').remove();
	}
	
	// Obsługa delegatów w dokumencie
	$(document)
	//Obsługa przycisku w całym dokumencie, na wszystkich elementach
	.off('click', '*').on('click', '*', function() {
		if($('#rightClickMenu').length != 0) {
			$('#rightClickMenu').remove();
		}
	})
	// naciśnięcie przycisku Zaloguj
	.off('click', '#LogInApplication').on('click', '#LogInApplication', function() {
		zalogujDoAplikacji();
	})
	// obsługa przycisku
	.off('keypress').on('keypress', function(e) {
		// naciśnięcie entera gdy jest na polu login lub hasło
		if(($('#Login').is(':focus') || $('#Password').is(':focus')) && (e.which == 13)) {
			zalogujDoAplikacji();
		}
	})
	// obsługa tooltipów
	.off('focus', 'input').on('focus', 'input', function() {
		if(typeof $(this).attr('tooltip') != typeof undefined && $(this).attr('tooltip').length != 0) {
			var kierunek = $(this).attr('tooltip'), tooltip = '';
			tooltip = "<span id='tooltip' class='tooltip" + kierunek + "'>" + $(this).attr('tooltiptext') + "</span>";
			if($('*').find('#tooltip').length != 0) {
				$('#tooltip').remove();
				$(this).parent('div').append(tooltip);
			}
			else {
				$(this).parent('div').append(tooltip);
			}
		}
		else {
			$('#tooltip').remove();
		}
		
	})
	// wyłączenie focusa
	.off('focusout', 'input').on('focusout', 'input', function() {
		if(typeof $('#tooltip') != typeof undefined && $('#tooltip').length != 0) {
			$('#tooltip').remove();
		}
	})
	// Focus na kalendarz
	.off('focus', '[data-toggle="datepicker"]').on('focus', '[data-toggle="datepicker"]', function() {
		$(this).datepicker();
	})
	// Event kliknięcia Loga na pasku głównym
	.off('click', '#navLogo #Logo').on('click', '#navLogo #Logo', function() {
		if($('#maincontent').is(':visible')) {
			$('#maincontent').empty();
			zaladujStrone('main', '#maincontent');
		}
		else {
			$('.zakladka').hide().removeClass('act');
			$('#maincontent').show().addClass('act');
		}
	})
	// Kliknięcie przycisku w pasku nawigacyjnym uruchamia stronę o takiej nazwie
	.off('click', '#navLeft .navBtn').on('click', '#navLeft .navBtn', function() {
		if($(this).parent('div').hasClass('navDrop')) {
			var id = $(this).parent('div').attr('id'), podstrona = 'N';
		}
		else if($(this).parent('div').hasClass('dropZaw')) {
			var id = $(this).parent('div').parent('.navDrop').attr('id'), podstrona = 'T';
			var rodzic = $(this).parent('div').parent('div.navDrop').attr('app');
		}
		if(!$('div.' + id).is(':visible')) {
			$('#maincontent').hide();
			$('.zakladka').hide().removeClass('act');
			$('div.' + id).show().addClass('act');
		}
		else {
			if($('#maincontent').is(':visible')) {
				$('#maincontent').hide();
			}
			if(!$(this).hasClass('zamknijApp')) {
				if(podstrona == 'N') {
					zaladujStrone($(this).text().toLowerCase(), 'div.' + id);
				}
				else if(podstrona == 'T') {
					zaladujPodstrone(rodzic, $(this).text().toLowerCase(), 'div.' + id);
				}
			}
		}
	})
	// Prawe menu click na #ToDoList
	.off('click', '#ToDoList').on('click', '#ToDoList', function() {
		$.ajax({
			url: 'js/todolist.js',
			dataType: 'script',
			
			success: function() {
				zaladujStroneUstawien('ToDoList', 'ToDoList'.toLowerCase());
			}
		});
	})
	// Prawe menu click na #Informacje
	.off('click', '#Informacje').on('click', '#Informacje', function() {
		zaladujStroneUstawien(this.id, (this.id).toLowerCase());
	})
	// Prawe menu click na #Zgloszenia
	.off('click', '#Zgloszenia').on('click', '#Zgloszenia', function() {
		zaladujStroneUstawien(this.id, (this.id).toLowerCase());
	})
	// Prawe menu click i aktywowanie/deaktywowanie #Czat
	.off('click', '#Czat').on('click', '#Czat', function() {
		if($(this).hasClass('active')) {
			$(this).removeClass('active');
			$(this).removeClass('selectedSetting');
			$('button', this).removeClass('selectedSetting');
			$('img', this).remove();
		}
		else {
			$(this).addClass('active');
			$(this).addClass('selectedSetting');
			$('button', this).addClass('selectedSetting');
			$(this).append('<img id="img" src="/img/activeBackground.svg" />');
		}
	})
	// Prawe menu click na #Kalendarz
	.off('click', '#Kalendarz').on('click', '#Kalendarz', function() {
		zaladujStroneUstawien(this.id, (this.id).toLowerCase());
	})
	// Prawe menu click na #Aplikacje
	.off('click', '#Aplikacje').on('click', '#Aplikacje', function() {
		zaladujStroneUstawien(this.id, (this.id).toLowerCase());
	})
	// Prawe menu click na #Uzytkownicy
	.off('click', '#Uzytkownicy').on('click', '#Uzytkownicy', function() {
		zaladujStroneUstawien(this.id, (this.id).toLowerCase());
	})
	// Prawe menu click na #Dostepy
	.off('click', '#Dostepy').on('click', '#Dostepy', function() {
		zaladujStroneUstawien(this.id, (this.id).toLowerCase());
	})
	// Prawe menu click na #Wyposazenie
	.off('click', '#Wyposazenie').on('click', '#Wyposazenie', function() {
		zaladujStroneUstawien(this.id, (this.id).toLowerCase());
	})
	// Prawe menu click na #Ustawienia
	.off('click', '#Ustawienia').on('click', '#Ustawienia', function() {
		praweMenuFix(this.id, 'test');
	})
	// Prawe menu click na #Pomoc
	.off('click', '#Pomoc').on('click', '#Pomoc', function() {
		var info = "<div id='infoKursor'></div>";
		if($(this).hasClass('active')) {
			$(this).removeClass('active');
			$(this).removeClass('selectedSetting');
			$('button', this).removeClass('selectedSetting');
			$('img', this).remove();
			$('#infoKursor').remove();
		}
		else {
			$('body').append(info);
			$(this).addClass('active');
			$(this).addClass('selectedSetting');
			$('button', this).addClass('selectedSetting');
			$(this).append('<img id="img" src="/img/activeBackground.svg" />');
		}
	})
	// Prawe menu click na #LogOutApplication
	.off('click', '#LogOutApplication').on('click', '#LogOutApplication', function() {
		$.ajax({
			type: 'POST',
			url: 'php/skrypty/wyloguj.php',
			
			success: function() {
				location.reload(true);
			}
		});
	})
	// Śledzenie ruchu myszki - wejście na element
	.off('mousemove', '*').on('mousemove', '*', function(e) {
		// Jeśli element posiada atrybut info i przycisk Pomoc jest aktywny pokazuj dodatkowe informacje
		if((typeof $(this).attr('info') !== typeof undefined) && ($(this).attr('info') !== false) && ($('#Pomoc').hasClass('active'))) {
			if((e.pageX <= (szerokoscOkna / 2)) && (e.pageY <= (wysokoscOkna * 0.7))) {
				$('#infoKursor').text($(this).attr('info'));
				$('#infoKursor').fadeIn(100).css({'display': 'block', 'left': e.pageX + 13, 'top': e.pageY + 17, 'right': 'unset', 'bottom': 'unset'});
			}
			else if((e.pageX > (szerokoscOkna / 2)) && (e.pageY <= (wysokoscOkna * 0.7))) {
				$('#infoKursor').text($(this).attr('info'));
				var szerokosc = $('#infoKursor').width();
				$('#infoKursor').fadeIn(100).css({'display': 'block', 'left': 'unset', 'top': e.pageY + 17, 'right': (szerokoscOkna - e.pageX), 'bottom': 'unset'});
			}
			else if((e.pageX <= (szerokoscOkna / 2)) && (e.pageY > (wysokoscOkna * 0.7))) {
				$('#infoKursor').text($(this).attr('info'));
				var wysokosc = $('#infoKursor').height() + 7;
				$('#infoKursor').fadeIn(100).css({'display': 'block', 'left': e.pageX + 13, 'top': 'unset', 'right': 'unset', 'bottom': (wysokoscOkna - e.pageY + 7)});
			}
			else if((e.pageX > (szerokoscOkna / 2)) && (e.pageY > (wysokoscOkna * 0.7))) {
				$('#infoKursor').text($(this).attr('info'));
				$('#infoKursor').fadeIn(100).css({'display': 'block', 'left': 'unset', 'top': 'unset', 'right': (szerokoscOkna - e.pageX), 'bottom': (wysokoscOkna - e.pageY + 7)});
			}
		}
		// Jeśli użytkownik zalogowany pokazuj prawe menu
		if(zalogowany == 'Zalogowano') {
			if(e.pageX >= (szerokoscOkna - 5) && (wlaczoneOpcje == 0)) {
				if(!$('#navBarRight').is(':animated')) {
					$('#navBarRight').animate({'width': '40px'}, 500, 'linear');
				}
			}
			if((e.pageX < (szerokoscOkna - 41)) && ($('#navBarRight').width() > 0) && (wlaczoneOpcje == 0)) {
				if(!$('#navBarRight').is(':animated')) {
					$('#navBarRight').animate({'width': '0px'}, 500, 'linear');
				}
			}
		}
	})
	// Śledzenie ruchu myszki - wyjście z elementu
	.off('mouseleave', '*').on('mouseleave', '*', function() {
		$('#infoKursor').css({'display': 'none'});
	})
	// Obsługa prawego przycisku myszki
	.off('contextmenu', '*').on('contextmenu', '*', function(e) {
		//e.preventDefault();
		var RCM = "<div id='rightClickMenu'><hr><button class='btn usunClickMenu'>Anuluj</button></div>";
		if((typeof $(this).attr('opcjeRCM') !== typeof undefined) && ($(this).attr('opcjeRCM') !== false) && ($('#rightClickMenu').length == 0)) {
			e.preventDefault();
			$('body').append(RCM);
			var id = $(this).parent().attr('id');
			var przyciski = $(this).attr('opcjeRCM');
			var opcja = przyciski.split(',');
			var opcje = '';
			for(var i = 0; i < opcja.length; i++) {
				var tmpstring = opcja[i].toLowerCase();
				tmpstring = tmpstring.replace(/ą/ig, 'a');
				tmpstring = tmpstring.replace(/ć/ig, 'c');
				tmpstring = tmpstring.replace(/ę/ig, 'e');
				tmpstring = tmpstring.replace(/ł/ig, 'l');
				tmpstring = tmpstring.replace(/ń/ig, 'n');
				tmpstring = tmpstring.replace(/ó/ig, 'o');
				tmpstring = tmpstring.replace(/ś/ig, 's');
				tmpstring = tmpstring.replace(/ż/ig, 'z');
				tmpstring = tmpstring.replace(/ź/ig, 'z');
				opcje += "<button class='btn " + tmpstring + "' value='" + id + "'>" + opcja[i] + "</button>";
			}
			$(opcje).insertBefore('#rightClickMenu hr');
			if((e.pageX <= (szerokoscOkna * 0.7)) && (e.pageY <= (wysokoscOkna * 0.7))) {
				$('#rightClickMenu').css({'left': e.pageX + 5, 'top': e.pageY + 5, 'right': 'unset', 'bottom': 'unset'});
			}
			else if((e.pageX > (szerokoscOkna * 0.7)) && (e.pageY <= (wysokoscOkna * 0.7))) {
				$('#rightClickMenu').css({'left': 'unset', 'top': e.pageY + 5, 'right': (szerokoscOkna - e.pageX), 'bottom': 'unset'});
			}
			else if((e.pageX <= (szerokoscOkna * 0.7)) && (e.pageY > (wysokoscOkna * 0.7))) {
				$('#rightClickMenu').css({'left': e.pageX + 5, 'top': 'unset', 'right': 'unset', 'bottom': (wysokoscOkna - e.pageY + 5)});
			}
			else if((e.pageX > (szerokoscOkna * 0.7)) && (e.pageY > (wysokoscOkna * 0.7))) {
				$('#rightClickMenu').css({'left': 'unset', 'top': 'unset', 'right': (szerokoscOkna - e.pageX), 'bottom': (wysokoscOkna - e.pageY + 5)});
			}
		}
	})
	// Kliknięcie na przycisk rejestracji
	.off('click', '#ZarejestrujSie').on('click', '#ZarejestrujSie', function() {
		zaladujStrone('rejestracjaUzytkownika', '#maincontent');
	})
	// Obsługa formularza rejestracji
	.off('input', '.poleRejestracji input').on('input', '.poleRejestracji input', function() {
		if($(this).attr('id') == 'rejImie' || $(this).attr('id') == 'rejNazwisko') {
			var warunek = /^[A-ZĄĆĘŁŃÓŚŻŹ]{1}[a-ząćęłńóśżź]{2,}\S*$/;
		}
		if($(this).attr('id') == 'rejLogin') {
			var warunek = /^[a-z0-9]{4,}\S*$/i;
		}
		if($(this).attr('id') == 'rejEmail') {
			var warunek = /^[0-9a-zA-Z_.-]+@[0-9a-zA-Z.-]+\.[a-zA-Z]{2,3}$/;
		}
		if(warunek.test($(this).val())) {
			if(!$(this).parent().find('.accepted').length) {
				$("<div class='accepted'>&#10004;</div>").insertAfter($(this));
			}
		}
		else {
			if($(this).parent().find('.accepted').length) {
				$(this).next('div.accepted').remove();
			}
		}
		if($('.poleRejestracji').find('.accepted').length == 4 && $('#rejRodo').is(':checked')) {
			$('#Rejestracja').removeAttr('disabled');
		}
		else {
			$('#Rejestracja').attr('disabled', true);
		}
	})
	// Kliknięcie akceptacji rodo
	.off('change', '#rejRodo').on('change', '#rejRodo', function() {
		if($('.poleRejestracji').find('.accepted').length == 4 && $('#rejRodo').is(':checked')) {
			$('#Rejestracja').removeAttr('disabled');
		}
		else {
			$('#Rejestracja').attr('disabled', true);
		}
	})
	// Kliknięcie przycisku zarejestruj
	.off('click', '#Rejestracja').on('click', '#Rejestracja', function() {
		var imieR = $('#rejImie').val(),
			nazwiskoR = $('#rejNazwisko').val(),
			loginR = code($('#rejLogin').val()),
			emailR = $('#rejEmail').val();
		
		$('#maincontent').css({'cursor': 'wait'});
		$.ajax({
			type: 'POST',
			url: 'php/skrypty/rejestracja.php',
			data: {imie: imieR, nazwisko: nazwiskoR, login: loginR, email: emailR},
			dataType: 'html',
			
			success: function(problem) {
				var info = problem.split(';'),
					problemalert = "<div class='problema'><div>" + info[1] + "</div></div>",
					sukcesalert = "<div class='sukcesa'><div>" + info[1] + "</div></div>";
				$('#maincontent').css({'cursor': 'default'});
				if(info[0] == 'error') {
					$('#rejestracjaUzytkownika').next().remove();
					$(problemalert).insertAfter('#rejestracjaUzytkownika');
				}
				else if(info[0] == 'zarejestrowano') {
					$('#rejestracjaUzytkownika').next().remove();
					$(sukcesalert).insertAfter('#rejestracjaUzytkownika');
					$('.mamkod').css({'color': 'rgb(50, 255, 50)'});
				}
			}
		})
	})
	// Kliknięcie spana mam kod
	.off('click', '.mamkod').on('click', '.mamkod', function() {
		$(this).css({'color': 'rgb(50, 50, 255)'});
		var kod = "<div id='mamkod' class='sprawdzkod'><input name='potwlogkod' placeholder='Login' type='text' /><input name='potwkodkod' placeholder='Kod' type='text'/><button id='potwkod' class='btn sukces'>Potwierdź</button>";
		if($('#mamkod').length != 0) {
			$('#mamkod').remove();
			$('#rejestracjaUzytkownika').next().remove();
			$('#maincontent').append(kod);
			var szer = $('#mamkod').width();
			if(Math.round($('#mamkod').width()) >= szer) {
				$('#mamkod').width(Math.round($('#mamkod').width()));
				$('#mamkod').css({'margin-left': 'calc(50% - ' + (Math.round($('#mamkod').width()) / 2) + 'px)'});
			}
			else {
				$('#mamkod').width(Math.round($('#mamkod').width()) + 1);
				$('#mamkod').css({'margin-left': 'calc(50% - ' + ((Math.round($('#mamkod').width()) + 1) / 2) + 'px)'});
			}
		}
		else {
			$('#maincontent').append(kod);
			var szer = $('#mamkod').width();
			if(Math.round($('#mamkod').width()) >= szer) {
				$('#mamkod').width(Math.round($('#mamkod').width()));
				$('#mamkod').css({'margin-left': 'calc(50% - ' + (Math.round($('#mamkod').width()) / 2) + 'px)'});
			}
			else {
				$('#mamkod').width(Math.round($('#mamkod').width()) + 1);
				$('#mamkod').css({'margin-left': 'calc(50% - ' + ((Math.round($('#mamkod').width()) + 1) / 2) + 'px)'});
			}
		}
	})
	// Potwierdzenie otrzymanego kodu rejestracji
	.off('click', '#potwkod').on('click', '#potwkod', function() {
		var login = code($(this).parent().find('[name="potwlogkod"]').val()),
			kod = code($(this).parent().find('[name="potwkodkod"]').val());
		$.ajax({
			type: 'POST',
			url: 'strony/zmienhaslo.php',
			data: {login: login, kod: kod},
			dataType: 'html',
			
			success: function(zwrotka) {
				var zmienhaslo = zwrotka.split(';;'),
					problemalert = "<div class='problema'><div>" + zmienhaslo[1] + "</div></div>",
					sukcesalert = "<div class='sukcesa'><div>" + zmienhaslo[1] + "</div></div>";
				$('#maincontent').css({'cursor': 'default'});
				if(zmienhaslo[0] == 'error') {
					$('#mamkod').next().remove();
					$(problemalert).insertAfter('#mamkod');
				}
				else if(zmienhaslo[0] == 'poprawne') {
					$('#maincontent').empty().append(zmienhaslo[1]);
				}
			}
		})
	})
	// Filtracja pola z nowym hasłem
	.off('input', '#zmienhaslo .haslo[name="nowehaslo"]').on('input', '#zmienhaslo .haslo[name="nowehaslo"]', function() {
		var warunek = /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\!\@\#\$\%\^\&\*\(\)\-\_\=\+\\\:\;\'\"\|\,\.\/\?\<\>\[\]\{\}\`\~])(?!=.*\s).{6,}$/;
		if(warunek.test($(this).val())) {
			if(!$(this).parent().find('.accepted').length) {
				$("<div class='accepted'>&#10004;</div>").insertAfter($(this));
			}
		}
		else {
			if($(this).parent().find('.accepted').length) {
				$(this).next('div.accepted').remove();
			}
		}
		if($('#zmienhaslo').find('.accepted').length == 2) {
			if(!$('#ZmienHaslo').hasClass('sukces')) {
				$('#ZmienHaslo').removeAttr('disabled').removeClass('uwaga').addClass('sukces');
			}
		}
		else {
			if(!$('#ZmienHaslo').hasClass('uwaga')) {
				$('#ZmienHaslo').attr('disabled', true).removeClass('sukces').addClass('uwaga');
			}
		}
	})
	// Filtracja pola z powtorzonym nowym hasłem
	.off('input', '#zmienhaslo .haslo[name="nowepowthaslo"]').on('input', '#zmienhaslo .haslo[name="nowepowthaslo"]', function() {
		if($(this).val() == $('.haslo[name="nowehaslo"]').val() && $('.haslo[name="nowehaslo"]').parent().find('.accepted').length) {
			$("<div class='accepted'>&#10004;</div>").insertAfter($(this));
		}
		else {
			$(this).next('div.accepted').remove();
		}
		if($('#zmienhaslo').find('.accepted').length == 2) {
			if(!$('#ZmienHaslo').hasClass('sukces')) {
				$('#ZmienHaslo').removeAttr('disabled').removeClass('uwaga').addClass('sukces');
			}
		}
		else {
			if(!$('#ZmienHaslo').hasClass('uwaga')) {
				$('#ZmienHaslo').attr('disabled', true).removeClass('sukces').addClass('uwaga');
			}
		}
	})
	// Klikniecie akceptacji przy zmianie/ustawianiu hasła
	.off('click', '#ZmienHaslo').on('click', '#ZmienHaslo', function() {
		if($(this).hasClass('sukces') && !$(this).prop('disabled')) {
			if($('.haslo[name="nowepowthaslo').val() == $('.haslo[name="nowehaslo"]').val()) {
				var haslo = code($('.haslo[name="nowehaslo"]').val()),
					login = code($('input[name="login"]').val()),
					kod = $('input[name="kod"]').val();
				
				if(zalogowany == 'zalogowano') {
					$.ajax({
						type: 'POST',
						url: 'php/skrypty/zmienhaslo.php',
						data: {login: login, kod: kod, haslo: haslo},
						dataType: 'html',
						
						success: function(komunikat) {
							
						}
					})
				}
				else {
					$.ajax({
						type: 'POST',
						url: 'php/skrypty/zarejestruj.php',
						data: {login: login, kod: kod, haslo: haslo},
						dataType: 'html',
						
						success: function(komunikat) {
							var rejestracja = komunikat.split(';;'),
								problemalert = "<div class='problema'><div>" + rejestracja[1] + "</div></div>",
								sukcesalert = "<div class='sukcesa'><div>" + rejestracja[1] + "</div></div>";
							$('#maincontent').css({'cursor': 'default'});
							if(rejestracja[0] == 'error') {
								$('#zmienhaslo').next().remove();
								$(problemalert).insertAfter('#zmienhaslo');
							}
							else if(rejestracja[0] == 'poprawne') {
								$('#zmienhaslo').next().remove();
								$(sukcesalert).insertAfter('#zmienhaslo');
							}
						}
					})
				}
			}
		}
	})
	// Kliknięcie Anuluj w formularzu #editField
	.off('click', '#editField .anuluj').on('click', '#editField .anuluj', function() {
		$(this).parent().parent().css({'display': 'none', 'left': 'unset', 'top': 'unset', 'right': 'unset', 'bottom': 'unset'})
			.find('.cialoFormularza').empty()
			.find('.naglowekFormularza').empty();
	})
	// Kliknięcie na przycisk w menu głównym
	.off('click', '.mainaplikacje').on('click', '.mainaplikacje', function() {
		var id = $(this).attr('id'), licznik = 0;
		licznik = $('#navLeft button.' + id).length + 1;
		
		var menubutton = "<div id=" + id + licznik + " app=" + id + " class='navDrop'><button class='navBtn " + id + "'>" + id + "</button>";
		$('#maincontent').hide();
		$('.zakladka').hide().removeClass('act');
		$("<div class='zakladka " + id + licznik + " act'></div>").insertBefore('#stopka').show();
		
		$.ajax({
			url: 'js/' + id.toLowerCase() +'.js',
			dataType: 'script'
		});
		
		$.ajax({
			type: 'POST',
			url: 'php/skrypty/pobierzDostepneModuly.php',
			data: {aplikacja: id},
			dataType: 'html',
			
			success: function(moduly) {
				var jakieModuly = "<div class='dropZaw'>", dlugosc = 0, tmpdlugosc = 0;
				if(moduly != '') {
					var modul = moduly.split(';');
					for(var i = 0; i < modul.length; i++) {
						var wartosc = modul[i].split(','), nazwa = wartosc[0], dostep = wartosc[1];
						if(dostep != 'Brak' && typeof dostep != typeof undefined) {
							jakieModuly += "<button class='navBtn'>" + nazwa + "</button>";
						}
					}
					jakieModuly += "<hr><button idapp=" + id + licznik + " class='navBtn zamknijApp'>Zamknij</button></div>";
					menubutton += jakieModuly;
					menubutton += "</div>";
				}
				else {
					menubutton += "</div>";
				}
				$('#navLeft').append(menubutton);
				dlugosc = $('#navLeft #' + id + licznik).width();
				tmpdlugosc = Math.round(dlugosc);
				if(tmpdlugosc < dlugosc) {
					tmpdlugosc += 1;
					$('#navLeft #' + id + licznik).width(tmpdlugosc).children('button.' + id).width(tmpdlugosc - 16);
					$('#navLeft #' + id + licznik).children('div.dropZaw').css({'min-width': tmpdlugosc});
				}
				else {
					$('#navLeft #' + id + licznik).width(tmpdlugosc).children('button.' + id).width(tmpdlugosc - 16);
					$('#navLeft #' + id + licznik).children('div.dropZaw').css({'min-width': tmpdlugosc});
				}
				zaladujStrone(id.toLowerCase(), 'div.' + id + licznik);
			}
		})
	})
	// Przycisk zamknięcia aplikacji
	.off('click', '.zamknijApp').on('click', '.zamknijApp', function() {
		var id = $(this).attr('idapp');
		$('*').remove('#' + id);
		$('*').remove('.' + id);
		$('#maincontent').show();
	})
	// Przycisk anuluj form kasujący formularz
	.off('click', '.anulujform').on('click', '.anulujform', function() {
		$(this).parents('div.formularz').removeClass('formularz');
		$(this).parents('.formdiv').find('input').val('');
		$(this).parents('.formdiv').find('input[name="datawprowadzana"]').val(dzisiaj);
		$(this).parents('.formdiv').find('[wartosc]').attr('wartosc', '');
		$(this).parents('.formdiv').find('label').html('<span>Dołącz plik</span>');
		$(this).parents('.formdiv').find('.zalacznik').not('#zalacznik').next('label').remove();
		$(this).parents('.formdiv').find('.zalacznik').not('#zalacznik').next('.remove').remove();
		$(this).parents('.formdiv').find('.zalacznik').not('#zalacznik').remove();
		$(this).parents('.formdiv').find('.checkBoxForm').remove();
		$('.background').remove();
	})
	// Kliknięcie przycisku edit z klasą edit
	.off('click', '.edit').on('click', '.edit', function() {
		var formularz = $(this).attr('editing').replace(/[0-9]+/, ''),
			id = $(this).attr('editing').replace(/[a-z]+/i, ''),
			funkcja = formularz.concat('edit'),
			karta = $(this).parents('.zakladka.act').attr('class').replace('zakladka', '').replace('act', '').replace(' ', '');
		window[funkcja](karta, id);
		$('body').append("<div class='background'></div>");
		$('.' + karta + ' .' + formularz + 'edit').addClass('formularz');
	})
	// Dodawanie załączników
	.off('change', '.inputfile').on('change', '.inputfile', function(e) {
		var $label	 = $(this).next('label'),
			labelVal = $label.html(),
			fileName = '';

		if(this.files && this.files.length > 1) {
			fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
		}
		else if(e.target.value) {
			fileName = e.target.value.split( '\\' ).pop();
		}

		if(fileName) {
			$label.find('span').html(fileName);
		}
		else {
			$label.html(labelVal);
		}
	})
	// Dodawanie inputów do załączników
	.off('click', '.dodajzalacznik').on('click', '.dodajzalacznik', function() {
		var id = Number($(this).parents('.cialoFormularza').find('.zalacznik').last().attr('id').replace(/[a-z]+/i, '')) + 1,
			input = "<input id='zalacznik" + id + "' name='zalacznik' type='file' class='inputfile zalacznik'><label for='zalacznik" + id + "'><span>Dołącz plik</span></label><span skasuj='zalacznik" + id + "' class='btn uwaga remove'>-</span>";
		$(input).insertBefore($(this));
	})
	// Kasowanie zalacznika
	.off('click', '.remove').on('click', '.remove', function() {
		var doskasowania = $(this).attr('skasuj'),
			skasowane = '';
		if($(this).parents('.cialoFormularza').find('input[name="skasowanezalaczniki"]').length) {
			skasowane = $(this).parents('.cialoFormularza').find('input[name="skasowanezalaczniki"]').val();
		}
		skasowane = skasowane.concat($('#' + $(this).attr('skasuj')).next('label').text());
		skasowane = skasowane.concat(';;,');
		$('#' + $(this).attr('skasuj')).next('label').remove();
		$('#' + $(this).attr('skasuj')).remove();
		$(this).parents('.cialoFormularza').find('input[name="skasowanezalaczniki"]').val(skasowane);
		$(this).remove();
	})
	

	// Wywołania funkcji po załadowaniu strony {
	init();
	
	// Eventy
	// Zmiana rozmiaru okna
	$(window).resize(function() {
		wysokoscOkna = $(window).height();
		szerokoscOkna = $(window).width();
	});
	// }
	
});