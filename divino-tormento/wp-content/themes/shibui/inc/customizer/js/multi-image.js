jQuery(document).ready(function($) {
    "use strict";
    var file_frame, thumbnails;

    // clicking the upload button will open the media frame
    // and update the input field value
    $('a.multi-images-upload').each(function() {
        var button = $(this),
            inputId = button.data('store');

        button.on('click', function(evt) {

            evt.preventDefault();

            // file frame already created, return
            if (file_frame) {
                file_frame.open();
                return;
            }

            // create the file frame
            file_frame = wp.media.frames.file_frame = wp.media({
                title: 'Select Images',
                button: {
                    text: 'Use Selected Images',
                },
                library: {
                    type: 'image'
                },
                multiple: 'add'
            });

            // get the selected attachments when user selects
            file_frame.on('select', function(evt) {
                var selected = file_frame.state().get('selection').toJSON(),
                    store = $(inputId),
                    urls = [],
                    image_ids = [];
                for (var i = selected.length - 1; i >= 0; i--) {
                    urls.push(selected[i].url);
                    image_ids.push(selected[i].id);
                }
                store.val(urls).trigger('change');
                store.val(image_ids).trigger('change');
                store.trigger('updateThumbnails', {
                    urls: urls,
                    image_ids: image_ids
                });

            });
            // open the file frame
            file_frame.open();
        });
    });

    // remove all images when the remove images button is pressed
    $('a.multi-images-remove').each(function() {
        var button = $(this),
            input = $(button.data('store'));

        button.on('click', function(evt) {
            evt.preventDefault();
            input.val('').trigger('change');
            input.trigger('updateThumbnails', {
                urls: '',
                image_ids: ''
            });
        });
    });

    //update the images when the input value changes
    $('input.multi-images-control-input').each(function() {

        var input = $(this),
            thumbContainer = $(input.data('thumbs-container'));

        input.on('updateThumbnails', function(evt, args) {
            var urls = args.urls;
            var image_ids = args.image_ids;
            //remove old images
            thumbContainer.empty();
            // for each image url in the value create and append an image element to the list
            for (var i = urls.length - 1; i >= 0; i--) {
                var li = $('<li/>');
                li.attr('style', 'background-image:url(' + urls[i] + ');');
                li.attr('class', 'thumbnail');
                li.attr('data-src', urls[i]);
                li.attr('data-id', image_ids[i]);
                thumbContainer.append(li);
            }
        });
    });

    // make the images sortable
    $('.customize-control-multi-image .thumbnails').sortable({
        items: '> li',
        axis: 'y',
        opacity: 0.6,
        distance: 3,
        cursor: 'move',
        delay: 150,
        tolerance: 'pointer',
        update: function(evt, ui) {
            var t = $(this),
                urls = [],
                image_ids = [],
                input;
            $(t.find('li')).each(function() {
                urls.push($(this).data('src'));
                image_ids.push($(this).data('id'));
            });
            input = $(t.data('store'));
            input.val(urls).trigger('change');
            input.val(image_ids).trigger('change');
            t.sortable('refreshPositions');
        }
    }).disableSelection();
});