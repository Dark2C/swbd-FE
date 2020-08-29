<?php
if($_SESSION['userInfo']['role'] == 'amministratore') {
?>
<div class="card-body">
	<div class="form-group">
		<label for="elencoTipologiaSensori">Seleziona il sensore per il quale elaborare i grafici</label>
		<select class="form-control" id="elencoTipologiaSensori" onchange="getGraficiSensore($(this).val());$('.selezionaSensorePlaceholder').remove();getStatisticheImpianti($(this).val(),$(this.unita_misura_integrale).val());">
		</select>
	</div>
	<div style="width:100%;">
		<canvas id="canvasGrafico" ></canvas>
	</div>
	
	<script>
		var config = {
			type: 'line',
			data: {
				datasets: []
			}
		};
		window.onload = function() {
			var ctx = document.getElementById('canvasGrafico').getContext('2d');
			window.myLine = new Chart(ctx, config);
		};
	</script>
    </div>
	<div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="fas fa-fire-alt"></i></span>

              <div class="info-box-content">
			  <span class="info-box-text" style="font-weight:bold";>Energia Prodotta</span>
                	<div class="info-box-body" id="statisticheImpianti"> 
						<span>Selezionare tipologia sensore...</span>
					</div>
              </div>
            </div>
<script>
var risultato=0;
function getStatisticheImpianti(ID_sensore,measureUnit)
{   $.ajax(`<?php echo $restEntrypoint; ?>/statistiche/impianti`, {
				        	type: "POST",
							headers: {
									'X-HTTP-Method-Override': 'GET'
									},
				        	contentType: "application/json; charset=utf-8",
				        	data: JSON.stringify({
								tipologia: ID_sensore
							}),
							dataType: "json",
				        	success: function(impianti) {
								var measureUnit = '';
								impianti.forEach(impianto => {
								risultato += impianto.datiSensore.integrale;
								measureUnit = impianto.datiSensore.unita_misura_integrale;
								});
								$("#statisticheImpianti").html(risultato + ' [' + measureUnit + ']');
				        	},
				        	xhrFields: {
				        	    withCredentials: true
				        	},
				        	crossDomain: true
				    	});
}
function getGraficiSensore(ID_sensore) {
	$.ajax(`<?php echo $restEntrypoint; ?>/statistiche/impianti`, {
        type: "POST",
		headers: {
				'X-HTTP-Method-Override': 'GET'
		},
        contentType: "application/json; charset=utf-8",
        dataType: "json",
		data: JSON.stringify({
			tipologia: ID_sensore
		}),
		success: function(impianti) {
            config.data.datasets = [];
			var minDate = new Date(9999999999999);
			var maxDate = new Date(0);
            impianti.forEach(impianto => {
            	var labels = Array();
			    impianto.datiSensore.letture.forEach(lettura => {
					if(new Date(lettura.x).getTime() < minDate.getTime()) minDate = new Date(lettura.x);
					if(new Date(lettura.x).getTime() > maxDate.getTime()) maxDate = new Date(lettura.x);
                    labels.push(new Date(lettura.x).toLocaleDateString() + ' ' + new Date(lettura.x).toLocaleTimeString());
                    lettura.x = new Date(lettura.x);
                });
			    config.data.labels = [...new Set([...config.data.labels,...labels])];
			    var newColor = "rgb(" + parseInt(Math.random()*255) + ", " + parseInt(Math.random()*255) + ", " + parseInt(Math.random()*255) + ")";
			    var newDataset = {
			    	label: impianto.nome + ' [' + impianto.datiSensore.unita_misura + ']',
			    	backgroundColor: newColor,
			    	borderColor: newColor,
			    	data: impianto.datiSensore.letture,
			    	fill: false
			    };
			    config.data.datasets.push(newDataset);
            });
			config.options = {
                scales: {
                    xAxes: [{
                        type: 'time',
                        ticks: {
							source: 'data',
							min: minDate,
							max: maxDate
						}
                    }]
                }
            }
			window.myLine.update();
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}

function fillSensore() {
    $.ajax("<?php echo $restEntrypoint; ?>/tipologia/sensori/", {
        type: "GET",
        contentType: "application/json; charset=utf-8",
		dataType: "json",
        success: function(data) {
            var sensori = Array();
            for (const sensore in data) {
                sensori.push(`<option value="${data[sensore].ID_tipologia_sensore}">${data[sensore].produttore} - ${data[sensore].modello} (${data[sensore].descrizione})</option>`);
            }
            $("#elencoTipologiaSensori").html(sensori.join(''));
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}
document.addEventListener('DOMContentLoaded', function() {
    fillSensore();
}, false);


</script>
<?php
}
?>