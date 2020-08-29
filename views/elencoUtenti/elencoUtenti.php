<?php
	if($_SESSION['userInfo']['role'] == 'amministratore') {
	?>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Elenco utenti</h3>
                <div class="card-tools">
                    <button type="button" data-toggle="modal" data-target="#modal-aggiungi" class="btn btn-tool"><i class="fas fa-file"></i></button>
                </div>
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<table id="tabellaUtenti" class="table table-bordered table-striped">
					<thead>
						<tr>
                            <th>#</th>
                            <th>Tipologia</th>
                            <th>E-Mail</th>
                            <th>Username</th>
                            <th>Nome e Cognome</th>
                            <th>Stato account</th>
                            <th>Comune di residenza</th>
                            <th style="width: 125px;" data-priority="1">Azioni</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
                            <th>#</th>
                            <th>Tipologia</th>
                            <th>E-Mail</th>
                            <th>Username</th>
                            <th>Nome e Cognome</th>
                            <th>Stato account</th>
                            <th>Comune di residenza</th>
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
    $.ajax("<?php echo $restEntrypoint; ?>/utente/" + selectedItemToDelete, {
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
    $.ajax("<?php echo $restEntrypoint; ?>/utente", {
        type: "POST",
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify({
            tipologia: $("#add_tipologia").val(),
            email: $("#add_email").val(),
            username: $("#add_username").val(),
            password: $("#add_password").val(),
            nome_cognome: $("#add_nome_cognome").val(),
            stato_account: $("#add_stato_account").val(),
            comune: $("#add_comune").val()
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
    $("#edit_tipologia").val(object.tipologia);
    $("#edit_email").val(object.email);
    $("#edit_username").val(object.username);
    $("#edit_password").val("");
    $("#edit_nome_cognome").val(object.nome_cognome);
    $("#edit_stato_account").val(object.stato_account);
    $("#edit_comune").val(object.comune);
}
function editElement() {
    $.ajax("<?php echo $restEntrypoint; ?>/utente/" + selectedItemToEdit, {
        type: "POST",
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify({
            tipologia: $("#edit_tipologia").val(),
            email: ($("#edit_email").val() != "") ? $("#edit_email").val() : null,
            username: $("#edit_username").val(),
            password: ($("#edit_password").val() != "") ? $("#edit_password").val() : null,
            nome_cognome: $("#edit_nome_cognome").val(),
            stato_account: $("#edit_stato_account").val(),
            comune: $("#edit_comune").val()
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

function showUserDetails(ID, tipo) {
    if(tipo == 'dipendente') {
        window.location = "/?p=dettagliDipendente&ID=" + ID;
    } else {
        window.location = "/?p=dettagliTecnico&ID=" + ID;
    }
}
document.addEventListener('DOMContentLoaded', function() {
    $("#tabellaUtenti").DataTable({
        responsive: true,
        autoWidth: false,
        ajax: {
            url: "<?php echo $restEntrypoint; ?>/utenti",
            type: "GET",
            contentType: "application/json; charset=utf-8",
            xhrFields: {
                withCredentials: true
            },
            crossDomain: true,
            dataSrc: ""
        },
        columns: [
            { data: "ID_utente" },
            { data: "tipologia" },
            { data: "email", defaultContent: "-" },
            { data: "username" },
            { data: "nome_cognome", defaultContent: "-" },
            {
                data: "stato_account",
                render: function ( data, type, row ) {
                    return `<span class="badge badge-${(row.stato_account == 'attivo') ? 'success' : 'danger'}" style="width: 100%;">${row.stato_account}</span>`;
                }
            },
            { data: "comune" },
            {
                data: null,
                render: function ( data, type, row ) {            
                    return `<button type="button" title="Modifica utente" class="btn btn-primary" data-toggle="modal" data-target="#modal-modifica" onclick="selectedItemToEdit=${row.ID_utente}; populateForm('${encodeURIComponent(JSON.stringify(row))}');" style="width: 45px;">
                                <span class="fas fa-edit"></span>
                            </button>
                            <button type="button"${
                                (row.tipologia != 'dipendente' && row.tipologia != 'tecnico')
                                ? ' disabled' : ''
                                } title="${
                                (row.tipologia != 'dipendente' && row.tipologia != 'tecnico')
                                ? '' : `Vai ai dettagli del ${(row.tipologia == 'dipendente') ? 'dipendente' : 'tecnico'}`
                                }" class="btn btn-success" onclick="showUserDetails(${row.ID_utente}, '${row.tipologia}');" style="width: 45px;">
                                <span class="fas fa-list"></span>
                            </button>
                            <button type="button"${(row.ID_utente == 1) ? ' disabled' : ''}  title="Elimina utente" class="btn btn-danger" data-toggle="modal" data-target="#modal-elimina" onclick="selectedItemToDelete=${row.ID_utente};" style="width: 45px;">
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
	$DELETE_MODAL_TITLE = "Conferma eliminazione utente";
	$DELETE_MODAL_BODY = "Sei sicuro di voler rimuovere l'utente dal sistema?";
	include './views/_partials/modal_elimina_elemento.inc';
?>

<div class="modal fade" id="modal-aggiungi">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Aggiungi nuovo utente</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <form id="add_frm">
                	<div class="form-group">
                		<label for="add_tipologia">Tipologia</label>
						<select id="add_tipologia" class="form-control">
                          <option value="amministratore">Amministratore</option>
                          <option value="dipendente">Dipendente</option>
                          <option value="tecnico">Tecnico</option>
                          <option value="monitor">Monitor</option>
                        </select>
                	</div>
                	<div class="form-group">
                		<label for="add_email">E-Mail</label>
                		<input type="email" class="form-control" id="add_email" placeholder="Email">
                	</div>
                	<div class="form-group">
                		<label for="add_username">Username</label>
                		<input class="form-control" required id="add_username" placeholder="Username">
                	</div>
                	<div class="form-group">
                		<label for="add_password">Password</label>
                		<input type="password" class="form-control" required id="add_password" placeholder="Password">
                	</div>
                	<div class="form-group">
                		<label for="add_nome_cognome">Nome e Cognome</label>
                		<input class="form-control" id="add_nome_cognome" placeholder="Nome e Cognome">
                	</div>
                	<div class="form-group">
                		<label for="add_stato_account">Stato account</label>
						<select id="add_stato_account" required class="form-control">
                          <option value="disattivato">Disattivato</option>
                          <option value="attivo">Attivo</option>
                        </select>
                    </div>
                	<div class="form-group">
                		<label for="add_comune">Comune di residenza</label>
						<select id="add_comune" required class="form-control fillComune">
                        </select>
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
				<h4 class="modal-title">Modifica utente</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <form id="edit_frm">
                	<div class="form-group">
                		<label for="edit_tipologia">Tipologia</label>
						<select id="edit_tipologia" class="form-control">
                          <option value="amministratore">Amministratore</option>
                          <option value="dipendente">Dipendente</option>
                          <option value="tecnico">Tecnico</option>
                          <option value="monitor">Monitor</option>
                        </select>
                	</div>
                	<div class="form-group">
                		<label for="edit_email">E-Mail</label>
                		<input type="email" class="form-control" id="edit_email" placeholder="Email">
                	</div>
                	<div class="form-group">
                		<label for="edit_username">Username</label>
                		<input class="form-control" required id="edit_username" placeholder="Username">
                	</div>
                	<div class="form-group">
                		<label for="edit_password">Password</label>
                		<input type="password" class="form-control" id="edit_password" placeholder="Password">
                	</div>
                	<div class="form-group">
                		<label for="edit_nome_cognome">Nome e Cognome</label>
                		<input class="form-control" id="edit_nome_cognome" placeholder="Nome e Cognome">
                	</div>
                	<div class="form-group">
                		<label for="edit_stato_account">Stato account</label>
						<select id="edit_stato_account" required class="form-control">
                          <option value="disattivato">Disattivato</option>
                          <option value="attivo">Attivo</option>
                        </select>
                    </div>
                	<div class="form-group">
                		<label for="edit_comune">Comune di residenza</label>
						<select id="edit_comune" required class="form-control fillComune">
                        </select>
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