$(function() {
    /**
     * After the javascript sources 
     */
    loadIcons();
});

/**
 * Sets the source of the postload icons to reduce the initial loading time.
 */
function loadIcons() {
    $('img.postload').each(function() {
        var iconname = $(this).attr('icon');
        var icondimension = 'small';
        var alttext = $(this).attr('alt');
        var id = $(this).attr('id');
        if (isMobile()) {
            icondimension = 'medium';
        }
        $(this).attr('src', 'img/icons/'+ icondimension +'/'+ iconname +'.png').attr('data-src', '');
        if (alttext && id) {
            var label = document.createElement('label');
            $(label).attr('for', id);
            $(label).html(alttext);
            $(this).after(label);
        }
    });
}

/**
 * Determinates weather a mobile device or a desktop client is used.
 * @see https://stackoverflow.com/questions/3514784/
 * @return boolean True if the user uses a mobile device or false
 */
function isMobile() {
    return (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
}
