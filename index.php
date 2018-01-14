
<?php require_once 'header.inc.php' ?>
                        
<div class='container-fluid'>

    <?php
    if (Auth::isLoggedIn()) {
        require_once 'views/addNote.inc.php';
    } else {
        require_once 'views/login.inc.php';
    }

    ?>

    <ul class="list-group" id='notes-list'></ul>

</div>

<?php require_once 'footer.inc.php' ?>