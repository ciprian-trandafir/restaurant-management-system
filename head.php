<link rel="icon" type="image/x-icon" href="assets/favicon.ico">
<link rel="stylesheet" type="text/css" href="css/theme.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/loading.css">

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<script src="./js/jquery-1.11.3.min.js"></script>

<script>
    <?php
        echo "var BASE_URL = '".Link::get_base_url()."';";
        echo "var AJAX_URL = '".Link::getLink('ajax', 'events')."'";
    ?>
</script>
