$(document).ready(function() {
	var dzisiaj = new Date(),
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
	$(document)
	// Klik na dodanie wysylki w Dzienniku Wysylek
	.off('click', '.appnav .glowny').on('click', '.appnav .glowny', function() {
		var id = $(this).attr('id'),
			karta = $(this).parents('.zakladka.act').attr('class').replace('zakladka', '').replace('act', '').replace(' ', '');
		$('body').append("<div class='background'></div>");
		$('.' + karta + ' .' + id).addClass('formularz');
		$.ajax({
			type: 'POST',
			url: 'php/ajax/eSekretariat/pobierzAdresatow.php',
			dataType: 'html',
			
			success: function(opcje) {
				$('#adresaci').empty().append(opcje);
				$('#nadawcy').empty().append(opcje);
			}
		});
		$.ajax({
			type: 'POST',
			url: 'php/ajax/eSekretariat/pobierzTypyNadania.php',
			dataType: 'html',
			
			success: function(opcje) {
				$('#typynadania').empty().append(opcje);
			}
		});
		$.ajax({
			type: 'POST',
			url: 'php/ajax/eSekretariat/pobierzDzialy.php',
			dataType: 'html',
			
			success: function(opcje) {
				$('#dzialy').empty().append(opcje);
			}
		});
	})
	// Klik na zapisanie nowej wysylki
	.off('click', '#esekretariatDziennikWysylekDodajNowa').on('click', '#esekretariatDziennikWysylekDodajNowa', function() {
		var przycisk = $(this),
			adresat = $.trim($(this).parents('.formdiv').find('[name="adresat"]').val()),
			nazwaadresata = $.trim($(this).parents('.formdiv').find('[name="nazwaadresata"]').val()),
			ulica = $.trim($(this).parents('.formdiv').find('[name="ulica"]').val()),
			numer = $.trim($(this).parents('.formdiv').find('[name="numer"]').val()),
			kodpocztowy = $.trim($(this).parents('.formdiv').find('[name="kod"]').val()),
			miasto = $.trim($(this).parents('.formdiv').find('[name="miasto"]').val()),
			temat = $.trim($(this).parents('.formdiv').find('[name="temat"]').val()),
			data = $.trim($(this).parents('.formdiv').find('[name="datawprowadzana"]').val()),
			typnadania = $.trim($(this).parents('.formdiv').find('[name="typnadania"]').attr('wartosc')),
			typ = $.trim($(this).parents('.formdiv').find('[name="typnadania"]').val()),
			plik = new FormData();
			
		plik.append('adresat', adresat);
		plik.append('nazwaadresata', nazwaadresata);
		plik.append('ulica', ulica);
		plik.append('numer', numer);
		plik.append('kodpocztowy', kodpocztowy);
		plik.append('miasto', miasto);
		plik.append('temat', temat);
		plik.append('data', data);
		plik.append('typnadania', typnadania);
		plik.append('typ', typ);
		$('.esekretariatDziennikWysylekDodaj .formdiv .zalacznik').each(function() {
			plik.append('zalacznik[]', $(this).prop('files')[0]);
		})
		$.ajax({
			type: 'POST',
			contentType: false,
			processData: false,
			url: 'php/ajax/eSekretariat/dodajWysylke.php',
			data: plik,
			dataType: 'html',
			
			success: function(zwrotka) {
				$(przycisk).parents('div.formularz').removeClass('formularz');
				$(przycisk).parents('.formdiv').find('input').val('');
				$(przycisk).parents('.formdiv').find('input[name="datawprowadzana"]').val(dzisiaj);
				$(przycisk).parents('.formdiv').find('[wartosc]').attr('wartosc', '');
				$(przycisk).parents('.formdiv').find('label').html('<span>Dołącz plik</span>');
				$(przycisk).parents('.formdiv').find('.zalacznik').not('#zalacznik').next('label').remove();
				$(przycisk).parents('.formdiv').find('.zalacznik').not('#zalacznik').next('.remove').remove();
				$(przycisk).parents('.formdiv').find('.zalacznik').not('#zalacznik').remove();
				$('.background').remove();
				$(zwrotka).insertAfter('.sTabela.eSekretariatWysylki thead');
			}
		})
	})
	// Klik na zapisanie nowej wysylki
	.off('click', '#esekretariatDziennikWysylekEdytuj').on('click', '#esekretariatDziennikWysylekEdytuj', function() {
		var przycisk = $(this),
			idedycji = $.trim($(this).parents('.formdiv').find('[name="idedycji"]').val()),
			staryadresat = $.trim($(this).parents('.formdiv').find('[name="adresatold"]').val()),
			adresat = $.trim($(this).parents('.formdiv').find('[name="adresat"]').val()),
			nazwaadresata = $.trim($(this).parents('.formdiv').find('[name="nazwaadresata"]').val()),
			ulica = $.trim($(this).parents('.formdiv').find('[name="ulica"]').val()),
			numer = $.trim($(this).parents('.formdiv').find('[name="numer"]').val()),
			kodpocztowy = $.trim($(this).parents('.formdiv').find('[name="kod"]').val()),
			miasto = $.trim($(this).parents('.formdiv').find('[name="miasto"]').val()),
			temat = $.trim($(this).parents('.formdiv').find('[name="temat"]').val()),
			data = $.trim($(this).parents('.formdiv').find('[name="datawprowadzana"]').val()),
			typnadania = $.trim($(this).parents('.formdiv').find('[name="typnadania"]').attr('wartosc')),
			typ = $.trim($(this).parents('.formdiv').find('[name="typnadania"]').val()),
			starezalaczniki = $.trim($(this).parents('.formdiv').find('[name="zalacznikiold"]').val()),
			skasowanezalaczniki = $.trim($(this).parents('.formdiv').find('[name="skasowanezalaczniki"]').val()),
			plik = new FormData();
		
		plik.append('idedycji', idedycji);
		plik.append('staryadresat', staryadresat);
		plik.append('adresat', adresat);
		plik.append('nazwaadresata', nazwaadresata);
		plik.append('ulica', ulica);
		plik.append('numer', numer);
		plik.append('kodpocztowy', kodpocztowy);
		plik.append('miasto', miasto);
		plik.append('temat', temat);
		plik.append('data', data);
		plik.append('typnadania', typnadania);
		plik.append('typ', typ);
		plik.append('starezalaczniki', starezalaczniki);
		plik.append('skasowanezalaczniki', skasowanezalaczniki);
		$('.dziennikwysylekedit .formdiv .zalacznik').not('[type="hidden"]').each(function() {
			if(typeof $(this).prop('files')[0] != typeof undefined) {
				plik.append('zalacznik[]', $(this).prop('files')[0]);
			}
		})
		$.ajax({
			type: 'POST',
			contentType: false,
			processData: false,
			url: 'php/ajax/eSekretariat/edytujWysylke.php',
			data: plik,
			dataType: 'html',
			
			success: function(zwrotka) {
				var podzielone = zwrotka.split(';;;');
				$('#dziennikwysylek' + idedycji).find('td').eq(1).empty().html(podzielone[0]);
				$('#dziennikwysylek' + idedycji).find('td').eq(2).empty().html(podzielone[1]);
				$('#dziennikwysylek' + idedycji).find('td').eq(3).empty().html(podzielone[2]);
				$('#dziennikwysylek' + idedycji).find('td').eq(4).empty().html(podzielone[3]);
				$('#dziennikwysylek' + idedycji).find('td').eq(5).empty().html(podzielone[4]);
				$(przycisk).parents('div.formularz').removeClass('formularz');
				$(przycisk).parents('.formdiv').find('input').val('');
				$(przycisk).parents('.formdiv').find('input[name="datawprowadzana"]').val(dzisiaj);
				$(przycisk).parents('.formdiv').find('[wartosc]').attr('wartosc', '');
				$(przycisk).parents('.formdiv').find('label').html('<span>Dołącz plik</span>');
				$(przycisk).parents('.formdiv').find('.zalacznik').not('#zalacznik').next('label').remove();
				$(przycisk).parents('.formdiv').find('.zalacznik').not('#zalacznik').next('.remove').remove();
				$(przycisk).parents('.formdiv').find('.zalacznik').not('#zalacznik').remove();
				$('.background').remove();
			}
		})
	})
	// Klik na zapisanie nowego przyjęcia
	.off('click', '#esekretariatDziennikPrzyjecDodajNowa').on('click', '#esekretariatDziennikPrzyjecDodajNowa', function() {
		var przycisk = $(this),
			nadawca = $.trim($(this).parents('.formdiv').find('[name="nadawca"]').val()),
			nazwanadawcy = $.trim($(this).parents('.formdiv').find('[name="nazwanadawcy"]').val()),
			ulica = $.trim($(this).parents('.formdiv').find('[name="ulica"]').val()),
			numer = $.trim($(this).parents('.formdiv').find('[name="numer"]').val()),
			kodpocztowy = $.trim($(this).parents('.formdiv').find('[name="kod"]').val()),
			miasto = $.trim($(this).parents('.formdiv').find('[name="miasto"]').val()),
			temat = $.trim($(this).parents('.formdiv').find('[name="temat"]').val()),
			opis = $.trim($(this).parents('.formdiv').find('[name="opis"]').val()),
			data = $.trim($(this).parents('.formdiv').find('[name="datawprowadzana"]').val()),
			iddzial = $.trim($(this).parents('.formdiv').find('[name="dzial"]').attr('wartosc')),
			dzial = $.trim($(this).parents('.formdiv').find('[name="dzial"]').val()),
			plik = new FormData();
			
		plik.append('nadawca', nadawca);
		plik.append('nazwanadawcy', nazwanadawcy);
		plik.append('ulica', ulica);
		plik.append('numer', numer);
		plik.append('kodpocztowy', kodpocztowy);
		plik.append('miasto', miasto);
		plik.append('temat', temat);
		plik.append('opis', opis);
		plik.append('data', data);
		plik.append('iddzial', iddzial);
		plik.append('dzial', dzial);
		$('.esekretariatDziennikPrzyjecDodaj .formdiv .zalacznik').each(function() {
			plik.append('zalacznik[]', $(this).prop('files')[0]);
		})
		$.ajax({
			type: 'POST',
			contentType: false,
			processData: false,
			url: 'php/ajax/eSekretariat/dodajPrzyjecie.php',
			data: plik,
			dataType: 'html',
			
			success: function(zwrotka) {
				$(przycisk).parents('div.formularz').removeClass('formularz');
				$(przycisk).parents('.formdiv').find('input').val('');
				$(przycisk).parents('.formdiv').find('input[name="datawprowadzana"]').val(dzisiaj);
				$(przycisk).parents('.formdiv').find('[wartosc]').attr('wartosc', '');
				$(przycisk).parents('.formdiv').find('label').html('<span>Dołącz plik</span>');
				$(przycisk).parents('.formdiv').find('.zalacznik').not('#zalacznik').next('label').remove();
				$(przycisk).parents('.formdiv').find('.zalacznik').not('#zalacznik').next('.remove').remove();
				$(przycisk).parents('.formdiv').find('.zalacznik').not('#zalacznik').remove();
				$('.background').remove();
				$(zwrotka).insertAfter('.sTabela.eSekretariatPrzyjecia thead');
			}
		})
	})
	// Klik na edytowanie przyjęcia
	.off('click', '#esekretariatDziennikPrzyjecEdytuj').on('click', '#esekretariatDziennikPrzyjecEdytuj', function() {
		var przycisk = $(this),
			karta = $(this).parents('.zakladka.act').attr('class').replace('zakladka', '').replace('act', '').replace(' ', '');
			idedycji = $.trim($(this).parents('.formdiv').find('[name="idedycji"]').val()),
			starynadawca = $.trim($(this).parents('.formdiv').find('[name="nadawcaold"]').val()),
			nadawca = $.trim($(this).parents('.formdiv').find('[name="nadawca"]').val()),
			nazwanadawcy = $.trim($(this).parents('.formdiv').find('[name="nazwanadawcy"]').val()),
			ulica = $.trim($(this).parents('.formdiv').find('[name="ulica"]').val()),
			numer = $.trim($(this).parents('.formdiv').find('[name="numer"]').val()),
			kodpocztowy = $.trim($(this).parents('.formdiv').find('[name="kod"]').val()),
			miasto = $.trim($(this).parents('.formdiv').find('[name="miasto"]').val()),
			temat = $.trim($(this).parents('.formdiv').find('[name="temat"]').val()),
			opis = $.trim($(this).parents('.formdiv').find('[name="opis"]').val()),
			data = $.trim($(this).parents('.formdiv').find('[name="datawprowadzana"]').val()),
			iddzial = $.trim($(this).parents('.formdiv').find('[name="dzial"]').attr('wartosc')),
			dzial = $.trim($(this).parents('.formdiv').find('[name="dzial"]').val()),
			starezalaczniki = $.trim($(this).parents('.formdiv').find('[name="zalacznikiold"]').val()),
			skasowanezalaczniki = $.trim($(this).parents('.formdiv').find('[name="skasowanezalaczniki"]').val()),
			plik = new FormData();
		
		plik.append('idedycji', idedycji);
		plik.append('starynadawca', starynadawca);
		plik.append('nadawca', nadawca);
		plik.append('nazwanadawcy', nazwanadawcy);
		plik.append('ulica', ulica);
		plik.append('numer', numer);
		plik.append('kodpocztowy', kodpocztowy);
		plik.append('miasto', miasto);
		plik.append('opis', opis);
		plik.append('temat', temat);
		plik.append('data', data);
		plik.append('iddzial', iddzial);
		plik.append('dzial', dzial);
		plik.append('starezalaczniki', starezalaczniki);
		plik.append('skasowanezalaczniki', skasowanezalaczniki);
		$('.dziennikprzyjecedit .formdiv .zalacznik').not('[type="hidden"]').each(function() {
			if(typeof $(this).prop('files')[0] != typeof undefined) {
				plik.append('zalacznik[]', $(this).prop('files')[0]);
			}
		})
		$.ajax({
			type: 'POST',
			contentType: false,
			processData: false,
			url: 'php/ajax/eSekretariat/edytujPrzyjecie.php',
			data: plik,
			dataType: 'html',
			
			success: function(zwrotka) {
				var podzielone = zwrotka.split(';;;');
				$('.' + karta + ' #dziennikprzyjec' + idedycji).find('td').eq(1).empty().html(podzielone[0]);
				$('.' + karta + ' #dziennikprzyjec' + idedycji).find('td').eq(2).empty().html(podzielone[1]);
				$('.' + karta + ' #dziennikprzyjec' + idedycji).find('td').eq(3).empty().html(podzielone[2]);
				$('.' + karta + ' #dziennikprzyjec' + idedycji).find('td').eq(4).empty().html(podzielone[3]);
				$('.' + karta + ' #dziennikprzyjec' + idedycji).find('td').eq(8).empty().html(podzielone[4]);
				$('.' + karta + ' #dziennikprzyjec' + idedycji).find('td').eq(5).empty().html(podzielone[5]);
				$(przycisk).parents('div.formularz').removeClass('formularz');
				$(przycisk).parents('.formdiv').find('input').val('');
				$(przycisk).parents('.formdiv').find('input[name="datawprowadzana"]').val(dzisiaj);
				$(przycisk).parents('.formdiv').find('[wartosc]').attr('wartosc', '');
				$(przycisk).parents('.formdiv').find('label').html('<span>Dołącz plik</span>');
				$(przycisk).parents('.formdiv').find('.zalacznik').not('#zalacznik').next('label').remove();
				$(przycisk).parents('.formdiv').find('.zalacznik').not('#zalacznik').next('.remove').remove();
				$(przycisk).parents('.formdiv').find('.zalacznik').not('#zalacznik').remove();
				$('.background').remove();
			}
		})
	})
	// Wybranie opcji z datalist dla adresata
	.off('input', '[name="nazwaadresata"]').on('input', '[name="nazwaadresata"]', function() {
		var wartosci = $(this).val().split(';;');
		if(wartosci.length > 1) {
			$('[name="adresat"]').val(wartosci[0]);
			$('[name="nazwaadresata"]').val(wartosci[1]);
			$('[name="ulica"]').val(wartosci[2]);
			$('[name="numer"]').val(wartosci[3]);
			$('[name="kod"]').val(wartosci[4]);
			$('[name="miasto"]').val(wartosci[5]);
		}
		else {
			$('[name="adresat"]').val('');
		}
	})
	// Wybranie opcji z datalist dla nadawcy
	.off('input', '[name="nazwanadawcy"]').on('input', '[name="nazwanadawcy"]', function() {
		var wartosci = $(this).val().split(';;');
		if(wartosci.length > 1) {
			$('[name="nadawca"]').val(wartosci[0]);
			$('[name="nazwanadawcy"]').val(wartosci[1]);
			$('[name="ulica"]').val(wartosci[2]);
			$('[name="numer"]').val(wartosci[3]);
			$('[name="kod"]').val(wartosci[4]);
			$('[name="miasto"]').val(wartosci[5]);
		}
		else {
			$('[name="nadawca"]').val('');
		}
	})
	// Wybranie opcji z datalist dla typu nadania
	.off('input', '[name="typnadania"]').on('input', '[name="typnadania"]', function() {
		var wartosci = $(this).val().split(';;');
		if(wartosci.length > 1) {
			$('[name="typnadania"]').attr('wartosc', wartosci[0]).val(wartosci[1]);
		}
		else {
			$('[name="typnadania"]').attr('wartosc', '');
		}
	})
	// Wybranie opcji z datalist dla dzialu
	.off('input', '[name="dzial"]').on('input', '[name="dzial"]', function() {
		var wartosci = $(this).val().split(';;');
		if(wartosci.length > 1) {
			$('[name="dzial"]').attr('wartosc', wartosci[0]).val(wartosci[1]);
		}
		else {
			$('[name="dzial"]').attr('wartosc', '');
		}
	})
	// Wybranie opcji z datalist dla dzialu
	.off('input', '[name="emailadresata"]').on('input', '[name="emailadresata"]', function() {
		var wartosci = $(this).val().split(';;'),
			karta = $(this).parents('.zakladka.act').attr('class').replace('zakladka', '').replace('act', '').replace(' ', '');
		if(wartosci.length > 1) {
			$('.' + karta + ' .esekretariatDziennikPrzyjecPowiadom [name="adresat"]').val(wartosci[0]);
			$('.' + karta + ' .esekretariatDziennikPrzyjecPowiadom [name="emailadresata"]').val(wartosci[1]);
		}
		else {
			$('.' + karta + ' .esekretariatDziennikPrzyjecPowiadom [name="adresat"]').val('');
		}
	})
	// Powiadomienie e-mail
	.off('click', '.powiadom').on('click', '.powiadom', function() {
		var id = $(this).attr('id').replace('powiadom', ''),
			karta = $(this).parents('.zakladka.act').attr('class').replace('zakladka', '').replace('act', '').replace(' ', ''),
			ilezalacznikow = $('.' + karta + ' #dziennikprzyjec' + id).find('td').eq(5).find('a').length,
			temat = $('.' + karta + ' #dziennikprzyjec' + id).find('td').eq(2).text(),
			data = $('.' + karta + ' #dziennikprzyjec' + id).find('td').eq(4).text(),
			nadawca = $('.' + karta + ' #dziennikprzyjec' + id).find('td').eq(1).contents().eq(1).text().split(', ');
		$('body').append("<div class='background'></div>");
		$('.' + karta + ' .esekretariatDziennikPrzyjecPowiadom').addClass('formularz');
		$('.' + karta + ' .esekretariatDziennikPrzyjecPowiadom .formdiv').find('[name="idprzyjecia"]').val(id);
		$('.' + karta + ' .esekretariatDziennikPrzyjecPowiadom .formdiv').find('[name="tematpowiadomienia"]').val(temat);
		$('.' + karta + ' .esekretariatDziennikPrzyjecPowiadom .formdiv').find('[name="nadawca"]').val(nadawca[0]);
		$('.' + karta + ' .esekretariatDziennikPrzyjecPowiadom .formdiv').find('[name="datapowiadomienia"]').val(data);
		$.ajax({
			type: 'POST',
			url: 'php/ajax/eSekretariat/pobierzUzytkownikow.php',
			dataType: 'html',
			
			success: function(opcje) {
				$('#uzytkownicy').empty().append(opcje);
			}
		});
		for(var i = 0; i < ilezalacznikow; i++) {
			var zalacznik =  $('.' + karta + ' #dziennikprzyjec' + id).find('td').eq(5).find('a').eq(i).attr('href'),
				nazwazalacznika = $('.' + karta + ' #dziennikprzyjec' + id).find('td').eq(5).find('a').eq(i).attr('href').replace('files/eSekretariat/Przyjecia/', '');
			$("<div class='checkBoxForm'><input id='wybranyzalacznik" + id + i + "' name='wybranyzalacznik' type='checkbox' checked><label for='wybranyzalacznik" + id + i + "' class='CheckBoxForm'><span>&#10003;</span></label><input id='zalacznik" + id + i + "' name='zalacznik' type='text' class='inputfile zalacznik' value='" + zalacznik + "'><label for='zalacznik" + id + i +"'><span>" + nazwazalacznika + "</span></label></div>").insertAfter('.' + karta + ' .esekretariatDziennikPrzyjecPowiadom .cialoFormularza label.nl');
		}
	})
	// Wysłanie powiadomienia
	.off('click', '#esekretariatDziennikPrzyjecPowiadom').on('click', '#esekretariatDziennikPrzyjecPowiadom', function() {
		var przycisk = $(this),
			karta = $(this).parents('.zakladka.act').attr('class').replace('zakladka', '').replace('act', '').replace(' ', ''),
			id = $.trim($(this).parents('.formdiv').find('[name="idprzyjecia"]').val()),
			adresat = $.trim($(this).parents('.formdiv').find('[name="adresat"]').val()),
			data = $.trim($(this).parents('.formdiv').find('[name="datapowiadomienia"]').val()),
			nadawca = $.trim($(this).parents('.formdiv').find('[name="nadawca"]').val()),
			email = $.trim($(this).parents('.formdiv').find('[name="emailadresata"]').val()),
			temat = $.trim($(this).parents('.formdiv').find('[name="tematpowiadomienia"]').val()),
			ilezalacznikow = $.trim($(this).parents('.formdiv').find('.checkBoxForm').length),
			zalaczniki = '';
		for(var i = 0; i < ilezalacznikow; i++) {
			if($(this).parents('.formdiv').find('#wybranyzalacznik' + id + i).is(':checked')) {
				zalaczniki = zalaczniki.concat($(this).parents('.formdiv').find('#zalacznik' + id + i).val());
				zalaczniki = zalaczniki.concat(';;');
			}
		}
		przycisk.attr('disabled', true);
		przycisk.parent().find('.anulujform').attr('disabled', true);
		$.ajax({
			type: 'POST',
			url: 'php/ajax/eSekretariat/wyslijPowiadomienie.php',
			data: {id: id, adresat: adresat, data: data, nadawca: nadawca, email: email, temat: temat, zalaczniki: zalaczniki},
			dataType: 'html',
			
			success: function(zwrotka) {
				$(przycisk).parents('div.formularz').removeClass('formularz');
				$(przycisk).parents('.formdiv').find('input').val('');
				$(przycisk).parents('.formdiv').find('input[name="datawprowadzana"]').val(dzisiaj);
				$(przycisk).parents('.formdiv').find('[wartosc]').attr('wartosc', '');
				$(przycisk).parents('.formdiv').find('label').html('<span>Dołącz plik</span>');
				$(przycisk).parents('.formdiv').find('.zalacznik').not('#zalacznik').next('label').remove();
				$(przycisk).parents('.formdiv').find('.zalacznik').not('#zalacznik').next('.remove').remove();
				$(przycisk).parents('.formdiv').find('.zalacznik').not('#zalacznik').remove();
				$('.background').remove();
				przycisk.removeAttr('disabled');
				przycisk.parent().find('.anulujform').removeAttr('disabled');
				zwr = zwrotka.split(';;');
				if(zwr[0] == 'powodzenie') {
					$('.' + karta + ' #dziennikprzyjec' + id).find('td').eq(6).empty().html(zwr[1]);
				}
				else if(zwr[0] == 'error') {
					alert(zwr[1]);
				}
			}
		});
	})
	// Pobrano oryginał
	.off('click', '.pobrano').on('click', '.pobrano', function() {
		var id = $(this).attr('id').replace('pobrano', ''),
			karta = $(this).parents('.zakladka.act').attr('class').replace('zakladka', '').replace('act', '').replace(' ', '');
		$('body').append("<div class='background'></div>");
		$('.' + karta + ' .esekretariatPobrano').addClass('formularz');
		$('.' + karta + ' .esekretariatPobrano .formdiv').find('[name="idprzyjecia"]').val(id);
		$.ajax({
			type: 'POST',
			url: 'php/ajax/eSekretariat/pobierzPobierajacych.php',
			dataType: 'html',
			
			success: function(opcje) {
				$('#pobierajacy').empty().append(opcje);
			}
		});
	})
	// Zapisanie Pobrania
	.off('click', '#esekretariatPobrano').on('click', '#esekretariatPobrano', function() {
		var przycisk = $(this),
			karta = $(this).parents('.zakladka.act').attr('class').replace('zakladka', '').replace('act', '').replace(' ', ''),
			id = $.trim($(this).parents('.formdiv').find('[name="idprzyjecia"]').val()),
			pobierajacy = $.trim($(this).parents('.formdiv').find('[name="pobierajacy"]').val());
		przycisk.attr('disabled', true);
		$.ajax({
			type: 'POST',
			url: 'php/ajax/eSekretariat/zapiszPobranie.php',
			data: {id: id, pobierajacy: pobierajacy},
			dataType: 'html',
			
			success: function(zwrotka) {
				$(przycisk).parents('div.formularz').removeClass('formularz');
				$(przycisk).parents('.formdiv').find('input').val('');
				$(przycisk).parents('.formdiv').find('input[name="datawprowadzana"]').val(dzisiaj);
				$(przycisk).parents('.formdiv').find('[wartosc]').attr('wartosc', '');
				$(przycisk).parents('.formdiv').find('label').html('<span>Dołącz plik</span>');
				$(przycisk).parents('.formdiv').find('.zalacznik').not('#zalacznik').next('label').remove();
				$(przycisk).parents('.formdiv').find('.zalacznik').not('#zalacznik').next('.remove').remove();
				$(przycisk).parents('.formdiv').find('.zalacznik').not('#zalacznik').remove();
				$('.background').remove();
				przycisk.removeAttr('disabled');
				$('.' + karta + ' #dziennikprzyjec' + id).find('td').eq(7).empty().html(zwrotka);
			}
		});
	})
	
	window.dziennikwysylekedit = function dziennikwysylekedit(karta, nr) {
		$('.' + karta + ' .dziennikwysylekedit').find('input[name="idedycji"]').val(nr);
		$('.' + karta + ' .dziennikwysylekedit').find('input[name="adresatold"]').val($('.' + karta + ' #dziennikwysylek' + nr).find('td').eq(1).find('.idkontrahenta').text());
		$('.' + karta + ' .dziennikwysylekedit').find('input[name="adresat"]').val($('.' + karta + ' #dziennikwysylek' + nr).find('td').eq(1).find('.idkontrahenta').text());
		var adresat = $('.' + karta + ' #dziennikwysylek' + nr).find('td').eq(1).contents().eq(1).text(),
			daneadresata = adresat.split(', '),
			ulica = daneadresata[1].split('  '),
			miasto = daneadresata[2].split('  '),
			ilezalacznikow = $('.' + karta + ' #dziennikwysylek' + nr).find('td').eq(5).find('a').length,
			zalacznikiold = '',
			nazwazalacznika = '';
		$('.' + karta + ' .dziennikwysylekedit').find('input[name="nazwaadresata"]').val(daneadresata[0]);
		$('.' + karta + ' .dziennikwysylekedit').find('input[name="ulica"]').val(ulica[0]);
		$('.' + karta + ' .dziennikwysylekedit').find('input[name="numer"]').val(ulica[1]);
		$('.' + karta + ' .dziennikwysylekedit').find('input[name="kod"]').val(miasto[0]);
		$('.' + karta + ' .dziennikwysylekedit').find('input[name="miasto"]').val(miasto[1]);
		$('.' + karta + ' .dziennikwysylekedit').find('input[name="temat"]').val($('.' + karta + ' #dziennikwysylek' + nr).find('td').eq(2).text());
		$('.' + karta + ' .dziennikwysylekedit').find('input[name="datawprowadzana"]').val($('.' + karta + ' #dziennikwysylek' + nr).find('td').eq(3).text());
		$('.' + karta + ' .dziennikwysylekedit').find('input[name="typnadania"]').val($('.' + karta + ' #dziennikwysylek' + nr).find('td').eq(4).contents().eq(1).text()).attr('wartosc', $('.' + karta + ' #dziennikwysylek' + nr).find('td').eq(4).contents().eq(0).text());
		for(var i = 0; i < ilezalacznikow; i++) {
			nazwazalacznika = $('.' + karta + ' #dziennikwysylek' + nr).find('td').eq(5).find('a').eq(i).attr('href').replace('files/eSekretariat/Wychodzace/', '');
			zalacznikiold = zalacznikiold.concat($('.' + karta + ' #dziennikwysylek' + nr).find('td').eq(5).find('a').eq(i).attr('href'));
			zalacznikiold = zalacznikiold.concat(';;');
			$("<input id='zalacznik" + nr + i + "' name='zalacznik' type='file' class='inputfile zalacznik'><label for='zalacznik" + nr + i +"'><span>" + nazwazalacznika + "</span></label><span skasuj='zalacznik" + nr + i + "' class='btn uwaga remove'>-</span>").insertBefore('.' + karta + ' .dziennikwysylekedit .cialoFormularza .dodajzalacznik');
		}
		$('.' + karta + ' .dziennikwysylekedit').find('input[name="zalacznikiold"]').val(zalacznikiold);
		$.ajax({
			type: 'POST',
			url: 'php/ajax/eSekretariat/pobierzAdresatow.php',
			dataType: 'html',
			
			success: function(opcje) {
				$('#adresaci').empty().append(opcje);
			}
		});
		$.ajax({
			type: 'POST',
			url: 'php/ajax/eSekretariat/pobierzTypyNadania.php',
			dataType: 'html',
			
			success: function(opcje) {
				$('#typynadania').empty().append(opcje);
			}
		});
	}
	
	window.dziennikprzyjecedit = function dziennikprzyjecedit(karta, nr) {
		$('.' + karta + ' .dziennikprzyjecedit').find('input[name="idedycji"]').val(nr);
		$('.' + karta + ' .dziennikprzyjecedit').find('input[name="nadawcaold"]').val($('.' + karta + ' #dziennikprzyjec' + nr).find('td').eq(1).find('.idkontrahenta').text());
		$('.' + karta + ' .dziennikprzyjecedit').find('input[name="nadawca"]').val($('.' + karta + ' #dziennikprzyjec' + nr).find('td').eq(1).find('.idkontrahenta').text());
		var nadawca = $('.' + karta + ' #dziennikprzyjec' + nr).find('td').eq(1).contents().eq(1).text(),
			danenadawcy = nadawca.split(', '),
			ulica = danenadawcy[1].split('  '),
			miasto = danenadawcy[2].split('  '),
			ilezalacznikow = $('.' + karta + ' #dziennikprzyjec' + nr).find('td').eq(5).find('a').length,
			zalacznikiold = '',
			nazwazalacznika = '';
		$('.' + karta + ' .dziennikprzyjecedit').find('input[name="nazwanadawcy"]').val(danenadawcy[0]);
		$('.' + karta + ' .dziennikprzyjecedit').find('input[name="ulica"]').val(ulica[0]);
		$('.' + karta + ' .dziennikprzyjecedit').find('input[name="numer"]').val(ulica[1]);
		$('.' + karta + ' .dziennikprzyjecedit').find('input[name="kod"]').val(miasto[0]);
		$('.' + karta + ' .dziennikprzyjecedit').find('input[name="miasto"]').val(miasto[1]);
		$('.' + karta + ' .dziennikprzyjecedit').find('input[name="temat"]').val($('.' + karta + ' #dziennikprzyjec' + nr).find('td').eq(2).text());
		$('.' + karta + ' .dziennikprzyjecedit').find('input[name="opis"]').val($('.' + karta + ' #dziennikprzyjec' + nr).find('td').eq(3).text());
		$('.' + karta + ' .dziennikprzyjecedit').find('input[name="datawprowadzana"]').val($('.' + karta + ' #dziennikprzyjec' + nr).find('td').eq(4).text());
		$('.' + karta + ' .dziennikprzyjecedit').find('input[name="dzial"]').val($('.' + karta + ' #dziennikprzyjec' + nr).find('td').eq(8).contents().eq(1).text()).attr('wartosc', $('.' + karta + ' #dziennikprzyjec' + nr).find('td').eq(8).contents().eq(0).text());
		for(var i = 0; i < ilezalacznikow; i++) {
			nazwazalacznika = $('.' + karta + ' #dziennikprzyjec' + nr).find('td').eq(5).find('a').eq(i).attr('href').replace('files/eSekretariat/Przyjecia/', '');
			zalacznikiold = zalacznikiold.concat($('.' + karta + ' #dziennikprzyjec' + nr).find('td').eq(5).find('a').eq(i).attr('href'));
			zalacznikiold = zalacznikiold.concat(';;');
			$("<input id='zalacznik" + nr + i + "' name='zalacznik' type='file' class='inputfile zalacznik'><label for='zalacznik" + nr + i +"'><span>" + nazwazalacznika + "</span></label><span skasuj='zalacznik" + nr + i + "' class='btn uwaga remove'>-</span>").insertBefore('.' + karta + ' .dziennikprzyjecedit .cialoFormularza .dodajzalacznik');
		}
		$('.' + karta + ' .dziennikprzyjecedit').find('input[name="zalacznikiold"]').val(zalacznikiold);
		$.ajax({
			type: 'POST',
			url: 'php/ajax/eSekretariat/pobierzAdresatow.php',
			dataType: 'html',
			
			success: function(opcje) {
				$('#adresaci').empty().append(opcje);
				$('#nadawcy').empty().append(opcje);
			}
		});
		$.ajax({
			type: 'POST',
			url: 'php/ajax/eSekretariat/pobierzDzialy.php',
			dataType: 'html',
			
			success: function(opcje) {
				$('#dzialy').empty().append(opcje);
			}
		});
	}
})