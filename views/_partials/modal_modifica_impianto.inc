<div class="modal fade" id="modal-modifica-impianto">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Modifica impianto</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <form id="edit_frm">
					<div class="form-group">
                		<label for="edit_nome">Nome</label>
                		<input class="form-control" required id="edit_nome" placeholder="Nome">
                	</div>
                	<div class="form-group">
                		<label for="edit_descrizione">Descrizione</label>
                		<input class="form-control" required id="edit_descrizione" placeholder="Descrizione">
                	</div>
                	<div class="form-group">
                		<label for="edit_latitudine">Latitudine</label>
                		<input type="number" min="-90" max="90" required class="form-control" id="edit_latitudine" placeholder="Latitudine">
                	</div>
                	<div class="form-group">
                		<label for="edit_longitudine">Longitudine</label>
                		<input type="number" min="-180" max="180" required class="form-control" id="edit_longitudine" placeholder="Longitudine">
                	</div>
                	<div class="form-group">
                		<label for="edit_comune">Comune</label>
						<select id="edit_comune" required class="form-control fillComune">
                        </select>
                	</div>
                	<div class="form-group">
                		<label for="edit_intervallo_standard">Intervallo di trasmissione standard (s)</label>
                		<input type="number" required class="form-control" id="edit_intervallo_standard" placeholder="Intervallo di trasmissione standard (s)">
                	</div>
                	<div class="form-group">
                		<label for="edit_intervallo_anomalia">Intervallo di trasmissione anomalia (s)</label>
                		<input type="number" required class="form-control" id="edit_intervallo_anomalia" placeholder="Intervallo di trasmissione anomalia (s)">
                	</div>
                </form>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
				<button type="button" class="btn btn-primary" onclick="editImpianto();">Modifica</button>
			</div>
		</div>
	</div>
</div>