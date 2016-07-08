<?php /*
	Copyright 2014-2015 Cédric Levieux, Jérémy Collot, ArmagNet

	This file is part of OpenTweetBar.

    OpenTweetBar is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    OpenTweetBar is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with OpenTweetBar.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<nav id="footer" class="navbar navbar-inverse navbar-bottom" role="navigation">

	<ul class="nav navbar-nav">
		<li <?php if ($page == "about") echo 'class="active"'; ?>><a href="about.php"><?php echo lang("about_footer"); ?></a></li>
	</ul>
	<p class="navbar-text pull-right"><?php echo lang("personae_footer"); ?></p>
</nav>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script>
	var sessionLanguage = "<?php echo $language; ?>";
	var fullDateFormat = "<?php echo lang("fulldate_format"); ?>";
</script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/bootbox.min.js"></script>
<script src="assets/js/moment-with-locales.js"></script>
<script src="assets/js/bootstrap-datetimepicker.js"></script>
<script src="assets/js/jquery.timer.js"></script>
<script src="assets/js/jquery.scrollTo.min.js"></script>
<script src="assets/js/ekko-lightbox.min.js"></script>
<script type="text/javascript">

$(function() {
	$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
	    event.preventDefault();
	    $(this).ekkoLightbox();
	});
});
</script>
<script src="assets/js/jquery.template.js"></script>
<script src="assets/js/strings.js"></script>
<script src="assets/js/user.js"></script>
<script src="assets/js/window.js"></script>
<script src="assets/js/pagination.js"></script>
<script src="assets/js/editor.js"></script>
<script src="assets/js/search.js"></script>

<!-- <?php echo "js/perpage/" . $page . ".js"; ?> -->
<?php
if (is_file("assets/js/perpage/" . $page . ".js")) {
	echo "<script src=\"assets/js/perpage/" . $page . ".js\"></script>\n";
}
?>
