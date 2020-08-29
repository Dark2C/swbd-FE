<div class="modal fade" id="modal-modifica-dettagli-utente">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Modifica Dettagli Utente</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <form id="edit_frm">
					<div class="form-group">
                		<label for="edit_nome_cognome">Nome Cognome</label>
                		<input class="form-control" required id="edit_nome_cognome" placeholder="Nome Cognome">
                	</div>
                	<div class="form-group">
                		<label for="edit_comune">Comune</label>
						<select id="edit_comune" required class="form-control fillComune">
                        </select>
                	</div>
                	<div class="form-group">
                		<label for="edit_username">Username</label>
                		<input class="form-control" required id="edit_username" placeholder="Username">
                	</div>
                	<div class="form-group">
                		<label for="edit_email">Email</label>
                		<input class="form-control" required id="edit_email" placeholder="Email">
                	</div>
                    <div class="form-group">
                		<label for="edit_stato_account">Stato Account</label>
                		<input class="form-control" required id="edit_stato_account" placeholder="Stato Account">
                	</div>
                    <div class="form-group">
                		<label for="edit_tipologia">Tipologia</label>
                		<input class="form-control" required readonly id="edit_tipologia" placeholder="Tipologia">
                	</div>
                </form>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
				<button type="button" class="btn btn-primary" onclick="EditInformazioniDipendente()">Modifica</button>
			</div>
		</div>
	</div>
</div>