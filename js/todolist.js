$(document).ready(function() {
	$(document)
	.off('click', '#noweZadanie #dodajSzczegol').on('click', '#noweZadanie #dodajSzczegol', function() {
		$('#szczegoltemplate').clone().attr('id', 'szczegol').insertBefore('#szczegoltemplate').removeClass('hidden').addClass('szczegol').find('[name=opistmp]').attr('name', 'opisy[]').end();
	})
	.off('click', '#noweZadanie .usunWiersz').on('click', '#noweZadanie .usunWiersz', function() {
		$(this).parents('#szczegol').remove();
	})
	.off('click', '#noweZadanie #zapiszZadanie').on('click', '#noweZadanie #zapiszZadanie', function() {
		var temat = $('#noweZadanie').find('[name=temat]').val(),
			opis = $('#noweZadanie').find('[name=opis]').val(),
			termin = $('#noweZadanie').find('[name=termin]').val(),
			opisy = [],
			wyniki = $('.sTabela.todolist thead');
		$('#noweZadanie').find('[name^=opisy]').each(function() {
			opisy.push($(this).val());
		});
		$.ajax({
			type: 'POST',
			url: 'php/ajax/todolist/todolist_dodajZadanie.php',
			data: {temat: temat, opis: opis, termin: termin, opisy: opisy},
			dataType: 'html',
			
			success: function(zadanie) {
				$(zadanie).insertAfter(wyniki);
				$('#noweZadanie').find('input').each(function() {
					$(this).val('');
				}).end().find('.szczegol').each(function() {
					$(this).remove();
				}).end();
			}
		});
	})
	.off('click', '.pokaz').on('click', '.pokaz', function() {
		szczegoly($(this).attr('value'));
		var tbodyid = $(this).attr('value');
		var opcjercm = $('#' + tbodyid).children('tr:first').attr('opcjeRCM');
		opcjercm = opcjercm.replace('Pokaż', 'Ukryj');
		$('#' + tbodyid).children('tr:first').attr('opcjeRCM', opcjercm);
	})
	.off('click', '.ukryj').on('click', '.ukryj', function() {
		szczegoly($(this).attr('value'));
		var tbodyid = $(this).attr('value');
		var opcjercm = $('#' + tbodyid).children('tr:first').attr('opcjeRCM');
		opcjercm = opcjercm.replace('Ukryj', 'Pokaż');
		$('#' + tbodyid).children('tr:first').attr('opcjeRCM', opcjercm);
	})
	.off('click', '.usun').on('click', '.usun', function() {
		alert('Usuwanie aktualnie niemożliwe');
	})
	.off('dblclick', '.sTabela .dblEdit').on('dblclick', '.sTabela .dblEdit', function(e) {
		var pole = $(this);
		var idedit = $(this).attr('idedit');
		var indeks = $(this).attr('indeks');
		var edycja = '';
		if(!$('#editField:visible').length) {
			if(indeks == 'opis') {
				edycja = "<textarea>" + $(this).text() + "</textarea>";
			}
			else if(indeks == 'wykonanie') {
				edycja = "<input type='range' min='0' max='100' step='10' value='" + $(this).attr('value') + "' />";
			}
			$('#editField').find('.cialoFormularza').append(edycja);
			if((e.pageX <= (szerokoscOkna * 0.7)) && (e.pageY <= (wysokoscOkna * 0.7))) {
				$('#editField').css({'display': 'block', 'left': e.pageX + 5, 'top': e.pageY + 5, 'right': 'unset', 'bottom': 'unset'});
			}
			else if((e.pageX > (szerokoscOkna * 0.7)) && (e.pageY <= (wysokoscOkna * 0.7))) {
				$('#editField').css({'display': 'block', 'left': 'unset', 'top': e.pageY + 5, 'right': (szerokoscOkna - e.pageX + 5), 'bottom': 'unset'});
			}
			else if((e.pageX <= (szerokoscOkna * 0.7)) && (e.pageY > (wysokoscOkna * 0.7))) {
				$('#editField').css({'display': 'block', 'left': e.pageX + 5, 'top': 'unset', 'right': 'unset', 'bottom': (wysokoscOkna - e.pageY + 5)});
			}
			else if((e.pageX > (szerokoscOkna * 0.7)) && (e.pageY > (wysokoscOkna * 0.7))) {
				$('#editField').css({'display': 'block', 'left': 'unset', 'top': 'unset', 'right': (szerokoscOkna - e.pageX + 5), 'bottom': (wysokoscOkna - e.pageY + 5)});
			}
			$('#editField').find('.zapisz').off('click').on('click', function() {
				var tresc = $('#editField .cialoFormularza').find('*').val();
				$.ajax({
					type: 'POST',
					url: 'php/ajax/todolist/todolist_edytujSzczegoly.php',
					data: {id: idedit, indeks: indeks, wartosc: tresc},
					dataType: 'html',
					
					success: function(wartosc) {
						var war = wartosc.split(',');
						$(pole).parent().find('td:nth-child(2)').empty().html(war[0]);
						$(pole).empty().html(war[1]);
						$(pole).attr('value', war[2]);
						if(typeof war[3] !== typeof undefined  && war[3] !== false) {
							$(pole).parents('tbody').find('.RCM td:last-child').html(war[3]);
						}
					}
				});
				$(this).parent().parent().css({'display': 'none', 'left': 'unset', 'top': 'unset', 'right': 'unset', 'bottom': 'unset'})
					.find('.cialoFormularza').empty()
					.find('.naglowekFormularza').empty();
			});
		}
	})
	.off('click', '.sTabela .dodajSzczegol').on('click', '.sTabela .dodajSzczegol', function() {
		var dodaj = $(this);
		var wartosc = $(this).parent().find("[name='podzadanietmp']").val();
		var idzadanie = $(this).attr('idzadanie');
		$.ajax({
			type: 'POST',
			url: 'php/ajax/todolist/todolist_dodajSzczegoly.php',
			data: {wartosc: wartosc, idzadanie: idzadanie},
			dataType: 'html',
			
			success: function(szczegol) {
				$(szczegol).insertBefore($(dodaj).parents('tbody:first'));
				$(dodaj).parent().find("[name='podzadanietmp']").val('');
			}
		});
	});
	function szczegoly(id) {
		var idZadania = id.replace(/\D/g,'');
		$.ajax({
			type: 'POST',
			url: 'php/ajax/todolist/todolist_pobierzSzczegoly.php',
			data: {zadanie: idZadania},
			dataType: 'html',
			
			success: function(szczegoly) {
				if(szczegoly != '') {
					if($('#' + id + ' tr').hasClass('szczegol')) {
						$('#' + id).find('.szczegol').remove();
					}
					else {
						$(szczegoly).appendTo('#' + id);
					}
				}
			}
		});
	}
})