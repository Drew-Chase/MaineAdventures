<?php
if (!isset($page)) {
	$page = -1;
}
if (!isset($static)) {
	$static = false;
}
if (!isset($noanim)) {
	$noanim = false;
}
?>
<script src="https://lfinteractive.net/assets/js/min/lf.min.js"></script>
<nav <?php if ($static) echo "static";
echo $noanim ? " noanim='true'" : " noanim='false'"; ?> >
	<span id="brand">
		<a href="/" title="Go Home">
			<img src="/assets/images/icon.svg" alt="Maine Adventures Logo">
			<span class="title"> Maine Adventures </span>
		</a>
	</span>
	<svg id="nav-hamburger" width="56" height="46" viewBox="0 0 56 46" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path id="top-bar" d="M3 3H53" stroke="white" stroke-width="5" stroke-linecap="round" />
		<path id="middle-bar" d="M3 23H53" stroke="white" stroke-width="5" stroke-linecap="round" />
		<path id="bottom-bar" d="M3 43H53" stroke="white" stroke-width="5" stroke-linecap="round" />
	</svg>


	<div id="nav-items">
		<a href="/" class="nav-item <?php echo $page == 0 ? "selected" : "" ?>" title="Goto Home Page">Home</a>
		<a href="/services" class="nav-item <?php echo $page == 1 ? "selected" : "" ?>" title="Goto Services Page">Services</a>
		<a href="/gallery" class="nav-item <?php echo $page == 2 ? "selected" : "" ?>" title="Goto Services Page">Gallery</a>
		<a href="/booking" class="nav-item btn primary" title="Goto Booking Page">Schedule Trip</a>
	</div>
</nav>