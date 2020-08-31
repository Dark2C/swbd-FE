<script>
    const ID_impianto = <?php echo intval($_GET['ID']); ?>;
	let ID_intervento, ID_tecnico_toDelete, impianto;
</script>
<div class="row">
	<div class="col-md-4">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">Informazioni generali</h5>
				<div class="card-tools">
				<?php if($_SESSION['userInfo']['role'] == 'amministratore') { ?>
                    <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-modifica-impianto" onclick="populateForm();" >
					    <i class="fas fa-edit"></i>
					</button>
				<?php } ?>
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
					    <i class="fas fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="card-body table-responsive p-0">
				<style>
					.detailsTable {
						width: 100%;
					}
					.detailsTable td {
						padding: 5px;
					}
				</style>
				<table class="detailsTable">
					<tr>
						<td style="width: 110px;"><b>Nome</b></td>
						<td id="detailsTable_nome">...</td>
					</tr>
					<tr style="background: #ededed;">
						<td><b>Descrizione</b></td>
						<td id="detailsTable_descrizione">...</td>
					</tr>
					<tr>
						<td><b>Intervallo di trasmissione standard (s)</b></td>
						<td id="detailsTable_intervallo_standard">...</td>
					</tr>
					<tr style="background: #ededed;">
						<td><b>Intervallo di trasmissione anomalia (s)</b></td>
						<td id="detailsTable_intervallo_anomalia">...</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">Elenco sensori</h5>
				<div class="card-tools">
				<?php if($_SESSION['userInfo']['role'] == 'amministratore') { ?>
                    <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-aggiungi-sensore">
					    <i class="fas fa-file"></i>
					</button>
				<?php } ?>
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
					    <i class="fas fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="card-body table-responsive p-0">
				<table class="table table-striped table-valign-middle">
					<thead>
						<tr>
							<th>Tipologia sensore</th>
							<th>Data installazione</th>
				<?php if($_SESSION['userInfo']['role'] == 'amministratore') { ?><th>Azioni</th><?php } ?>
						</tr>
					</thead>
					<tbody id="elencoSensori">
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">Elenco attuatori</h5>
				<div class="card-tools">
				<?php if($_SESSION['userInfo']['role'] == 'amministratore') { ?>
                    <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-aggiungi-attuatore">
					    <i class="fas fa-file"></i>
					</button>
				<?php } ?>
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
					    <i class="fas fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="card-body table-responsive p-0">
				<table class="table table-striped table-valign-middle">
					<thead>
						<tr>
							<th>Tipologia attuatore</th>
							<th>Data installazione</th>
				<?php if($_SESSION['userInfo']['role'] == 'amministratore') { ?><th>Azioni</th><?php } ?>
						</tr>
					</thead>
					<tbody id="elencoAttuatori">
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">Visualizzazione sulla mappa</h5>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
					<i class="fas fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="card-body">
	            <div id="borderless-world" style="height: 500px; width: 100%"></div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">Elenco interventi</h5>
				<div class="card-tools">
				<?php if($_SESSION['userInfo']['role'] != 'tecnico') { ?>
					<button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-aggiungi-intervento" onclick="resetAddIntervento();">
					    <i class="fas fa-plus"></i>
					</button>
				<?php } ?>
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
					    <i class="fas fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="card-body table-responsive p-0">
				<table class="table table-striped table-valign-middle">
					<thead>
						<tr>
							<th>Data inserimento</th>
							<th>Stato</th>
							<th>Azioni</th>
						</tr>
					</thead>
					<tbody id="elencoInterventi">
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php if($_SESSION['userInfo']['role'] != 'tecnico') { ?>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">Grafici</h5>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
					<i class="fas fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="card-body">
				<div class="form-group">
					<label for="elencoTipologiaSensoriImpianto">Seleziona il sensore per il quale elaborare il grafico</label>
					<select class="form-control" id="elencoTipologiaSensoriImpianto" onchange="getGraficoSensore($(this).val());$('.selezionaSensorePlaceholder').remove();">
					</select>
				</div>
				<div style="width:100%;">
					<canvas id="canvasGrafico"></canvas>
				</div>
				
				<script>
					var config = {
						type: 'line',
						data: {
							datasets: []
						}
					};
					window.onload = function() {
						var ctx = document.getElementById('canvasGrafico').getContext('2d');
						window.myLine = new Chart(ctx, config);
					};
				</script>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<div class="modal fade" id="modal-letture-sensore">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Elenco letture sensore</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				 	<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-striped table-valign-middle">
					<thead>
						<tr>
							<th>Data lettura</th>
							<th>Valore [<span id="unita_misura_lettureSensore"></span>]</th>
						</tr>
					</thead>
					<tbody id="elencoLettureSensore">
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-operazioni-attuatore">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Elenco operazioni attuatore</h4>
				<button type="button" class="close" aria-label="Add" title="Aggiungi operazione" onclick="showAddOperazioneForm();">
				 	<span aria-hidden="true">+</span>
				</button>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-left: 0;">
				 	<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="addOperazioneForm" style="display: none;">
					<input type="hidden" class="currentAttuatoreID">
					<div class="form-group">
						<label for="valoreOperazione">Indica il valore da inviare all'attuatore</label>
						<input type="number" min="0" max="100" step="0.5" class="form-control" id="valoreOperazione">
					</div>
					
					<div style="text-align: right; margin-top: 20px;">
						<input type="button" value="Annulla" class="btn btn-default" onclick="hideAddOperazioneForm();">&nbsp;<input type="button" value="Salva" class="btn btn-primary" onclick="addNewOperazione();">
					</div>
				</div>
				<div class="operazioniTable">
					<table class="table table-striped table-valign-middle">
						<thead>
							<tr>
								<th>Data operazione</th>
								<th>Valore</th>
								<th>Conferma lettura</th>
							</tr>
						</thead>
						<tbody id="elencoOperazioniAttuatore">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<div class="modal fade" id="modal-info-intervento">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Dettagli Intervento</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				 	<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-striped table-valign-middle">
					<tbody id="tabellaDettagliIntervento">
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>
<div class="modal fade" id="modal-anomalie-intervento">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Elenco Anomalie Intervento</h4>
				<script>
					function hideAddAnomaliaForm() {
						$(".addAnomalia,.anomalieTable").show();
						$(".addAnomaliaForm").hide();
					}
					function showAddAnomaliaForm() {
						$(".descrizioneNuovaAnomalia").val('');
						$(".addAnomalia,.anomalieTable").hide();
						$(".addAnomaliaForm").show();
					}
					function hideAddOperazioneForm() {
						$(".operazioniTable").show();
						$(".addOperazioneForm").hide();
					}
					function showAddOperazioneForm() {
						$(".operazioniTable").hide();
						$(".addOperazioneForm").show();
					}
					
					function addNewAnomalia() {
						$.ajax(`<?php echo $restEntrypoint; ?>/intervento/${$('.currentInterventoID').val()}/anomalia`, {
				    	    type: "POST",
				    	    contentType: "application/json; charset=utf-8",
				    	    data: JSON.stringify({
				    	        descrizione: $(".descrizioneNuovaAnomalia").val(),
								sensore: $("#elencoSensoriImpiantoAnom").val()
				    	    }),
				    	    success: function(data) {
				    	        location.reload();
				    	    },
				    	    error: function () {
				    	        location.reload();
				    	    },
				    	    xhrFields: {
				    	        withCredentials: true
				    	    },
				    	    crossDomain: true
				    	});
					}

					function addNewOperazione() {
						$.ajax(`<?php echo $restEntrypoint; ?>/attuatore/${$('.currentAttuatoreID').val()}/set`, {
				    	    type: "POST",
				    	    contentType: "application/json; charset=utf-8",
				    	    data: JSON.stringify({
				    	        valore: $("#valoreOperazione").val()
				    	    }),
				    	    success: function(data) {
				    	        location.reload();
				    	    },
				    	    error: function () {
				    	        location.reload();
				    	    },
				    	    xhrFields: {
				    	        withCredentials: true
				    	    },
				    	    crossDomain: true
				    	});
					}
				</script>
				<button type="button" class="addAnomalia close" aria-label="Add" title="Aggiungi anomalia" onclick="showAddAnomaliaForm();">
				 	<span aria-hidden="true">+</span>
				</button>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-left: 0;">
				 	<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="addAnomaliaForm" style="display: none;">
					<input type="hidden" class="currentInterventoID" />
					<div class="form-group">
						<label for="elencoSensoriImpiantoAnom">Seleziona il sensore interessato</label>
						<select class="form-control elencoSensoriImpianto" id="elencoSensoriImpiantoAnom">
						</select>
					</div>
					<textarea class="form-control descrizioneNuovaAnomalia" placeholder="Inserisci una descrizione per l'anomalia rilevata..."></textarea>
					<div style="text-align: right; margin-top: 20px;">
						<input type="button" value="Annulla" class="btn btn-default" onclick="hideAddAnomaliaForm();">&nbsp;<input type="button" value="Salva" class="btn btn-primary" onclick="addNewAnomalia();">
					</div>
				</div>
				<div class="anomalieTable">
					<table class="table table-striped table-valign-middle">
						<thead>
							<tr>
								<th>Descrizione</th>
								<th>Data Inserimento</th>
								<th style="width: 166px;">Stato</th>
							</tr>
						</thead>
						<tbody id="ElencoAnomalie">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-tecnici-intervento">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Elenco Tecnici Intervento</h4>
				<script>
					function hideAddTecnicoForm() {
						$(".addTecnico,.tecniciTable").show();
						$(".addtecnicoForm").hide();
					}
					function showAddTecnicoForm() {
						$(".addTecnico,.tecniciTable").hide();
						$(".addtecnicoForm").show();
					}
					function caricaElencoTecnici()
					{
						$.ajax(`<?php echo $restEntrypoint; ?>/utenti`, {
				        	type: "POST",
							headers: {
									'X-HTTP-Method-Override': 'GET'
									},
				        	contentType: "application/json; charset=utf-8",
				        	data: JSON.stringify({
								roles: ["tecnico"]
							}),
							dataType: "json",
				        	success: function(tecnici) {
								var htmOptionsTecnici = '';
								tecnici.forEach(tecnico => {
									htmOptionsTecnici += `
										<option value="${tecnico.ID_utente}">${tecnico.nome_cognome} (${tecnico.comune})</option>
									`;
								});
								$(".elencoTecnici").html(htmOptionsTecnici);
				        	},
				        	xhrFields: {
				        	    withCredentials: true
				        	},
				        	crossDomain: true
				    	});
					}

					function addTecnico() {
						$.ajax(`<?php echo $restEntrypoint; ?>/intervento/${$('.currentInterventoID').val()}/tecnico/${$('#elencoTecniciEdit').val()}`, {
				    	    type: "POST",
				    	    contentType: "application/json; charset=utf-8",
				    	    success: function(data) {
				    	        location.reload();
				    	    },
				    	    error: function () {
				    	        location.reload();
				    	    },
				    	    xhrFields: {
				    	        withCredentials: true
				    	    },
				    	    crossDomain: true
				    	});
					}
				</script>
				<button type="button" class="addTecnico close" aria-label="Add" title="Aggiungi tecnico all'intervento" onclick="showAddTecnicoForm();">
				 	<span aria-hidden="true">+</span>
				</button>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-left: 0;">
				 	<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="addtecnicoForm" style="display: none;">
					<input type="hidden" class="currentInterventoID" />
					<div class="form-group">
						<label for="elencoTecnici">Seleziona il tecnico interessato</label>
						<select class="form-control elencoTecnici" id="elencoTecniciEdit">
						</select>
					</div>
					<div style="text-align: right; margin-top: 20px;">
						<input type="button" value="Annulla" class="btn btn-default" onclick="hideAddTecnicoForm();">&nbsp;<input type="button" value="Salva" class="btn btn-primary" onclick="addTecnico();">
					</div>
				</div>
				<div class="tecniciTable">
					<table class="table table-striped table-valign-middle">
						<thead>
							<tr>
								<th>Nome Cognome</th>
								<th>Username</th>
								<th>Comune</th>
								<th>E-mail</th>
								<th>Stato Account</th>
								<th>Elimina</th>
							</tr>
						</thead>
						<tbody id="ElencoTecniciTbl">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-aggiungi-intervento">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Aggiungi nuovo Intervento</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="add_interv_frm">
					<div class="form-group">
						<label for="elencoSensoriImpiantoInterv">Seleziona il sensore interessato</label>
						<select class="form-control elencoSensoriImpianto" id="elencoSensoriImpiantoInterv"></select>
					</div>
					<textarea class="form-control descrizioneNuovaAnomaliaInterv" placeholder="Inserisci una descrizione per l'anomalia rilevata..."></textarea>
					<div class="form-group" style="margin-top: 1rem;">
						<label for="elencoTecnici">Seleziona i tecnici a cui assegnare l'intervento</label>
						<select multiple="" required="" id="elencoTecniciAddInterv" class="form-control elencoTecnici"></select>
					</div>
				</form>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
				<button type="button" class="btn btn-primary" onclick="addIntervento();">Aggiungi</button>
			</div>
		</div>
	</div>
</div>

<?php include './views/_partials/modal_modifica_impianto.inc'; ?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gMapsAPIkey; ?>"></script>
<script type="text/javascript">
function populateForm() {
    $("#edit_nome").val(impianto.nome);
    $("#edit_descrizione").val(impianto.descrizione);
    $("#edit_latitudine").val(impianto.latitudine);
    $("#edit_longitudine").val(impianto.longitudine);
    $("#edit_comune").val(impianto.comune);
    $("#edit_intervallo_standard").val(impianto.intervallo_standard);
    $("#edit_intervallo_anomalia").val(impianto.intervallo_anomalia);
}


function editImpianto() {
    $.ajax(`<?php echo $restEntrypoint; ?>/impianto/${ID_impianto}`, {
        type: "POST",
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify({
            nome: $("#edit_nome").val(),
            descrizione: $("#edit_descrizione").val(),
            latitudine: $("#edit_latitudine").val(),
            longitudine: $("#edit_longitudine").val(),
            comune: $("#edit_comune").val(),
            intervallo_standard: $("#edit_intervallo_standard").val(),
            intervallo_anomalia: $("#edit_intervallo_anomalia").val()
        }),
        success: function(data) {
            location.reload();
        },
        error: function () {
            location.reload();
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}

<?php include './views/_partials/fill_comune_function.inc'; ?>
function fillSensore() {
    $.ajax("<?php echo $restEntrypoint; ?>/tipologia/sensori/", {
        type: "GET",
        contentType: "application/json; charset=utf-8",
		dataType: "json",
        success: function(data) {
            var sensori = Array();
            for (const sensore in data) {
                sensori.push(`<option value="${data[sensore].ID_tipologia_sensore}">${data[sensore].produttore} - ${data[sensore].modello} (${data[sensore].descrizione})</option>`);
            }
            $(".fillTipologiaSensore").html(sensori.join(''));
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}

function fillAttuatore() {
    $.ajax("<?php echo $restEntrypoint; ?>/tipologia/attuatori/", {
        type: "GET",
        contentType: "application/json; charset=utf-8",
		dataType: "json",
        success: function(data) {
            var attuatori = Array();
            for (const attuatore in data) {
                attuatori.push(`<option value="${data[attuatore].ID_tipologia_attuatore}">${data[attuatore].produttore} - ${data[attuatore].modello} (${data[attuatore].descrizione})</option>`);
            }
            $(".fillTipologiaAttuatore").html(attuatori.join(''));
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}

function initializeMap()
{
    var mapDiv = document.getElementById('borderless-world');
    var map = new google.maps.Map(mapDiv,
    {
		center: new google.maps.LatLng(impianto.latitudine, impianto.longitudine),
		<?php include './views/_partials/google_maps_style.inc'; ?>
    });
	new google.maps.Marker(
	{
		position: new google.maps.LatLng(impianto.latitudine, impianto.longitudine),
		map: map,
		title: impianto.nome,
		icon: 'dist/img/map_pin.png'
	});
}
function getSensori() {
	$.ajax(`<?php echo $restEntrypoint; ?>/impianto/${ID_impianto}/sensori`, {
        type: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(sensori) {
			var htmSensori = '';
			var htmOptionsSensori = '';
			var htmOptionsTipologieSensori = '';
			sensori.forEach(sensore => {
				htmSensori += `
<tr>
	<td>${sensore.produttore} - ${sensore.modello}</td>
    <td>${new Date(sensore.data_installazione).toLocaleString()}</td>
	<td style="width: 85px; text-align: center;">
		<button type="button" style="display: inline;" title="Mostra letture del sensore" data-toggle="modal" data-target="#modal-letture-sensore" onclick="getLettureSensore(${sensore.ID_sensore_impianto}, '${sensore.unita_misura}', ${sensore.valore_min}, ${sensore.valore_max});" class="btn btn-xs btn-primary">
			<i class="fas fa-list"></i>
		</button>
		<?php if($_SESSION['userInfo']['role'] == 'amministratore') { ?>
		<button type="button" style="display: inline;" title="Elimina sensore" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modal-elimina-sensore" onclick="selectedItemToDelete=${sensore.ID_sensore_impianto};">
			<i class="fas fa-trash"></i>
		</button>
		<?php } ?>
	</td>
</tr>
				`;
				htmOptionsSensori += `<option value="${sensore.ID_sensore_impianto}">${sensore.produttore} - ${sensore.modello}</option>`;
				
				var tmp = `<option value="${sensore.tipologia}">${sensore.produttore} - ${sensore.modello}</option>`
				if(htmOptionsTipologieSensori.indexOf(tmp) == -1) htmOptionsTipologieSensori += tmp;
			});
			$("#elencoSensori").html(htmSensori);
			$(".elencoSensoriImpianto").html(htmOptionsSensori);
			$("#elencoTipologiaSensoriImpianto").html("<option class='selezionaSensorePlaceholder'>Seleziona un sensore...</option>"+htmOptionsTipologieSensori);
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}
function getLettureSensore(idSensore, measureUnit, min, max) {
	$("#unita_misura_lettureSensore").html(measureUnit);
	$.ajax(`<?php echo $restEntrypoint; ?>/sensore/${idSensore}`, {
        type: "POST",
		headers: {
			'X-HTTP-Method-Override': 'GET'
		},
        contentType: "application/json; charset=utf-8",
        dataType: "json",
		data: JSON.stringify({
			numeroLetture: 500
		}),
        success: function(sensori) {
			var htmLettureSensore = '';
			sensori.forEach(sensore => {
				htmLettureSensore += `
<tr>
	<td>${new Date(sensore.data_inserimento).toLocaleString()}</td>
    <td><div style="background-color: #${(sensore.valore < min || sensore.valore > max) ? 'ff00' : '00ff'}006f;text-align: center;">${sensore.valore}</div></td>
</tr>
				`;
			});
			$("#elencoLettureSensore").html(htmLettureSensore);
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}
function getAttuatori() {
	$.ajax(`<?php echo $restEntrypoint; ?>/impianto/${ID_impianto}/attuatori`, {
        type: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(attuatori) {
			var htmAttuatori = '';
			attuatori.forEach(attuatore => {
				htmAttuatori += `
<tr>
	<td>${attuatore.produttore} - ${attuatore.modello}</td>
    <td>${new Date(attuatore.data_installazione).toLocaleString()}</td>
	<td style="width: 85px; text-align: center;">
		<button type="button" style="display: inline;" title="Mostra letture dell'attuatore" data-toggle="modal" data-target="#modal-operazioni-attuatore" onclick="getOperazioniAttuatore(${attuatore.ID_attuatore_impianto}, '${attuatore.unita_misura}', ${attuatore.valore_min}, ${attuatore.valore_max}, '${attuatore.tipo_valore}');" class="btn btn-xs btn-primary">
			<i class="fas fa-list"></i>
		</button>
		<?php if($_SESSION['userInfo']['role'] == 'amministratore') { ?>
		<button type="button" style="display: inline;" title="Elimina attuatore" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modal-elimina-attuatore" onclick="selectedItemToDelete=${attuatore.ID_attuatore_impianto};">
			<i class="fas fa-trash"></i>
		</button>
		<?php } ?>
	</td>
</tr>
				`;
			});
			$("#elencoAttuatori").html(htmAttuatori);
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}
function getOperazioniAttuatore(idAttuatore, measureUnit, min, max, type) {
	hideAddOperazioneForm();
	$(".currentAttuatoreID").val(idAttuatore);
	$("#valoreOperazione").attr("min", min).attr("max", max).attr("step", (type == 'int') ? 1 : 0.01);
	$("#unita_misura_operazioniAttuatore").html(measureUnit);
	$.ajax(`<?php echo $restEntrypoint; ?>/attuatore/${idAttuatore}`, {
        type: "POST",
		headers: {
			'X-HTTP-Method-Override': 'GET'
		},
        contentType: "application/json; charset=utf-8",
        dataType: "json",
		data: JSON.stringify({
			numeroOperazioni: 500
		}),
        success: function(attuatori) {
			var htmOperazioniAttuatore = '';
			attuatori.forEach(attuatore => {
				htmOperazioniAttuatore += `
<tr>
	<td>${new Date(attuatore.data_inserimento).toLocaleString()}</td>
    <td><div style="background-color: #${(attuatore.valore < min || attuatore.valore > max) ? 'ff00' : '00ff'}006f;text-align: center;">${attuatore.valore}</div></td>
	<td style="text-align: center;"><span style="color: ${(attuatore.conferma_lettura) ? '#67B1FF' : '#AAA'};" class="fas fa-check"></span></td>
</tr>
				`;
			});
			$("#elencoOperazioniAttuatore").html(htmOperazioniAttuatore);
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}


function getDettagliIntervento(idIntervento) {
	$.ajax(`<?php echo $restEntrypoint; ?>/intervento/${idIntervento}`, {
        type: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(dettagli) {
			$("#tabellaDettagliIntervento").html(`<table>
				<tr>
					<td><b>Data inserimento</b></td>
					<td>${new Date(dettagli.data_inserimento).toLocaleString()}</td>
				</tr>
				<tr>
					<td><b>Data inizio</b></td>
					<td>${dettagli.data_inizio ? new Date(dettagli.data_inizio).toLocaleString() : '-'}</td>
				</tr>
				<tr>
					<td><b>Data fine</b></td>
					<td>${dettagli.data_fine ? new Date(dettagli.data_fine).toLocaleString() : '-'}</td>
				</tr>
				<tr>
					<td><b>Stato</b></td>
					<td>${dettagli.stato}</td>
				</tr>
			</table>`);
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}
function updateStatoAnomalia(idAnomalia, descrizione, sensore, stato) {
	$.ajax(`<?php echo $restEntrypoint; ?>/anomalia/${idAnomalia}`, {
        type: "POST",
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify({
            descrizione: descrizione,
			sensore: sensore,
			stato: stato
        }),
        success: function(data) {
            location.reload();
        },
        error: function () {
            location.reload();
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}
function addslashes(str) {
    str = str.replace(/\\/g, '\\\\');
    str = str.replace(/\'/g, '\\\'');
    str = str.replace(/\"/g, '\\"');
    str = str.replace(/\0/g, '\\0');
    return str;
}
function getAnomalieIntervento(idIntervento) {
	hideAddAnomaliaForm();
	$(".currentInterventoID").val(idIntervento);
	$.ajax(`<?php echo $restEntrypoint; ?>/intervento/${idIntervento}/anomalie`, {
        type: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
		success: function(anomalie) {
			var htmElencoAnomalie = '';
			anomalie.forEach(anomalia => {
				htmElencoAnomalie += `
				<tr>
<td>${anomalia.descrizione}</td>
	<td>${new Date(anomalia.data_segnalazione).toLocaleString()}</td>
	<td>
	<select style="border: 0;" class="form-control" onchange="updateStatoAnomalia(${anomalia.ID_anomalia}, '${addslashes(anomalia.descrizione)}', ${anomalia.sensore}, $(this).val());">
		<option value="inserito" ${(anomalia.stato == 'inserito') ? 'selected' : ''} ${(anomalia.stato != 'inserito') ? 'disabled' : ''}>inserito</option>
		<option value="in corso" ${(anomalia.stato == 'in corso') ? 'selected' : ''} ${(anomalia.stato != 'inserito' && anomalia.stato != 'in corso') ? 'disabled' : ''}>in corso</option>
		<option value="risolto" ${(anomalia.stato == 'risolto') ? 'selected' : ''}  ${(anomalia.stato == 'non risolvibile') ? 'disabled' : ''}>risolto</option>
		<option value="non risolvibile" ${(anomalia.stato == 'non risolvibile') ? 'selected' : ''}  ${(anomalia.stato == 'risolto') ? 'disabled' : ''}>non risolvibile</option>
	</select>
	</td>
</tr>

				`;
			});
			$("#ElencoAnomalie").html(htmElencoAnomalie);
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}

function getGraficoSensore(ID_sensore) {
	$.ajax(`<?php echo $restEntrypoint; ?>/statistiche/impianto/${ID_impianto}`, {
        type: "POST",
		headers: {
				'X-HTTP-Method-Override': 'GET'
				},
        contentType: "application/json; charset=utf-8",
        dataType: "json",
		data: JSON.stringify({
			tipologia: ID_sensore
		}),
		success: function(statistiche) {
			var labels = Array();
			statistiche.letture.forEach(lettura => {labels.push(new Date(lettura.x).toLocaleDateString() + ' ' + new Date(lettura.x).toLocaleTimeString());});
			config.data.labels = labels;
			config.data.datasets.splice(0, 1);
			var newColor = "rgb(255, 99, 132)";
			var newDataset = {
				label: statistiche.descrizione + ' [' + statistiche.unita_misura + ']',
				backgroundColor: newColor,
				borderColor: newColor,
				data: statistiche.letture,
				fill: false
			};
			config.data.datasets.push(newDataset);
			window.myLine.update();
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}

function getElencoTecnici(idIntervento) {
	$(".currentInterventoID").val(idIntervento);
	hideAddTecnicoForm();
	$.ajax(`<?php echo $restEntrypoint; ?>/intervento/${idIntervento}/tecnici`, {
        type: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
		success: function(tecnici) {
			var htmElencoTecnici = '';
			tecnici.forEach(tecnico => {
				htmElencoTecnici += `
<tr>
<td>${tecnico.nome_cognome}</td>
	<td>${tecnico.username ? tecnico.username : '-'}</td>
	<td>${tecnico.comune}</td>	
	<td>${tecnico.email}</td>
	<td>${tecnico.stato_account}</td>
	<td><?php if($_SESSION['userInfo']['role'] != 'tecnico') { ?>
		<button type="button" style="display: inline;" title="Elimina tecnico" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modal-elimina-tecnico-intervento" onclick="ID_intervento = ${idIntervento};ID_tecnico_toDelete=${tecnico.ID_utente};">
			<i class="fas fa-trash"></i>
		</button>
		<?php } ?>
		</td>
    
</tr>
				`;
			});
			$("#ElencoTecniciTbl").html(htmElencoTecnici);
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}
function resetAddIntervento() {
	$("#descrizioneNuovaAnomaliaInterv").val("");
	$("#elencoTecniciAddInterv").removeClass("is-invalid");
}
function getInterventi() {
	$.ajax(`<?php echo $restEntrypoint; ?>/impianto/${ID_impianto}/interventi`, {
        type: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
		success: function(interventi) {
			var htmInterventi = '';
			interventi.forEach(intervento => {
				htmInterventi+= `
				<tr>
					<td>${new Date(intervento.data_inserimento).toLocaleString()}</td>
					<td>${intervento.stato}</td>
				    <td style="width: 110px; text-align: center;">
						<button type="button" style="display: inline;" title="Mostra informazioni intervento" data-toggle="modal" data-target="#modal-info-intervento" onclick="getDettagliIntervento(${intervento.ID_intervento});" class="btn btn-xs btn-primary">
							<i class="fa fa-info-circle" aria-hidden="true"></i>
						</button>
						<button type="button" style="display: inline;" title="Mostra elenco anomalie intervento" data-toggle="modal" data-target="#modal-anomalie-intervento" onclick="getAnomalieIntervento(${intervento.ID_intervento});" class="btn btn-xs btn-primary">
							<i class="fas fa-list"></i>
						</button>
						<button type="button" style="display: inline;" title="Elenco tecnici intervento" data-toggle="modal" data-target="#modal-tecnici-intervento" onclick="getElencoTecnici(${intervento.ID_intervento});" class="btn btn-xs btn-primary">
							<i class="fas fa-address-book"></i>
						</button>
					</td>
				</tr>
				`;
			});
			$("#elencoInterventi").html(htmInterventi);
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}

function deleteElement(elementType) {
    $.ajax(`<?php echo $restEntrypoint; ?>/${elementType}/${selectedItemToDelete}`, {
    	type: "DELETE",
    	contentType: "application/json; charset=utf-8",
    	success: function(data) {
    	    location.reload();
    	},
    	error: function () {
    	    location.reload();
    	},
    	xhrFields: {
    	    withCredentials: true
    	},
    	crossDomain: true
    });
}
function deleteTecnico()
{ $.ajax(`<?php echo $restEntrypoint; ?>/intervento/${ID_intervento}/tecnico/`+ ID_tecnico_toDelete, {
    	type: "DELETE",
    	contentType: "application/json; charset=utf-8",
    	success: function(data) {
    	    location.reload();
    	},
    	error: function () {
    	    location.reload();
    	},
    	xhrFields: {
    	    withCredentials: true
    	},
    	crossDomain: true
    });


}
function addSensore() {
    $.ajax(`<?php echo $restEntrypoint; ?>/impianto/${ID_impianto}/sensore/${
		$('#add_tipologia_sensore').val()
	}`, {
        type: "POST",
        success: function(data) {
            location.reload();
        },
        error: function () {
            location.reload();
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}

function addAttuatore() {
    $.ajax(`<?php echo $restEntrypoint; ?>/impianto/${ID_impianto}/attuatore/${
		$('#add_tipologia_attuatore').val()
	}`, {
        type: "POST",
        success: function(data) {
            location.reload();
        },
        error: function () {
            location.reload();
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}

function addIntervento() {
	if($("#add_interv_frm")[0].checkValidity()) {
		$.ajax("<?php echo $restEntrypoint; ?>/intervento", {
    	    type: "POST",
    	    contentType: "application/json; charset=utf-8",
        	dataType: "json",
    	    success: function(intvID) {
				let semaforo=1;
				const checkSemaforo = function(){ // niente di troppo complesso, JS è single-threaded
					if(semaforo==0) location.reload();
					else setTimeout(checkSemaforo, 100);
				}
				$.ajax(`<?php echo $restEntrypoint; ?>/intervento/${intvID.ID}/anomalia`, {
				    type: "POST",
				    contentType: "application/json; charset=utf-8",
				    data: JSON.stringify({
				        descrizione: $(".descrizioneNuovaAnomaliaInterv").val(),
						sensore: $("#elencoSensoriImpiantoInterv").val()
				    }),
				    success: function(data) {
						checkSemaforo();
				    },
				    error: function () {
						checkSemaforo();
				    },
				    xhrFields: {
				        withCredentials: true
				    },
				    crossDomain: true
				});
				const tecnici = $("#elencoTecniciAddInterv").val();
				semaforo = tecnici.length;
				tecnici.forEach(tecnicoID => {
					$.ajax(`<?php echo $restEntrypoint; ?>/intervento/${intvID.ID}/tecnico/${tecnicoID}`, {
				    	type: "POST",
				    	contentType: "application/json; charset=utf-8",
				    	data: JSON.stringify({
				    	    descrizione: $(".descrizioneNuovaAnomaliaInterv").val(),
							sensore: $("#elencoSensoriImpiantoInterv").val()
				    	}),
				    	success: function(data) {
							semaforo--;
				    	},
				    	error: function () {
							semaforo--;
				    	},
				    	xhrFields: {
				    	    withCredentials: true
				    	},
				    	crossDomain: true
					});
				})
    	    },
    	    error: function () {
    	        location.reload();
    	    },
    	    xhrFields: {
    	        withCredentials: true
    	    },
    	    crossDomain: true
    	});
	} else $("#elencoTecniciAddInterv").addClass("is-invalid");
}

document.addEventListener('DOMContentLoaded', function() {
    $.ajax(`<?php echo $restEntrypoint; ?>/impianti`, {
        type: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data) {
			data.forEach(imp => {
				if(imp.ID_impianto == ID_impianto) {
					impianto = imp;
            		initializeMap();
					$("#detailsTable_nome").html(impianto.nome);
					$("#detailsTable_descrizione").html(impianto.descrizione);
					$("#detailsTable_intervallo_standard").html(impianto.intervallo_standard);
					$("#detailsTable_intervallo_anomalia").html(impianto.intervallo_anomalia);
				}
			});
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
	fillComune();
	fillSensore();
	fillAttuatore();
	getSensori();
	getAttuatori();
	getInterventi();
	caricaElencoTecnici();
}, false);
</script>

<?php
	$DELETE_MODAL_ID = "modal-elimina-sensore";
	$DELETE_MODAL_TITLE = "Conferma eliminazione sensore";
	$DELETE_MODAL_BODY = "Sei sicuro di voler rimuovere il sensore dall'impianto?";
	$DELETE_MODAL_ACTION = "deleteElement('sensore');";
	include './views/_partials/modal_elimina_elemento.inc';
	
	$DELETE_MODAL_ID = "modal-elimina-attuatore";
	$DELETE_MODAL_TITLE = "Conferma eliminazione attuatore";
	$DELETE_MODAL_BODY = "Sei sicuro di voler rimuovere il attuatore dall'impianto?";
	$DELETE_MODAL_ACTION = "deleteElement('attuatore');";
	include './views/_partials/modal_elimina_elemento.inc';
	
	$DELETE_MODAL_ID = "modal-elimina-tecnico-intervento";
	$DELETE_MODAL_TITLE = "Conferma eliminazione tecnico";
	$DELETE_MODAL_BODY = "Sei sicuro di voler rimuovere il tecnico dall'intervento?";
	$DELETE_MODAL_ACTION = "deleteTecnico();";
	include './views/_partials/modal_elimina_elemento.inc';
?>


<div class="modal fade" id="modal-aggiungi-sensore">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Aggiungi nuovo sensore</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <form id="add_frm">
                	<div class="form-group">
                		<label for="add_tipologia_sensore">Tipologia</label>
						<select id="add_tipologia_sensore" required class="form-control fillTipologiaSensore">
                        </select>
                	</div>
                </form>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
				<button type="button" class="btn btn-primary" onclick="addSensore();">Aggiungi</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-aggiungi-attuatore">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Aggiungi nuovo attuatore</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <form id="add_frm">
                	<div class="form-group">
                		<label for="add_tipologia_attuatore">Tipologia</label>
						<select id="add_tipologia_attuatore" required class="form-control fillTipologiaAttuatore">
                        </select>
                	</div>
                </form>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
				<button type="button" class="btn btn-primary" onclick="addAttuatore();">Aggiungi</button>
			</div>
		</div>
	</div>
</div>
