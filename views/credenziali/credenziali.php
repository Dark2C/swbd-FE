<script>
    let utente;
</script>
<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Modifica credenziali Utente</h3>
  </div>
  <form role="form">
    <div class="card-body">
      <div class="form-group">
        <label for="detailsnome_cognome">Nome Cognome</label>
        <input class="form-control" id="detailsnome_cognome" placeholder="Inserisci Nome Cognome">
      </div>
      <div class="form-group">
        <label for="detailspassword">Password</label>
        <input type="password" class="form-control" id="detailspassword" placeholder="Password">
      </div>
      <div class="form-group">
        <label for="comune">Comune</label>
        <select id="detailscomune" class="form-control fillComune">
        </select>
      </div>
      <div class="form-group">
        <label for="detailsemail">Email</label>
        <input class="form-control" id="detailsemail" placeholder="Email">
      </div>
      <div class="form-group">
        <label for="detailsusername">Username</label>
        <input class="form-control" id="detailsusername" placeholder="Username">
      </div>
      <div class="form-group">
        <label for="detailsstato_account">Stato Account</label>
        <select  id="detailsStato" class="form-control">
          <option value="attivo">attivo</option>
          <option value="disattivato">disattivo</option>
        </select>
      </div>
    </div>
    <div class="card-footer">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-aggiorna-credenziali" >Aggiorna</button>
    </div>
  </form>
            </div>
          </div>
  </div>
</div>
<?php
	$CONFIRMATION_MODAL_ID = isset($CONFIRMATION_MODAL_ID) ? $CONFIRMATION_MODAL_ID: "modal-aggiorna-credenziali";
	$CONFIRMATION_MODAL_TITLE = isset($CONFIRMATION_MODAL_TITLE) ? $CONFIRMATION_MODAL_TITLE : "Conferma cambio credenziali";
	$CONFIRMATION_MODAL_BODY = isset($CONFIRMATION_MODAL_BODY) ? $CONFIRMATION_MODAL_BODY : "Sei sicuro di voler aggiornare le credenziali?";
	$CONFIRMATION_MODAL_ACTION = isset($CONFIRMATION_MODAL_ACTION) ? $CONFIRMATION_MODAL_ACTION : "EditCredenziali();";
?>

<div class="modal fade" id="<?php echo $CONFIRMATION_MODAL_ID; ?>">
	<div class="modal-dialog">
		<div class="modal-content alert alert-info">
			<div class="modal-header">
				<h4 class="modal-title"><?php echo $CONFIRMATION_MODAL_TITLE; ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p><?php echo $CONFIRMATION_MODAL_BODY ?></p>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-outline-light" data-dismiss="modal">Annulla</button>
				<button type="button" class="btn btn-outline-light" data-dismiss="modal" onclick="<?php echo $CONFIRMATION_MODAL_ACTION; ?>">Aggiorna</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
  <?php include './views/_partials/fill_comune_function.inc'; ?>
document.addEventListener('DOMContentLoaded', function() {
  $.ajax('<?php echo $restEntrypoint; ?>/utente/self', { 
        type: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(ut) {
					utente = ut;
          populateForm();
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
    fillComune();
}, false);
function populateForm() {
  $("#detailsnome_cognome").val(utente.nome_cognome);
  $("#detailsusername").val(utente.username);
  $("#detailsemail").val(utente.email);
  $("#detailsStato").val(utente.stato_account);
  $("#detailspassword").val(utente.password);
  $("#detailscomune").val(utente.comune);
}
function EditCredenziali() {
    $.ajax(`<?php echo $restEntrypoint; ?>/utente/self`, {
        type: "POST",
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify({
            nome_cognome: $("#detailsnome_cognome").val(),
            comune: $("#detailscomune").val(),
            username: $("#detailsusername").val(),
            password: $("#detailspassword").val(),
            email: $("#detailsemail").val(),
            stato_account: $("#detailsStato").val()
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
