function get_spinner_loading() {

    return '<div class="spinner"><div class="double-bounce1"></div><div class="double-bounce2"></div></div>';

}

$(document).ajaxError(function (event, jqxhr, settings, thrownError) {

    if(jqxhr.readyState == 0) return;

    var message = jqxhr.status + ' - ' + jqxhr.statusText;
        
    $.toast({
        text: message,
        heading: '',
        icon: 'error',
        textAlign: 'center',
        loader: true,
        loaderBg: '#822422'
    });

});