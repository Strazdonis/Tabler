<html>
	<head>
	<title>Img2Tbl | Strazdonis</title>
	<link rel=stylesheet href="styles.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<style type="text/css">
			.table {
				border-spacing: 0px;
				margin-top:10px;
			}
			.tbody {

			}
			.tr {

			}
			.td {

			}
		</style>
	</head>
<body>
<?php
if(isset($_POST['submit'])) {
function hexify($R, $G, $B) {

    $R = dechex($R);
    if (strlen($R)<2)
    $R = '0'.$R;

    $G = dechex($G);
    if (strlen($G)<2)
    $G = '0'.$G;

    $B = dechex($B);
    if (strlen($B)<2)
    $B = '0'.$B;

    return '#' . $R . $G . $B;
}

$photo = $_FILES['pic']['tmp_name'];
$photo_type = $_FILES['pic']['type'];
list($width, $height) = getimagesize($photo);

if($photo_type === "image/jpeg") {
	$img = imagecreatefromjpeg($photo);
}
elseif($photo_type === "image/png") {
	$img = imagecreatefrompng($photo);
}

else {
	$error = "Unfortunately this image type is not supported. Only PNG & JPEG images are supported currently.";
}
if(!isset($error)) {
?>
<center>
	Pixel spacing: <input type="range" min="0" max="100" value="0" class="spacing" id="spacing">
	Pixel height: <input type="range" min="0" max="100" value="0" class="height" id="height">
	Pixel width: <input type="range" min="0" max="100" value="0" class="width" id="width">
	<table class="table">
		<tbody class="tbody">
			<?php for ($i=0; $i < $height; $i++) { 
				echo "<tr class='tr'>";
				for ($j=0; $j < $width; $j++) { 
					$rgb = imagecolorat($img, $j, $i);
					$r = ($rgb >> 16) & 0xFF;
					$g = ($rgb >> 8) & 0xFF;
					$b = $rgb & 0xFF;
					echo "<td class='td' bgcolor='". hexify($r, $g, $b). "'></td>";
				}
				echo "</tr>";
			} ?>
		</tbody>
	</table>
	<p>Inspired by <a href="https://www.reddit.com/r/ProgrammerHumor/comments/8dm09t/a_little_html_and_pasiance_is_the_key/">This magic</a></p>
	<p>Check the HTML Source</p>
	<p><a class="btn btn-primary" href="index.php">Go back</a></p>
</center>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		$(".spacing").on("change", function() {
			$(".table").css("border-spacing", $(this).val());
		});
		$(".height").on("change", function() {
			$(".tr").css("height", $(this).val());
		});	
		$(".width").on("change", function() {
			$(".td").css("width", $(this).val());
		});

	});
</script>
<?php 
} else {
	echo "<div class='error'>$error</div>";
}
} 
?>
</html>