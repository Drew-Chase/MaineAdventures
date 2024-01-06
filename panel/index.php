<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/php/includes/auth.inc.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin Panel - Maine Adventures</title>

	<link rel="shortcut icon" href="/assets/images/icon.svg" type="image/x-icon">

	<!-- Pages Styling -->
	<link rel="stylesheet" href="/assets/css/min/main.min.css">
	<link rel="stylesheet" href="/assets/css/min/nav.min.css">
	<link rel="stylesheet" href="/assets/css/min/links.min.css">
	<link rel="stylesheet" href="/assets/css/min/scrollbar.min.css">
	<link rel="stylesheet" href="/assets/css/min/footer.min.css">
	<link rel="stylesheet" href="/assets/css/min/inputs.min.css">
	<link rel="stylesheet" href="/assets/css/min/panel.min.css">
	<link rel="stylesheet" href="/assets/css/min/quickview.min.css">
	<link rel="stylesheet" href="/assets/css/min/gallery.min.css">

	<!-- Responsive Styling -->
	<link rel="stylesheet" href="/assets/css/min/responsive.min.css">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="/assets/libraries/fontawesome/css/all.min.css">
	<!-- JQuery -->
	<script src="/assets/libraries/jquery.js"></script>
</head>

<body>
	<nav fixed="true" noanim=true>
		<span id="brand">
			<a href="/panel" title="Go Home">
				<img src="/assets/images/icon.svg" alt="Maine Adventures Logo">
				<span class="title"> Admin Panel </span>
			</a>
		</span>
		<div id="nav-items">
			<a href="/panel" class="nav-item" title="Goto Home Page">Home</a>
			<a href="#calendar" class="nav-item" title="Goto Calendar">Calendar</a>
			<div class="nav-item btn primary" id="search-button" title="Search">
				<i class="fa fa-search right"></i>
				Search
			</div>
			<a href="/" class="nav-item btn secondary" title="Goto Booking Page">Main Site</a>
		</div>
	</nav>
	<main>
		<section id="quickview">

			<h1>Quick View</h1>
			<p>This will give you a quick overview on todays progress</p>
			<section>
				<h2>Arrivals</h2>
				<div class="arrivals">

				</div>
			</section>
			<section>
				<h2>Departures</h2>
				<div class="departures">

				</div>
			</section>
			<section id="calendar">
				<h2>Calendar</h2>
				<div class="calendar">

				</div>
			</section>
		</section>
		<section id="cabins" class="col">
			<h1>Cabins</h1>
			<?php
			require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/php/includes/cabins.inc.php";
			require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/php/includes/hashids.inc.php";
			$list = $cabins->GetCabins();
			foreach ($list as $item) {
				$id = $item['id'];
				$name = $item["name"];
				$people = $item["people"];
				$price = $item["price"];
				$seasonal = $item["seasonal"] == 1;

				$imagePath = "/assets/images/cabins/$id.jpeg";
				$fallbackImage = "/assets/images/no-image.svg";
				$backgroundImage = file_exists($_SERVER["DOCUMENT_ROOT"] . $imagePath) ? $imagePath : $fallbackImage;

				echo '
			<div>
				<div class="cabin-item row center" id="' . $id . '">
						<div title="Upload Image" class="image-preview" onclick="uploadCabinImage(\'' . $id . '\')">
							<img src="' . $backgroundImage . '" />
						</div>
						<div class="input-item title">
							<label for="title-input">Name</label>
							<input type="text" name="title" id="title-input" placeholder="Cabin Title" value="' . $name . '">
						</div>
						<div class="input-item">
							<label for="price-input">Price</label>
							<input type="number" name="price" id="price-input" placeholder="Cabin Price" value="' . $price . '">
						</div>
						<div class="input-item">
							<label for="people-input">Cabin Capacity</label>
							<input type="number" name="people" id="people-input" placeholder="Cabin Capacity" value="' . $people . '">
						</div>
			
					<div class="row">
						<toggle class="seasonal">
							<option value="seasonal" ' . ($seasonal ? "selected" : "") . '>Seasonal</option>
							<option value="daily" ' . ($seasonal ? "" : "selected") . '>Daily</option>
						</toggle>
						<i id="delete-' . $id . '" class="fa-solid fa-trash delete-cabin-btn" title="Delete ' . $name . '" onclick="removeCabin(\'' . $id . '\')"></i>
					</div>
				</div>
			</div>
				';
			}

			?>
			<div class="center row">
				<div class="btn primary" id="save-cabins">Save Cabins!</div>
				<div class="btn secondary dark" id="add-cabin">Add Cabin</div>
			</div>
		</section>
		<section id="gallery" class="col dropzone">
			<div class="upload-msg">
				<p>Uploading (0 / 0)</p>
			</div>
			<h1>Gallery</h1>
			<div class="grid">


				<?php
				require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/php/includes/gallery-images.inc.php";
				$list = GetGalleryImages();
				foreach ($list as $image) {
					$name = $image;

					$imagePath = "/assets/images/gallery/$name";
					$fallbackImage = "/assets/images/no-image.svg";
					$backgroundImage = file_exists($_SERVER["DOCUMENT_ROOT"] . $imagePath) ? $imagePath : $fallbackImage;

					echo '
				<div class="gallery-image admin" style="background-image: url(\'/assets/images/gallery/sm/' . $image . '\')">
					<p class="title">' . basename($image, '.' . pathinfo($image, PATHINFO_EXTENSION)) . '</p>
					<img src="/assets/images/gallery/' . $image . '" alt="" loading="lazy">
				</div>';
				}

				?>
				<div id="add-image-button" title="Add new image">
					<i class="fa fa-plus"></i>
				</div>
			</div>
		</section>
	</main>

	<footer id="footer" class="center col">
		<img id="footer-logo" src="/assets/images/large-logo.svg" alt="">
		<p id="copyright">&copy; Copyright 2011-2023 Allagash Gateway Campsites & Cabins. All rights reserved.</p>
	</footer>

	<div class="search-modal center row">
		<div class="search-box center">
			<input type="text" name="search-input" id="search-input" placeholder="Search...">
		</div>
		<div class="search-results col">
		</div>
	</div>

	<!-- Page Scripts -->
	<script src="/assets/js/min/auth.min.js"></script>
	<script src="/assets/js/min/nav.min.js"></script>
	<script src="/assets/js/min/lf.min.js"></script>
	<script src="/assets/js/min/input.min.js"></script>
	<script src="/assets/js/min/gallery.min.js"></script>
	<script src="/assets/js/min/quickview.min.js"></script>



</body>

</html>