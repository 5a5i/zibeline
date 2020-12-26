<?php

require("libs/config.php");
$pageDetails = getPageDetailsByName($currentPage);

include("header.php");
?>


<div id="main">

    <div class="container">
<div class="row main-row">
    <div class="8u">
        <section class="left-content">
        	<div class="row">
        	<div class="col-25-6">
            <h2><?php echo stripslashes($pageDetails["page_title"]); ?></h2>
        	</div>
            <div class="col-75-6">
                <input type="text" name="search" id="myInput" value="" autocomplete="off" placeholder="          search journal" />
            </div>
            </div><br>

<?php
    $sql = "SELECT * FROM " . TABLE_JOURNAL . " WHERE 1 ORDER BY id DESC";
    try {
        $stmt = $DB->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
    } catch (Exception $ex) {
        echo errorMessage($ex->getMessage());
    }
    ?>

    <table align="center" border="0" cellspacing="0" cellpadding="0" width="100%" id="table">
    <?php

    foreach ($results as $rs) {
        ?>
    <tr class="spaceUnder">
        <td class="col-35-6"><img src="<?php echo "images/journal/".stripslashes($rs["filename"]); ?>" width="200px" height="300px"></td>
        <td class="col-67-6"><h1><label><?php echo stripslashes($rs["title"]); ?></label></h1><br>
                <label><?php echo stripslashes($rs["description"]); ?></label><br><br>
                <a href="edit-journal.php?edit=<?php echo ($rs["id"]); ?>">Edit</a></td>
    </tr>
     <?php
    }
?>
</table>
        </section>
    </div>
    <!--sidebar starts-->
	<?php include("sidebar.php"); ?>
    <!--sidebar ends-->
</div>

<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $('#myInput').off('keyup');
        $('#myInput').on('keyup', function() {
            // Your search term, the value of the input
            var searchTerm = $('#myInput').val();
            // table rows, array
            var tr = [];

            // Loop through all TD elements
            $('#table').find('td').each(function() {
                var value = $(this).html();
                // if value contains searchterm, add these rows to the array
                if (value.toLowerCase().includes(searchTerm.toLowerCase())) {
                    tr.push($(this).closest('tr'));

                }
            });

            // If search is empty, show all rows
            if ( searchTerm == '') {
                $('tr').show();
            } else {
                // Else, hide all rows except those added to the array
                $('tr').not('thead tr').hide();
                tr.forEach(function(el) {
                    el.show();
                });
            }
        });
    });
</script>
<?php
include("footer.php");
?>
