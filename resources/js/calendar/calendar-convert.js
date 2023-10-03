/*   http://keith-wood.name/calendars.html * /

/* date: The date of Hijri calander */
/* calGerId: The Id of the Geregenion Calander Element */

function convertDtFromHijriToGer(date) {
    try {
        var calHijri = $.calendars.instance('ummalqura');
        var calG = $.calendars.instance();

        var day = date[0]['_day'];
        var month = date[0]['_month'];
        var year = date[0]['_year'];

        var dtHj = calHijri.newDate(parseInt(year), parseInt(month), parseInt(day));
        var days = dtHj.toJD();
        var dtGer = calG.fromJD(days);
        return dtGer._year+'-'+dtGer._month+'-'+dtGer._day;
    }
    catch (err) {
        console.log('من فضلك حدد التاريخ بطريقة سليمة');
    }
};

/* date: The date of Geregenion calander */
/* calGerId: The Id of the Hijri Calander Element */
function convertDtFromGerToHijri(date, calHjId) {
    try {
        var calHijri = $.calendars.instance('ummalqura');
        var calG = $.calendars.instance();
        var split = date.split('-');
       
        var dtGer = calG.newDate(parseInt(split[0]), parseInt(split[1]), parseInt(split[2]));
        var days = dtGer.toJD();
        var dtHj = calHijri.fromJD(days);
        return dtHj._day+'/'+dtHj._month+'/'+dtHj._year;

    }
    catch (err) {
        console.log('من فضلك حدد التاريخ بطريقة سليمة');
    }
};


function checkChar(e) {
    var key;
    var keychar;

    if (window.event)
        key = window.event.keyCode;
    else if (e)
        key = e.which;
    else
        return true;
    keychar = String.fromCharCode(key);
    // control keys


    if ((key >= 1569 && key < 1708) || key == 32 || key > 57) {
        return false;
    }
    return true;
};


function pad(str, max) {
    str = str.toString();
    return str.length < max ? pad("0" + str, max) : str;
}
function validateDigits(elem) {
    elem.value = elem.value.replace(/[^0-9]+/g, "");
};

function validateNumbers(elem) {
    elem.value = elem.value.replace(/[^0-9\.]+/g, "");
};

function validatePercentage(elem) {
    elem.value = elem.value.replace(/[^0-9\.]+/g, "");

    var num = parseFloat(elem.value).toFixed(5);
    if (num > 100.0) {
        elem.value = "100";
    }
};

function strEndsWith(str, suffix) {
    return str.match(suffix + "$") == suffix;
};

function enableSubmitDelayed() {
    $(":submit").attr('disabled', false);
};

