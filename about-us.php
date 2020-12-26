<?php

require("libs/config.php");
$pageDetails = getPageDetailsByName($currentPage);

include("header.php");
?>
<div class="row main-row">
    <div class="8u">
        <section class="left-content">
            <h2><?php echo stripslashes($pageDetails["page_title"]); ?></h2>
            <?php echo stripslashes($pageDetails["page_desc"]); ?>
            <p style="text-align: justify;">Zibeline International Publishing is rendering a vital service in the quality publication that publishes peer-reviewed print and online scientific, technical and medical journals. These titles are indexed in recognized indexing agencies. Zibeline has an extensive library of Books in the areas of science, technology and health sciences. Zibeline Books publishes monographs, handbooks, conference proceedings, textbooks, review volumes, biographies and autobiographies. Being a cutting-edge technology publisher, at Zibeline International Publishing make use of a wide range of innovative tools and workflows to offer a long list of services to our authors, including:</p>
			<ol>
			    <li>Online submission and editorial management system, professional review and editorial assistance</li>
			    <li>Quick turnaround, ranging from one to a few months, from manuscript submission to publication</li>
			    <li>No limit in manuscript length, e.g. for large revisionary works, checklists, catalogues, conference proceedings, monographs</li>
			    <li>Innovative, non-conventional article types, including various research objects and research cycles</li>
			    <li>Publication in three formats: semantically enhanced HTML, PDF and machine-readable JATS XML</li>
			    <li>Immediate alert services through e-mail and RSS feeds to speed up dissemination of the published works</li>
			    <li>Rapid distribution to scientific databases, indices and search engines ( Ei Compendex, Scopus ,<b> </b>Web of Science, PubMed, Google Scholar, CAB Abstracts, DOAJ Content and others )</li>
			    <li>Advanced publishing technologies, possibilities for data publication and various semantic enhancements</li>
			    <li>Wide dissemination through social networks, press releases and dedicated PR campaigns</li>
			    <li>Professional design and layout, high quality printing and binding, options for print-on-demand</li>
			</ol>
        </section>
    
    </div>
    <!--sidebar starts-->
	<?php include("sidebar.php"); ?>    
    <!--sidebar ends-->
</div>
<?php
include("footer.php");
?>