<div class="modal fade" id="modal-aggiungi-impianto-assegnato">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Aggiungi impianto da assegnare al dipendente</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <form id="add_frm">
                	<div class="form-group">
                		<label for="add_ImpiantoAssegnato">Digita Impianto Da assegnare al dipendente</label>
						<select id="add_ImpiantoAssegnato" required class="form-control getImpianti">
                        </select>
                	</div>
                </form>
                	<div class="form-group">
                		<label for="add_permesso">Permesso di Scrittura</label>
						<select  id="add_permesso" class="form-control">
                          <option value="0">Permesso non concesso</option>
                          <option value="1">Permesso concesso</option>
                        </select>
                	</div>
                </form>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
				<button type="button" class="btn btn-primary" onclick="AggiungiImpiantoAssegnato();">Aggiungi</button>
			</div>
		</div>
	</div>
</div>