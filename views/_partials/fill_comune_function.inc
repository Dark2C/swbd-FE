function fillComune() {
    $.ajax("<?php echo $restEntrypoint; ?>/comuni/", {
        type: "GET",
        contentType: "application/json; charset=utf-8",
        success: function(data) {
            var comuni = Array();
            for (const comune in data.comuni) {
                comuni.push(`<!-- ${data.comuni[comune].nome_regione} ${data.comuni[comune].nome_comune} --><option value="${comune}">${data.comuni[comune].nome_regione} - ${data.comuni[comune].nome_comune}</option>`);
            }
            $(".fillComune").html(comuni.sort().join(''));
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
}