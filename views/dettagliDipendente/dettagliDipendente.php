<script>
    const ID_utente = <?php echo intval($_GET['ID']); ?>;
    let utente,impianto;
</script>

<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">Dettagli Utente</h5>
				<div class="card-tools">
				<?php if($_SESSION['userInfo']['role'] == 'amministratore') { ?>
                    <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-modifica-dettagli-utente" onclick="populateForm();" >
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
						<td style="width: 110px;"><b>Nome Cognome</b></td>
						<td id="detailsTable_NomeCognome">...</td>
					</tr>
					<tr style="background: #ededed;">
						<td><b>Comune</b></td>
						<td id="detailsTable_comune">...</td>
					</tr>
					<tr >
						<td><b>Username</b></td>
						<td id="detailsTable_username">...</td>
					</tr>
					<tr style="background: #ededed;" >
						<td><b>email</b></td>
						<td id="detailsTable_email">...</td>
					</tr>
                    <tr>
						<td><b>Stato Account</b></td>
						<td id="detailsTable_StatoAccount">...</td>
					</tr>
                    <tr style="background: #ededed;" >
						<td><b>Tipologia</b></td>
						<td id="detailsTable_tipologia">...</td>
					</tr>
				</table>
			</div>
		</div>
	</div> 
    <div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">Impianti Assegnati</h5>
				<div class="card-tools">
                <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-aggiungi-impianto-assegnato">
					    <i class="fas fa-plus"></i>
					</button>
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
					    <i class="fas fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="card-body table-responsive p-0">
				<table class="table table-striped table-valign-middle">
					<thead>
						<tr>
							<th>Nome Impianto</th>
							<th>Comune</th>
                            <th>Permesso di Scrittura</th>
                            <th>Azioni</th>
						</tr>
					</thead>
					<tbody id="elencoImpiantiAssegnati">
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">Visualizzazione sulla mappa degli impianti assegnati</h5>
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
</div>
 

    
    <?php include './views/_partials/modal-modifica-dettagli-utente.inc'; ?>
    <?php include './views/_partials/modal-elimina-impianto-assegnato.inc'; ?>
    <?php include './views/_partials/modal-aggiungi-impianto-assegnato.inc'; ?>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gMapsAPIkey; ?>"></script>
    <script type="text/javascript">
    <?php include './views/_partials/fill_comune_function.inc'; ?>
    
	document.addEventListener('DOMContentLoaded', function() {
    $.ajax(`<?php echo $restEntrypoint; ?>/utente/${ID_utente}`, { 
        type: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(ut) {
				if(ut.ID_utente == ID_utente) {
					utente = ut;
					$("#detailsTable_NomeCognome").html(utente.nome_cognome);
					$("#detailsTable_comune").html(utente.comune);
					$("#detailsTable_username").html(utente.username);
					$("#detailsTable_email").html(utente.email);
                    $("#detailsTable_StatoAccount").html(utente.stato_account);
                    $("#detailsTable_tipologia").html(utente.tipologia);
				}	
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
	fillComune();
    getImpiantiAssegnati();
    getImpianti();
    getImpiantiAssegnatiMappa();
}, false);
function initializeMap(impianti)
{
	let centerLat = 0, centerLng = 0;
	impianti.forEach(impianto => {
		centerLat += impianto.latitudine;
		centerLng += impianto.longitudine;
	});
	centerLat /= impianti.length;
	centerLng /= impianti.length;

	var mapDiv = document.getElementById('borderless-world');
	var map = new google.maps.Map(mapDiv,
	{
		center: new google.maps.LatLng(centerLat, centerLng),
		<?php include './views/_partials/google_maps_style.inc'; ?>
	});
	
	
	impianti.forEach(impianto => {
	const infowindow = new google.maps.InfoWindow({
		content: `
<table>
	<tbody>
		<tr>
			<td style="width: 90px;"><b>Nome</b></td>
			<td>${impianto.nome}</td>
		</tr>
		<tr style="background: #ededed;">
			<td><b>Descrizione</b></td>
			<td>${impianto.descrizione}</td>
		</tr>
		<tr>
			<td><b>Intervallo di trasmissione standard (s)</b></td>
			<td>${impianto.intervallo_standard}</td>
		</tr>
		<tr style="background: #ededed;">
			<td><b>Intervallo di trasmissione anomalia (s)</b></td>
			<td>${impianto.intervallo_anomalia}</td>
		</tr>
	</tbody>
</table>
<br><button type="button" class="btn btn-block btn-primary btn-sm" onclick="window.location = '/?p=dettagliImpianto&ID=${impianto.ID_impianto}';">Vai a dettagli impianto</button>
`
		});
		const marker = new google.maps.Marker(
		{
			position: new google.maps.LatLng(impianto.latitudine, impianto.longitudine),
			map: map,
			title: impianto.nome,
			icon: 'dist/img/map_pin.png'
		});
		google.maps.event.addListener(marker, 'click', function() {infowindow.open(map, marker);});
	});
}
function populateForm() {
    $("#edit_nome_cognome").val(utente.nome_cognome);
    $("#edit_comune").val(utente.comune);
    $("#edit_username").val(utente.username);
    $("#edit_email").val(utente.email);
    $("#edit_stato_account").val(utente.stato_account);
    $("#edit_tipologia").val(utente.tipologia);
}
function EditInformazioniDipendente() {
    $.ajax(`<?php echo $restEntrypoint; ?>/utente/${ID_utente}`, {
        type: "POST",
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify({
            nome_cognome: $("#edit_nome_cognome").val(),
            comune: $("#edit_comune").val(),
            username: $("#edit_username").val(),
            email: $("#edit_email").val(),
            stato_account: $("#edit_stato_account").val(),
            tipologia: $("#edit_tipologia").val()
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
function getImpiantiAssegnati()
{$.ajax(`<?php echo $restEntrypoint; ?>/utente/${ID_utente}/impianti`, {
    type: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(impianti) {
			var htmImpianti = '';
			impianti.forEach(impianto => { 
				htmImpianti += `
<tr>
	<td>${impianto.nome}</td>
    <td>${impianto.comune}</td>
    <td>${impianto.flag_permesso ? 'Abilitato' : 'Disabilitato'}</td>
    <td style="width: 85px; text-align: center;">
    <button type="button" style="display: inline;" title="Elimina Impianto Assegnato" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modal-elimina-impianto-assegnato" onclick="ImpiantotoDelete=${impianto.ID_impianto};">
	<i class="fas fa-trash"></i>
	</button>
    </td>
</tr>
				`;
			});
			$("#elencoImpiantiAssegnati").html(htmImpianti);
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}
function getImpiantiAssegnatiMappa()
{$.ajax(`<?php echo $restEntrypoint; ?>/utente/${ID_utente}/impianti`, {
    type: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data) {
            initializeMap(data);
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}
function EliminaImpiantoAssegnato()
{ $.ajax(`<?php echo $restEntrypoint; ?>/dipendente/${ID_utente}/impianto/${ImpiantotoDelete}`, {
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

function AggiungiImpiantoAssegnato() {
    $.ajax(`<?php echo $restEntrypoint; ?>/dipendente/${ID_utente}/impianto/${$('#add_ImpiantoAssegnato').val()}`, {
        type: "POST",
		data: JSON.stringify({
			"modificabile": ($('#add_permesso').val() == 1)
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

function getImpianti()
{
    $.ajax(`<?php echo $restEntrypoint; ?>/impianti`, { 
        type: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(impianti) {
			var htmOptionsImpianti = '';
            impianti.forEach(impianto => {
				htmOptionsImpianti += `<option value="${impianto.ID_impianto}">${impianto.nome} - ${impianto.descrizione } (${impianto.comune})</option>`;
				
			});
			
			$("#add_ImpiantoAssegnato").html(htmOptionsImpianti);
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}
</script>