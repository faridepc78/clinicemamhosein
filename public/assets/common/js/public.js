function validateCkeditor(text_field, text_error) {
    CKEDITOR.replace(text_field);
    var length = CKEDITOR.instances[text_field].getData().replace(/<[^>]*>/gi, '').length;
    if (!length) {
        toastr['info'](text_error, 'پیام');
        return false;
    } else {
        return true;
    }
}

function removeSpaces(string) {
    return string.trimStart();
}

function changeStyleType(id) {

    id.keyup(function () {
        var id_value = id.val().length;

        if (id_value != 0) {
            id.css('direction','ltr');
        } else {
            id.css('direction','rtl');
        }
    });
}

function removeURLParameter(url, parameter) {
    //prefer to use l.search if you have a location/link object
    var urlparts = url.split('?');
    if (urlparts.length >= 2) {

        var prefix = encodeURIComponent(parameter) + '=';
        var pars = urlparts[1].split(/[&;]/g);

        //reverse iteration as may be destructive
        for (var i = pars.length; i-- > 0;) {
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                pars.splice(i, 1);
            }
        }

        url = urlparts[0] + '?' + pars.join('&');
        return url;
    } else {
        return url;
    }
}

function replaceUrlParam(url, paramName, paramValue) {
    if (paramValue == null) {
        paramValue = '';
    }
    var pattern = new RegExp('\\b(' + paramName + '=).*?(&|#|$)');
    if (url.search(pattern) >= 0) {
        return url.replace(pattern, '$1' + paramValue + '$2');
    }
    url = url.replace(/[?#]$/, '');
    return url + (url.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue;
}
