/**
 * bootstrap-imageupload v1.1.2
 * https://github.com/egonolieux/bootstrap-imageupload
 * Copyright 2016 Egon Olieux
 * Released under the MIT license
 */

if (typeof jQuery === 'undefined') {
    throw new Error('bootstrap-imageupload\'s JavaScript requires jQuery.');
}

(function($) {
    'use strict';

    var options = {};

    var methods = {
        init: init,
        disable: disable,
        enable: enable,
        reset: reset
    };

    // -----------------------------------------------------------------------------
    // Plugin Definition
    // -----------------------------------------------------------------------------

    $.fn.imageupload = function(methodOrOptions) {
        var givenArguments = arguments;

        return this.filter('div').each(function() {
            if (methods[methodOrOptions]) {
                methods[methodOrOptions].apply($(this), Array.prototype.slice.call(givenArguments, 1));
            }
            else if (typeof methodOrOptions === 'object' || !methodOrOptions) {
                methods.init.apply($(this), givenArguments);
            }
            else {
                throw new Error('Method "' + methodOrOptions + '" is not defined for imageupload.');
            }
        });
    };

    $.fn.imageupload.defaultOptions = {
        allowedFormats: [ 'jpg', 'jpeg' ],
        maxWidth: 2000,
        maxHeight: 1000,
        maxFileSizeKb: 80000
    };

    // -----------------------------------------------------------------------------
    // Public Methods
    // -----------------------------------------------------------------------------

    function init(givenOptions) {
        options = $.extend({}, $.fn.imageupload.defaultOptions, givenOptions);

        var $imageupload = this;
        var $fileTab = $imageupload.find('.file-tab');
        var $fileTabButton = $imageupload.find('.panel-heading .btn:eq(0)');
        var $browseFileButton = $fileTab.find('input[type="file"]');
        var $urlTab = $imageupload.find('.url-tab');
        var $urlTabButton = $imageupload.find('.panel-heading .btn:eq(1)');
        var $submitUrlButton = $urlTab.find('.btn:eq(0)');
        var $removeUrlButton = $urlTab.find('.btn:eq(1)');
        var $annonceId = $fileTab.find('input[type="hidden"]');

        // Do a complete reset.
        resetFileTab($fileTab);
        showFileTab($fileTab);
        enable.call($imageupload);

        // Unbind all previous bound event handlers.
        $fileTabButton.off();
        $browseFileButton.off();
        $urlTabButton.off();
        $submitUrlButton.off();
        $removeUrlButton.off();

        $fileTabButton.on('click', function() {
            $(this).blur();
            showFileTab($fileTab);
        });

        $browseFileButton.on('change', function() {
            $(this).blur();
            submitImageFile($fileTab);
        });

    }

    function disable() {
        var $imageupload = this;
        $imageupload.addClass('imageupload-disabled');
    }

    function enable() {
        var $imageupload = this;
        $imageupload.removeClass('imageupload-disabled');
    }

    function reset() {
        var $imageupload = this;
        init.call($imageupload, options);
    }

    // -----------------------------------------------------------------------------
    // Private Methods
    // -----------------------------------------------------------------------------

    function getAlertHtml(message) {
        var html = [];
        html.push('<div class="alert alert-danger alert-dismissible">');
        html.push('<button type="button" class="close" data-dismiss="alert">');
        html.push('<span>&times;</span>');
        html.push('</button>' + message);
        html.push('</div>');
        return html.join('');
    }

    function getFileExtension(path) {
        return path.substr(path.lastIndexOf('.') + 1).toLowerCase();
    }

    function isValidImageFile(file, callback) {
        // Check file size.
        if (file.size / 1024 > options.maxFileSizeKb)
        {
            callback(false, 'Taille du fichier trop grand (max ' + options.maxFileSizeKb + 'kB).');
            return;
        }
        // Check file dimension
        var img = new Image();
        var imgwidth = 0;
        var imgheight = 0;
        img.src = window.URL.createObjectURL( file );
        img.onload = function() {
           imgwidth = this.width;
           imgheight = this.height;
           if(imgwidth<700 && imgheight<525){
             callback(false, 'Les dimensions minimales 700 x 525.');
             return;
           }
           /*if(imgheight>imgwidth){
             callback(false, 'Les images au format vertical non acceptés.');
             return;
           }*/
           // Check image format by file extension.
           var fileExtension = getFileExtension(file.name);
           if ($.inArray(fileExtension, options.allowedFormats) > -1) {
               callback(true, 'Image file is valid.');
           }
           else {
               callback(false, 'Vous ne pouvez pas uploader ce type de fichier.');
           }
        }

    }

    function showFileTab($fileTab) {
        var $imageupload = $fileTab.closest('.imageupload');
        var $fileTabButton = $imageupload.find('.panel-heading .btn:eq(0)');

        if (!$fileTabButton.hasClass('active')) {
            var $urlTab = $imageupload.find('.url-tab');

            // Change active tab buttton.
            $imageupload.find('.panel-heading .btn:eq(1)').removeClass('active');
            $fileTabButton.addClass('active');
        }
    }

    function resetFileTab($fileTab) {
        $fileTab.find('.alert').remove();
        $fileTab.find('.btn span').text('Téléchargez la première image');
        $fileTab.find('input').val('');
    }

    function submitImageFile($fileTab) {
        var $browseFileButton = $fileTab.find('.btn:eq(0)');
        var $fileInput = $browseFileButton.find('input');

        $fileTab.find('.alert').remove();
        $browseFileButton.find('span').text('Téléchargez la première image');
        $('#loading-indicator').show();
        // Check if file was uploaded.
        if (!($fileInput[0].files && $fileInput[0].files[0])) {
          $('#loading-indicator').hide();
            return;
        }

        $browseFileButton.prop('disabled', true);

        var file = $fileInput[0].files[0];

        isValidImageFile(file, function(isValid, message) {
            if (isValid) {
                var fileReader = new FileReader();

                fileReader.onload = function(e) {
                    // Show thumbnail and remove button.
                    $fileTab.prepend(getImageThumbnailHtml(e.target.result));
                };

                fileReader.onerror = function() {
                    $fileTab.prepend(getAlertHtml('Error loading image file.'));
                    $fileInput.val('');
                };

                fileReader.readAsDataURL(file);
            }
            else {
                $fileTab.prepend(getAlertHtml(message));
                $browseFileButton.find('span').text('Téléchargez la première image');
                $fileInput.val('');
            }

            $browseFileButton.prop('disabled', false);
        });
    }

}(jQuery));
