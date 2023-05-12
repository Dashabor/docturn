//маска для ввода
$(document).ready(function () {
    $("#userTel").mask("+7 (999) 999-99-99");
});
//маска для ввода
$(document).ready(function () {
    $("#userInn").mask("999999999999");
});

$(document).ready(function () {
    $("#userKpp").mask("99 99 99 999");
});


$('#firstName').on('input', function () { //функция замены символов при вводе
    $(this).val($(this).val().replace(/[\@,\",\',\#,\ ,\№,\$,\;,\%,\^,\:,\*,\&,\?,\(,\),\-,\_,\=,\+,\/,\|,\{,\},\<,\>,\!,\\,\.,\[,\],\~,\`,0-9]/, ''))
});


$('#lastName').on('input', function () { //функция замены символов при вводе
    $(this).val($(this).val().replace(/[\@,\",\',\#,\ ,\№,\$,\;,\%,\^,\:,\*,\&,\?,\(,\),\-,\_,\=,\+,\/,\|,\{,\},\<,\>,\!,\\,\.,\[,\],\~,\`,0-9]/, ''))
});

$('#patronymicName').on('input', function () { //функция замены символов при вводе
    $(this).val($(this).val().replace(/[\@,\",\',\#,\ ,\№,\$,\;,\%,\^,\:,\*,\&,\?,\(,\),\-,\_,\=,\+,\/,\|,\{,\},\<,\>,\!,\\,\.,\[,\],\~,\`,0-9]/, ''))
});


//установка курсора
$.fn.setCursorPosition = function (pos) {
    if ($(this).get(0).setSelectionRange) {
        $(this).get(0).setSelectionRange(pos, pos);
    } else if ($(this).get(0).createTextRange) {
        var range = $(this).get(0).createTextRange();
        range.collapse(true);
        range.moveEnd('character', pos);
        range.moveStart('character', pos);
        range.select();
    }
};
//установка курсора

$("#userInn").click(function () {
    $(this).setCursorPosition(0);
});

$("#userKpp").click(function () {
    $(this).setCursorPosition(0);
});

$('input[type="tel"]').click(function () {
    $(this).setCursorPosition(4);
});

//функция скрытия пароля
function show_hide_password(target) {
    var input = document.getElementById('password-input');
    if (input.getAttribute('type') == 'password') {
        target.classList.add('view');
        input.setAttribute('type', 'text');
    } else {
        target.classList.remove('view');
        input.setAttribute('type', 'password');
    }
    return false;
}
//функция скрытия пароля
function show_hide_password_2(target) {
    var input = document.getElementById('password-input-2');
    if (input.getAttribute('type') == 'password') {
        target.classList.add('view');
        input.setAttribute('type', 'text');
    } else {
        target.classList.remove('view');
        input.setAttribute('type', 'password');
    }
    return false;
}


$('#userEmail').keyup(function () {

    var regexp = /^(?:[A-Za-z0-9]+(?:[-_.]?[A-Za-z0-9]+)?@[A-Za-z0-9_.-]+(?:\.?[A-Za-z0-9]+)?\.[A-Za-z]{2,5})$/i;
    if (this.value[0] == '@') {
        $(this).val($(this).val().replace(/[\",\',\#,\ ,\№,\$,\;,\%,\^,\:,\*,\&,\?,\(,\),\-,\=,\+,\/,\|,\{,\},\<,\>,\!,\\,\[,\],\_,\~,\`,\@,]/, ''));
    }

    else if (!regexp.test(this.value)) {
        $(this).val($(this).val().replace(/[\",\',\#,\ ,\№,\$,\;,\%,\^,\:,\*,\&,\?,\(,\),\-,\=,\+,\/,\|,\{,\},\<,\>,\!,\\,\[,\],\_,\~,\`,]/, ''))
    }
    else {
    }

});


