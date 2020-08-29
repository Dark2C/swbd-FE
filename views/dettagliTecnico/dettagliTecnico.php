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
				<h5 class="card-title">Elenco Accessi Tecnico</h5>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
					    <i class="fas fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="card-body table-responsive p-0">
				<table class="table table-striped table-valign-middle">
					<thead>
						<tr>
							<th>#</th>
							<th>Data Accesso</th>
						</tr>
					</thead>
					<tbody id="elencoAccessi">
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">Elenco Impianti Assegnati</h5>
				<div class="card-tools">
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
							<th>Descrizione</th>
                            <th>Permesso di Scrittura</th>
                            <th></th>
						</tr>
					</thead>
					<tbody id="elencoImpiantiAssegnatiTecnico">
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php include './views/_partials/modal-modifica-dettagli-utente.inc'; ?>
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
    getAccessi();
	getImpiantiAssegnatiTecnico();
}, false);

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
function getAccessi() {
	$.ajax(`<?php echo $restEntrypoint; ?>/utente/${ID_utente}/accessi`, {
        type: "POST",
		headers: {
			'X-HTTP-Method-Override': 'GET'
		},
        contentType: "application/json; charset=utf-8",
        dataType: "json",
		data: JSON.stringify({
			intervallo: 100
		}),
        success: function(accessi) {
			var htmAccessi = '';
			accessi.forEach(accesso => {
				htmAccessi += `
        <tr>
	        <td>${accesso.ID}</td>
            <td>${new Date(accesso.data_rilevazione).toLocaleString()}</td>
        </tr>
				`;
			});
			$("#elencoAccessi").html(htmAccessi);
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}
function getImpiantiAssegnatiTecnico()
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
	<td>${impianto.descrizione}</td>
    <td>${impianto.flag_permesso ? 'Abilitato' : 'Disabilitato'}</td>
    <td style="width: 250px; text-align: center;">
	<a href="/?p=dettagliImpianto&ID=${impianto.ID_impianto}">Vai a dettagli impianto</a>
    </td>
</tr>
				`;
			});
			$("#elencoImpiantiAssegnatiTecnico").html(htmImpianti);
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}
</script>