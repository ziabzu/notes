// module pattern to avoid conflicts

var Note = (function () {

    function saveNote(action, id)
    {

        var text = (id === 0) ? $('#note').val() : $('#note-' + id + ' .edit-note-input').val();

        // Validation
        if ($.trim(text) == '') {
            alert('Please write something');
            return false;
        }

        var data = [{ 'text': text, 'action': action, 'id': id }];
        toggleNewNote(true);

        $.ajax(
            {

                url: 'asynch/note.php',
                data: { data: JSON.stringify(data) },
                type: 'post',
                dataType: 'json',
                //contentType: "application/json; charset=utf-8",
                beforeSend: function (xhr) {
                    if (xhr && xhr.overrideMimeType) {
                        xhr.overrideMimeType('application/json;charset=utf-8');
                    }
                },
                success: function (data) {

                    if (data['status']) {
                        if (id == 0) { // new note added
                            var html = getNoteRowHTML(data['data'], $('#note').val());

                            $('#notes-list').prepend(html).fadeIn('slow');
                            $('#note').val('');
                        } else { // Edited one saved
                            $('#note-text-' + id).html(text);
                            cancelEdit(id);
                        }
                        
                        $('#note-status')
                        .html('Note Added succussfully!!!')
                        .addClass('green');
                        
                        setTimeout(function () {
                            $('#note-status').html(''); }, 3000);
                    } else {
                        $('#note-status')
                        .html('Some error occured')
                        .addClass('red');

                        $('#note-status').html('').delay(3000);
                    }

                    toggleNewNote(false);

                }

            }
        );
    }

    function setEditNote(id)
    {

        $('#note-' + id + ' .edit-note-input').val($('#note-text-' + id).html());

        $('.node-edit').hide();
        $('.node-show').show();

        $('#note-' + id + ' .note-view').hide('slow');
        $('#note-' + id + ' .note-edit').show('slow');
   
    }

    function cancelEdit(id)
    {

        $('.node-edit').show();
        $('.node-show').hide();

        $('#note-' + id + ' .note-view').show('slow');
        $('#note-' + id + ' .note-edit').hide('slow');
   
    }

    function getNoteRowHTML(data, text, alternative)
    {


        return "<li class='list-group-item" + (alternative % 2 ? " list-group-item-info" : "") + "' id='note-" + data['id'] + "'>"

                    + "<span class='note-view'>"
                        + "<div class='media'>"
                              + "<div class='media-body'>"

                                   + "<div class='btn-group btn-group-xs'>"
                                    + "<a href='#' onclick='Note.setEditNote(" + data['id'] + ");' class='btn btn-default'>"
                                        + "<span class='glyphicon glyphicon-pencil'></span>"
                                    + "</a>"
                                    + "<a href='#' class='btn btn-default btn-danger' data-toggle='tooltip' "
                                            + "data-placement='left' title='Delete this note!' onclick='Note.deleteNote(" + data['id'] + ")'>"
                                      + "<span class='glyphicon glyphicon-trash'></span>"
                                    + "</a>"
                                  + "</div>"

                                + "&nbsp;&nbsp;<span id='note-text-" + data['id'] + "'>" + text + "</span>&nbsp;"
                                + "&nbsp;&nbsp;<div class='small text-muted text-right'>" + data['createdDate'] + "</div>"

                              + "</div>"

                        + "</div>"
                    + "</span>"
                    + "<span class='note-edit'>"

                        + "<textarea class='form-control edit-note-input' rows='2'></textarea>"
                          + "<button type='button' class='btn btn-primary btn-xs' onclick='Note.saveNote(\"save-edit\", " + data['id'] + ");'>"
                            + "<i class='glyphicon glyphicon-floppy-saved'></i>&nbsp;Save Note</button>&nbsp;"
                          + "<button type='button' class='btn btn-xs' onclick='Note.cancelEdit(" + data['id'] + ");'>"
                            + "<i class='glyphicon glyphicon-remove'></i>&nbsp;Cancel Editing</button>"

                    + "</span>"

                + "</li>";

    }

    function load()
    {

        var data = [{ 'action': 'load' }];

        $.ajax(
            {

                url: 'asynch/note.php',
                data: { data: JSON.stringify(data) },
                type: 'post',
                dataType: 'json',
                //contentType: "application/json; charset=utf-8",
                beforeSend: function (xhr) {
                    if (xhr && xhr.overrideMimeType) {
                        xhr.overrideMimeType('application/json;charset=utf-8');
                    }
                },
                success: function (data) {

                    if (data['status']) {
                        var html = '';

                        var i = 0;
                        // here is the code to draw html from returned json
                        $.each(
                            data['data'],
                            function (index, row) {

                                html = html + getNoteRowHTML(row, row.text, i++);

                            }
                        );

                        $('.loader').slideUp('slow');

                        $('#notes-list')
                            .hide()
                            .html(html)
                            .fadeIn(2000);
                    } else {
                        // Write here some laoding error message
                    }

                }

            }
        );


    }

    function deleteNote(noteId)
    {

        if (!confirm('Are you sure you want to delete that note!!')) {
            return false; };

        var data = [{ 'id': noteId, 'action': 'delete' }];

        $.ajax(
            {

                url: 'asynch/note.php',
                data: { data: JSON.stringify(data) },
                type: 'post',
                dataType: 'json',
                //contentType: "application/json; charset=utf-8",
                beforeSend: function (xhr) {
                    if (xhr && xhr.overrideMimeType) {
                        xhr.overrideMimeType('application/json;charset=utf-8');
                    }
                },
                success: function (data) {

                    data['status'] ? $('#note-' + noteId).fadeOut('slow') : alert('Error');

                }

            }
        );

    }

    function toggleNewNote(flag)
    {

        $('.add-note').val(' ');
        (flag) ? $('.add-note').addClass('disabled') : $('.add-note').removeClass('disabled');

    }

    return {

        setEditNote: function (text) {

            setEditNote(text);

        },
        cancelEdit: function (id) {

             cancelEdit(id);

        },
        saveNote: function (action, id) {

            saveNote(action, id);

        },
        deleteNote: function (id) {

            deleteNote(id);
            
        },
        load: function () {

            load();
            
        }

    };

})();


$(
    function () {
    // Call after page loads completely

        if ($('#user-loggedin').val() * 1) { // if logged in then send request to the server
               Note.load();
        }

    }
);

