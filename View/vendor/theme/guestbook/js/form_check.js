$("input#username").change(function () {
    allOK = checkUserName($("input#username").val(), true);
    if (allOK == true) {
        $("input#username").next(".text-danger").html("");
    }
});
$("input#password").change(function () {
    checkPasswordOnChange();
});
$("input#passwordConfirm").change(function () {
    checkPasswordOnChange();
});
function checkRegisterData() {
    var username = $("input#username").val();
    var firstname = $("input#firstname").val();
    var lastname = $("input#lastname").val();
    var email = $("input#email").val();
    var password = $("input#password").val();
    var passwordConfirm = $("input#passwordConfirm").val();
    var allOK = true;

    $(".text-danger").html("");

    allOK = checkUserName(username, allOK);
    allOK = checkPasswortMatch(password, passwordConfirm, allOK);
    allOK = checkPassword(password, passwordConfirm, allOK);
    if (allOK == true) {
        return true;
    } else {
        return false;
    }
}
function checkUserName(username, allOK) {
    if (username.length != 6) {
        $("input#username").next(".text-danger").html("Benutzername muss genau 6 Zeichen lang sein");
        allOK = false;
    }
    if (/[^a-zA-Z0-9]/.test(username)) {
        $("input#username").next(".text-danger").html("Benutzername ist nicht alphanummerisch");
        allOK = false;
    }
        var data = {'cmd': 'json', 'act': 'checkuserexists', 'user': $("input#username").val()};
        $.ajax({
            url: 'index.php',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function (data) {
                if (data.value == true) {
                    $("input#username").next(".text-danger").html('Benutzername ist bereits vergeben');
                }
                allOK = false;
            }
        });
        return allOK;
}
function checkPasswortMatch(password, passwordConfirm, allOK) {
    if (password != passwordConfirm) {
        $("input#passwordConfirm").next(".text-danger").html("Passwörter stimmen nicht überein");
        allOK = false;
    }
    return allOK;
}
function checkPassword(password, passwordConfirm, allOK) {
    if (password.length >= 8) {
        if (!/[A-ZÄÖÜ]/.test(password)) {
            $("input#password").next(".text-danger").html("Passwort muss einen Grossbuchstaben enthalten");
            allOK = false;
        } else if (!/[a-zäöü]/.test(password)) {
            $("input#password").next(".text-danger").html("Passwort muss einen Kleinbuchstaben enthalten");
            allOK = false;
        } else if (!/[¦@#°§¬\\\|¢´~!?=/&%ç*"+]/.test(password)) {
            $("input#password").next(".text-danger").html("Passwort muss ein Sonderzeichen enthalten");
            allOK = false;
        } else if (!/[0-9]/.test(password)) {
            $("input#password").next(".text-danger").html("Passwort muss eine Ziffer enthalten");
            allOK = false;
        }
    } else {
        $("input#password").next(".text-danger").html("Passwort ist zu kurz");
        allOK = false;
    }
    return allOK;
}
function checkPasswordOnChange() {
    allOK = checkPasswortMatch($("input#password").val(), $("input#passwordConfirm").val(), true);
    if (allOK == true) {
        $("input#passwordConfirm").next(".text-danger").html("");
    }
    allOK = true;
    allOK = checkPassword($("input#password").val(), $("input#passwordConfirm").val(), true);
    if (allOK == true) {
        $("input#password").next(".text-danger").html("");
    }
}