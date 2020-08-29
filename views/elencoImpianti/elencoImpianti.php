<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Mappa impianti</h3>
                <div class="card-tools">
                    <button type="button" data-toggle="modal" data-target="#modal-aggiungi-impianto" class="btn btn-tool"><i class="fas fa-file"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
			</div>
			<div class="card-body">
                <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gMapsAPIkey; ?>"></script>
	            <script type="text/javascript">

	            	function initialize()
	            	{
						let centerLat = 0, centerLng = 0;
						$.ajax("<?php echo $restEntrypoint; ?>/impianti", {
    				    	type: "GET",
    					    contentType: "application/json; charset=utf-8",
							dataType: "json",
    					    success: function(impianti) {
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
    					    },
    					    xhrFields: {
    					        withCredentials: true
    					    },
    					    crossDomain: true
    					});
	            	}
					
					google.maps.event.addDomListener(window, 'load', initialize);
	            </script>
	            <div id="borderless-world" style="height: 500px; width: 100%"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Elenco impianti</h3>
                <div class="card-tools">
                    <button type="button" data-toggle="modal" data-target="#modal-aggiungi-impianto" class="btn btn-tool"><i class="fas fa-file"></i></button>
                </div>
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<table id="tabellaImpianti" class="table table-bordered table-striped">
					<thead>
						<tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Descrizione</th>
                            <th>Latitudine</th>
                            <th>Longitudine</th>
                            <th>Comune</th>
                            <th>Intervallo di trasmissione standard (s)</th>
                            <th>Intervallo di trasmissione anomalia (s)</th>
                            <th style="width: 125px;" data-priority="1">Azioni</th>
						</tr>
					</thead>
					<tbody></tbody>
					<tfoot>
						<tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Descrizione</th>
                            <th>Latitudine</th>
                            <th>Longitudine</th>
                            <th>Comune</th>
                            <th>Intervallo di trasmissione standard (s)</th>
                            <th>Intervallo di trasmissione anomalia (s)</th>
                            <th style="width: 125px;" data-priority="1">Azioni</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
var selectedItemToDelete = null;
var selectedItemToEdit = null;
function deleteElement() {
    $.ajax("<?php echo $restEntrypoint; ?>/impianto/" + selectedItemToDelete, {
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
function addImpianto() {
    $.ajax("<?php echo $restEntrypoint; ?>/impianto", {
        type: "POST",
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify({
            nome: $("#add_nome").val(),
            descrizione: $("#add_descrizione").val(),
            latitudine: $("#add_latitudine").val(),
            longitudine: $("#add_longitudine").val(),
            comune: $("#add_comune").val(),
            intervallo_standard: $("#add_intervallo_standard").val(),
            intervallo_anomalia: $("#add_intervallo_anomalia").val()
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
function populateForm(object) {
    object = JSON.parse(decodeURIComponent(object));
    $("#edit_nome").val(object.nome);
    $("#edit_descrizione").val(object.descrizione);
    $("#edit_latitudine").val(object.latitudine);
    $("#edit_longitudine").val(object.longitudine);
    $("#edit_comune").val(object.comune);
    $("#edit_intervallo_standard").val(object.intervallo_standard);
    $("#edit_intervallo_anomalia").val(object.intervallo_anomalia);
}
function editImpianto() {
    $.ajax("<?php echo $restEntrypoint; ?>/impianto/" + selectedItemToEdit, {
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

document.addEventListener('DOMContentLoaded', function() {
    $("#tabellaImpianti").DataTable({
        responsive: true,
        autoWidth: false,
        ajax: {
            url: "<?php echo $restEntrypoint; ?>/impianti",
            type: "GET",
            contentType: "application/json; charset=utf-8",
            xhrFields: {
                withCredentials: true
            },
            crossDomain: true,
            dataSrc: ""
        },
        columns: [
            { data: "ID_impianto" },
            { data: "nome", defaultContent: "-"  },
            { data: "descrizione", defaultContent: "-" },
            { data: "latitudine" },
            { data: "longitudine" },
            { data: "comune" },
            { data: "intervallo_standard" },
            { data: "intervallo_anomalia" },
            {
                data: null,
                render: function ( data, type, row ) {
                    return `<button type="button" title="Modifica impianto" class="btn btn-primary" data-toggle="modal" data-target="#modal-modifica-impianto" onclick="selectedItemToEdit=${row.ID_impianto}; populateForm('${encodeURIComponent(JSON.stringify(row))}');" style="width: 45px;">
                                <span class="fas fa-edit"></span>
                            </button>
                            <button type="button" title="Vai ai dettagli dell'impianto" class="btn btn-success" onclick="window.location = '/?p=dettagliImpianto&ID=${row.ID_impianto}';" style="width: 45px;">
                                <span class="fas fa-list"></span>
                            </button>
                            <button type="button" title="Elimina impianto" class="btn btn-danger" data-toggle="modal" data-target="#modal-elimina-impianto" onclick="selectedItemToDelete=${row.ID_impianto};" style="width: 45px;">
                                <span class="fas fa-trash"></span>
                            </button>`;
                }
            }
        ]
    });
    fillComune();
}, false);
</script>

<?php
	$DELETE_MODAL_ID = "modal-elimina-impianto";
	$DELETE_MODAL_TITLE = "Conferma eliminazione impianto";
	$DELETE_MODAL_BODY = "Sei sicuro di voler rimuovere l'impianto dal sistema?";
	include './views/_partials/modal_elimina_elemento.inc';
?>

<?php include './views/_partials/modal_aggiungi_impianto.inc'; ?>
<?php include './views/_partials/modal_modifica_impianto.inc'; ?>