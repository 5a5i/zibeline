<?php

$page_id = $pageDetails["page_id"];
if ($_GET["id"] <> "") {
    // if we are on page.php page. get the parent id and fetch their related subpages
    $sql = "SELECT * FROM " . TABLE_PAGES . " WHERE status = 'A' AND parent = :parent ORDER BY sort_order ASC";
    try {
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":parent", db_prepare_input($pageDetails["parent"]));
        $stmt->execute();
        $pagesResults = $stmt->fetchAll();
    } catch (Exception $ex) {
       echo errorMessage($ex->getMessage());
    }

} elseif ($page_id <> "") {
    // On any other Page get the page id and fetch their related subpages
   $sql = "SELECT * FROM " . TABLE_PAGES . " WHERE status = 'A' AND parent = :parent ORDER BY sort_order ASC";
    try {
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":parent", db_prepare_input($page_id));
        $stmt->execute();
        $pagesResults = $stmt->fetchAll();
    } catch (Exception $ex) {
        echo errorMessage($ex->getMessage());
    }

}
?>

<div class="3u">

<?php
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        ?>
        <section>
            <h3><a href="logout.php">Logout</a></h3>
        </section>
    <?php }

    if (count($pagesResults) > 0) {
        ?>
        <section>
            <h2>sub pages</h2>
            <div>
                <div class="row">
                    <div class="12u">
                        <ul class="link-list">
                            <?php foreach ($pagesResults as $rs) { ?>
                                <li><a href="<?php echo stripslashes($rs["page_alias"]); ?>.php"><?php echo stripslashes($rs["page_title"]); ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>

                </div>
            </div>
        </section>
    <?php }

    $slidersql = "SELECT * FROM " . TABLE_JOURNAL . " WHERE 1 ORDER BY id DESC";
    try {
        $sliderstmt = $DB->prepare($slidersql);
        $sliderstmt->execute();
        $sliderresults = $sliderstmt->fetchAll();
    } catch (Exception $ex) {
        echo errorMessage($ex->getMessage());
    }
    ?>
<section>
    <div id="wowslider-container1">
        <div class="ws_images"><ul>
    <?php

    foreach ($sliderresults as $sliderrs) {
        ?>

        <li><!-- <a href="http://wowslider.net"> -->
            <img src="<?php echo "images/journal/".stripslashes($sliderrs["filename"]); ?>" alt="<?php echo stripslashes($sliderrs["title"]); ?>" title="<?php echo stripslashes($sliderrs["title"]); ?>" id="<?php echo "slider_".stripslashes($sliderrs["id"]); ?>"  width="300px" height="400px" />
        <!-- </a> --></li>
     <?php
    }
?>
        </ul></div>
        <!-- <div class="ws_bullets"><div>
        <a href="#" title="AJOC"><span><img src="slide/data1/tooltips/ajoc.jpg" alt="AJOC"/>1</span></a>
        <a href="#" title="Dalton Transaction"><span><img src="slide/data1/tooltips/c_635520l_3.jpg" alt="Dalton Transaction"/>2</span></a>
        <a href="#" title="Chempluschem"><span><img src="slide/data1/tooltips/chempluschem.jpg" alt="Chempluschem"/>3</span></a>
        <a href="#" title="NJC"><span><img src="slide/data1/tooltips/f87d81a831.jpg" alt="NJC"/>4</span></a>
        <a href="#" title="JOC"><span><img src="slide/data1/tooltips/joc.jpg" alt="JOC"/>5</span></a>
        <a href="#" title="PRAXIS"><span><img src="slide/data1/tooltips/praxis.png" alt="PRAXIS"/>6</span></a>
        <a href="#" title="Accounts"><span><img src="slide/data1/tooltips/acrvol47issue7.jpg" alt="Accounts"/>7</span></a>
        </div></div> -->
        <!-- <div class="ws_script" style="position:absolute;left:-99%"><a href="http://wowslider.net">html5 slider</a> by WOWSlider.com v8.8</div> -->
        <div class="ws_shadow"></div>
            </div>
<script type="text/javascript" src="slide/engine1/wowslider.js"></script>
<script type="text/javascript" src="slide/engine1/script.js"></script>
    </section>
    <section>
        <h2>Follow us on Google Plus</h2>
        <div>
            <!-- <div class="row">
                <div class="12u">
                    <div class="g-person" data-href="https://plus.google.com/102365548162294932872"  data-rel="author" data-layout="landscape"></div>
                </div>
                 <script type="text/javascript">
                    (function() {
                        var po = document.createElement('script');
                        po.type = 'text/javascript';
                        po.async = true;
                        po.src = 'https://apis.google.com/js/platform.js';
                        var s = document.getElementsByTagName('script')[0];
                        s.parentNode.insertBefore(po, s);
                    })();
                </script>
            </div> -->
        </div>
    </section>
    <section>
        <h2>Follow us on Twitter</h2>
        <div>
            <div class="row">
                <div class="12u">
                    <a class="twitter-follow-button" href="https://twitter.com/RaziPublishing" data-show-count="true" data-size="large" data-lang="en"  >Follow @RaziPublishing</a>
            		<script type="text/javascript">
            		window.twttr = (function (d, s, id) {
            		var t, js, fjs = d.getElementsByTagName(s)[0];
            		if (d.getElementById(id)) return;
            		js = d.createElement(s); js.id = id;
            		js.src= "https://platform.twitter.com/widgets.js";
            		fjs.parentNode.insertBefore(js, fjs);
            		return window.twttr || (t = { _e: [], ready: function (f) { t._e.push(f) } });
            		}(document, "script", "twitter-wjs"));
            		</script>
                </div>
            </div>
        </div>
    </section>
    <section>
        <h2>Like us on facebook</h2>
        <div>
            <div class="row">
                <!-- <div class="12u">
                    <iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Frazipublishingofficial&amp;width&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true&amp;appId=198210627014732" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:290px;" allowTransparency="true"></iframe>
                </div> -->
            </div>
        </div>
    </section>
</div>
