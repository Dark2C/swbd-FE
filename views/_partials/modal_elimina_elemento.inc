<?php
	$DELETE_MODAL_ID = isset($DELETE_MODAL_ID) ? $DELETE_MODAL_ID : "modal-elimina";
	$DELETE_MODAL_TITLE = isset($DELETE_MODAL_TITLE) ? $DELETE_MODAL_TITLE : "Conferma eliminazione elemento";
	$DELETE_MODAL_BODY = isset($DELETE_MODAL_BODY) ? $DELETE_MODAL_BODY : "Sei sicuro di voler rimuovere l'elemento dal sistema?";
	$DELETE_MODAL_ACTION = isset($DELETE_MODAL_ACTION) ? $DELETE_MODAL_ACTION : "deleteElement();";
?>
<div class="modal fade" id="<?php echo $DELETE_MODAL_ID; ?>">
	<div class="modal-dialog">
		<div class="modal-content bg-danger">
			<div class="modal-header">
				<h4 class="modal-title"><?php echo $DELETE_MODAL_TITLE; ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p><?php echo $DELETE_MODAL_BODY; ?></p>
				<p>L'azione &egrave; irreversibile!</p>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-outline-light" data-dismiss="modal">Annulla</button>
				<button type="button" class="btn btn-outline-light" data-dismiss="modal" onclick="<?php echo $DELETE_MODAL_ACTION; ?>">Elimina</button>
			</div>
		</div>
	</div>
</div>
<?php
	unset($DELETE_MODAL_ID);
	unset($DELETE_MODAL_TITLE);
	unset($DELETE_MODAL_BODY);
	unset($DELETE_MODAL_ACTION);
?>