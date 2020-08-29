

<?php
	if($_SESSION['userInfo']['role'] == 'amministratore') {
	?>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Elenco tipologie sensori</h3>
                <div class="card-tools">
                    <button type="button" data-toggle="modal" data-target="#modal-aggiungi" class="btn btn-tool"><i class="fas fa-file"></i></button>
                </div>
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<table id="tabellaSensori" class="table table-bordered table-striped">
					<thead>
						<tr>
                            <th>#</th>
                            <th>Produttore</th>
                            <th>Modello</th>
                            <th>Descrizione</th>
                            <th>Valore minimo</th>
                            <th>Valore massimo</th>
                            <th>Unit&agrave; di misura</th>
                            <th>Unit&agrave; di misura integrale</th>
                            <th>Coefficiente per calcolo integrale</th>
                            <th style="width: 80px;" data-priority="1">Azioni</th>
						</tr>
					</thead>
					<tbody></tbody>
					<tfoot>
						<tr>
                            <th>#</th>
                            <th>Produttore</th>
                            <th>Modello</th>
                            <th>Descrizione</th>
                            <th>Valore minimo</th>
                            <th>Valore massimo</th>
                            <th>Unit&agrave; di misura</th>
                            <th>Unit&agrave; di misura integrale</th>
                            <th>Coefficiente per calcolo integrale</th>
                            <th style="width: 80px;" data-priority="1">Azioni</th>
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
    $.ajax("<?php echo $restEntrypoint; ?>/tipologia/sensore/" + selectedItemToDelete, {
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
function addElement() {
    $.ajax("<?php echo $restEntrypoint; ?>/tipologia/sensori", {
        type: "POST",
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify({
            produttore: $("#add_produttore").val(),
            modello: $("#add_modello").val(),
            descrizione: $("#add_descrizione").val(),
            valore_min: $("#add_vMin").val(),
            valore_max: $("#add_vMax").val(),
            unita_misura: $("#add_measureUnit").val(),
            unita_misura_integrale: $("#add_measureUnitIntegral").val(),
            coeff_integrale: $("#add_coeffInt").val()
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
    $("#edit_produttore").val(object.produttore);
    $("#edit_modello").val(object.modello);
    $("#edit_descrizione").val(object.descrizione);
    $("#edit_vMin").val(object.valore_min);
    $("#edit_vMax").val(object.valore_max);
    $("#edit_measureUnit").val(object.unita_misura);
    $("#edit_measureUnitIntegral").val(object.unita_misura_integrale);
    $("#edit_coeffInt").val(object.coeff_integrale);
}
function editElement() {
    $.ajax("<?php echo $restEntrypoint; ?>/tipologia/sensore/" + selectedItemToEdit, {
        type: "POST",
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify({
            produttore: $("#edit_produttore").val(),
            modello: $("#edit_modello").val(),
            descrizione: $("#edit_descrizione").val(),
            valore_min: $("#edit_vMin").val(),
            valore_max: $("#edit_vMax").val(),
            unita_misura: $("#edit_measureUnit").val(),
            unita_misura_integrale: $("#edit_measureUnitIntegral").val(),
            coeff_integrale: $("#edit_coeffInt").val()
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
document.addEventListener('DOMContentLoaded', function() {
    $("#tabellaSensori").DataTable({
        responsive: true,
        autoWidth: false,
        ajax: {
            url: "<?php echo $restEntrypoint; ?>/tipologia/sensori",
            type: "GET",
            contentType: "application/json; charset=utf-8",
            xhrFields: {
                withCredentials: true
            },
            crossDomain: true,
            dataSrc: ""
        },
        columns: [
            { data: "ID_tipologia_sensore" },
            { data: "produttore" },
            { data: "modello" },
            { data: "descrizione" },
            { data: "valore_min" },
            { data: "valore_max" },
            { data: "unita_misura", defaultContent: "-" },
            { data: "unita_misura_integrale", defaultContent: "-" },
            { data: "coeff_integrale", defaultContent: "-" },
            {
                data: null,
                render: function ( data, type, row ) {
                    return `<button type="button" title="Modifica dettagli" class="btn btn-primary" data-toggle="modal" data-target="#modal-modifica" onclick="selectedItemToEdit=${row.ID_tipologia_sensore}; populateForm('${encodeURIComponent(JSON.stringify(row))}');" style="width: 45px;">
                                <span class="fas fa-edit"></span>
                            </button>
                            <button type="button" title="Elimina tipologia sensore" class="btn btn-danger" data-toggle="modal" data-target="#modal-elimina" onclick="selectedItemToDelete=${row.ID_tipologia_sensore};" style="width: 45px;">
                                <span class="fas fa-trash"></span>
                            </button>`;
                }
            }
        ]
    });
}, false);
</script>

<?php
	$DELETE_MODAL_TITLE = "Conferma eliminazione sensore";
	$DELETE_MODAL_BODY = "Sei sicuro di voler rimuovere la tipologia di sensore dal sistema?";
	include './views/_partials/modal_elimina_elemento.inc';
?>

<div class="modal fade" id="modal-aggiungi">
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
                		<label for="add_produttore">Produttore</label>
                		<input class="form-control" required id="add_produttore" placeholder="Produttore">
                	</div>
                	<div class="form-group">
                		<label for="add_modello">Modello</label>
                		<input class="form-control" required id="add_modello" placeholder="Modello">
                	</div>
                	<div class="form-group">
                		<label for="add_descrizione">Descrizione</label>
                		<input class="form-control" required id="add_descrizione" placeholder="Descrizione">
                	</div>
                	<div class="form-group">
                		<label for="add_vMin">Valore minimo</label>
                		<input type="number" class="form-control" required id="add_vMin" placeholder="Valore minimo">
                	</div>
                	<div class="form-group">
                		<label for="add_vMax">Valore massimo</label>
                		<input type="number" class="form-control" required id="add_vMax" placeholder="Valore massimo">
                	</div>
                	<div class="form-group">
                		<label for="add_measureUnit">Unit&agrave; di misura</label>
                		<input class="form-control" id="add_measureUnit" required placeholder="Unit&agrave; di misura">
                	</div>
                	<div class="form-group">
                		<label for="add_measureUnitIntegral">Unit&agrave; di misura integrale</label>
                		<input class="form-control" id="add_measureUnitIntegral" placeholder="Unit&agrave; di misura integrale">
                	</div>
                	<div class="form-group">
                		<label for="add_coeffInt">Coefficiente integrale</label>
                		<input type="number" class="form-control" id="add_coeffInt" placeholder="Coefficiente integrale">
                	</div>
                </form>

			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
				<button type="button" class="btn btn-primary" onclick="addElement();">Aggiungi</button>
			</div>
		</div>
	</div>
</div>



<div class="modal fade" id="modal-modifica">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Modifica sensore</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <form id="edit_frm">
                	<div class="form-group">
                		<label for="edit_produttore">Produttore</label>
                		<input class="form-control" required id="edit_produttore" placeholder="Produttore">
                	</div>
                	<div class="form-group">
                		<label for="edit_modello">Modello</label>
                		<input class="form-control" required id="edit_modello" placeholder="Modello">
                	</div>
                	<div class="form-group">
                		<label for="edit_descrizione">Descrizione</label>
                		<input class="form-control" required id="edit_descrizione" placeholder="Descrizione">
                	</div>
                	<div class="form-group">
                		<label for="edit_vMin">Valore minimo</label>
                		<input type="number" class="form-control" required id="edit_vMin" placeholder="Valore minimo">
                	</div>
                	<div class="form-group">
                		<label for="edit_vMax">Valore massimo</label>
                		<input type="number" class="form-control" required id="edit_vMax" placeholder="Valore massimo">
                	</div>
                	<div class="form-group">
                		<label for="edit_measureUnit">Unit&agrave; di misura</label>
                		<input class="form-control" id="edit_measureUnit" required placeholder="Unit&agrave; di misura">
                	</div>
                	<div class="form-group">
                		<label for="edit_measureUnitIntegral">Unit&agrave; di misura integrale</label>
                		<input class="form-control" id="edit_measureUnitIntegral" placeholder="Unit&agrave; di misura integrale">
                	</div>
                	<div class="form-group">
                		<label for="edit_coeffInt">Coefficiente integrale</label>
                		<input type="number" class="form-control" id="edit_coeffInt" placeholder="Coefficiente integrale">
                	</div>
                </form>

			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
				<button type="button" class="btn btn-primary" onclick="editElement();">Modifica</button>
			</div>
		</div>
	</div>
</div>
<?php
	}
	?>