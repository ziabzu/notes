<?php

?>

<div class="form-group">

  <label for="note">Note:</label>&nbsp;<span id='note-status'></span>
  <textarea class="form-control" rows="3" id="note" placeholder="Write new note here"></textarea>
  <button type="button" class="btn btn-primary btn-xs add-note" onclick="Note.saveNote('save-new', 0);">Save Note</button>

</div>
