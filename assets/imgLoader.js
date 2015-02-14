(function ($) {

    $.fn.imgLoader = function (options)
    {
        options = $.extend({}, $.fn.imgLoader.config, options);

        return this.each(function ()
        {
            var $el = $(this);

            var url = options.url;
            var name = options.postField;
            var id = 'img_id_' + (new Date()).getTime();
            var success = $el.attr('data-function' || options.success);

            $('<input id="'+id+'" type="file" name="'+name+'" style="display: none" />').insertAfter($el);
            var $file = $('#' + id);

            $el.on('click', function()
            {
                $file.click();
                return false;
            });

            var onSuccess = function(json)
            {
                if(!json.hasError)
                {
                    $el.attr('src', json.data.Images[options.urlField]);
                    if($.isFunction(options.success)) options.success(json);
                }
            };

            var onError = function(a, b, c)
            {
                if($.isFunction(options.error)) options.error(a, b, c);
            };

            var onAlways = function(a, b, c)
            {
                if($.isFunction(options.always)) options.always(a, b, c);
            };

            $file.on('change', function()
            {
                var fd = new FormData();
                fd.append(name, this.files[0]);
                var addFields = options.addParams || {};
                for (var n in addFields) fd.append(n, addFields[n]);
                // add csrf
                var token = $('meta[name='+options.csrfTokenName+']').attr("content");
                var value = $('meta[name='+options.csrfTokenValue+']').attr("content");
                fd.append(token, value);

                $.when($.ajax({
                    url : url,
                    data: fd,
                    type: 'POST',
                    dataType: 'json',
                    processData: false,
                    contentType: false
                })).done(onSuccess).fail(onError).always(onAlways);
            });
        });
    };

    $.fn.imgLoader.config =
    {
        url : '/upload',
        iidField : 'IID',
        urlField : 'FileName',
        postField: 'Image',
        csrfTokenName : 'csrf-param',
        csrfTokenValue : 'csrf-token',
        success : null,
        error: null,
        always: null,
        addParams : []
    };

}(jQuery));