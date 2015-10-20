
$(document).ready(function(){/* off-canvas sidebar toggle */

$('[data-toggle=offcanvas]').click(function() {
  	$(this).toggleClass('visible-xs text-center');
    $(this).find('i').toggleClass('glyphicon-chevron-right glyphicon-chevron-left');
    $('.row-offcanvas').toggleClass('active');
    $('#lg-menu').toggleClass('hidden-xs').toggleClass('visible-xs');
    $('#xs-menu').toggleClass('visible-xs').toggleClass('hidden-xs');
    $('#btnShow').toggle();
});
    if($("#message").text() != "") {
        if ($("#message").text() == "Um einen neuen Eintarg zu erstellen, klicken sie auf das Plus oben rechts") {
            swal({
                title: "Herzlich  Willkommen",
                text: "Um einen neuen Eintarg zu erstellen, klicken Sie bitte auf das <i class='fa fa-plus'></i> Icon oben rechts<br /> <br />" +
                        "Wenn Sie das Passwort &auml;ndern m&ouml;chten, k&ouml;nnen Sie auf das <i class='fa fa-user-secret'></i> Icon klicken<br /><br />" +
                        "Zum Abmelden klicken Sie bitte auf das <i class='fa fa-sign-out'></i> Icon",
                html: true,
                confirmButtonText: "Okey"
            });
        } else {
            swal({
                title: $("#message").text(),
                text: "Fenster schliesst von selbst",
                timer: 4000,
                showConfirmButton: false,
                type: "success"
            });
        }
        if(typeof window.history.pushState == 'function') {
            window.history.pushState({}, "Hide", "?cmd=overview");
        }
    }
    $("#message").remove();
});