<?php

// importing the connection.php file 
include 'connection.php';

//Get image data from database

$result =$conn->query("SELECT imageData FROM imagetable ORDER BY imageID DESC LIMIT 1");
?>

<?php

if($result->num_rows > 0)
{
	?>
	<div class="gallery">
		<?php

		while($row =$result->fetch_assoc())
		{
			// below  html tag is used to display th image you uploaded.
			?>

			<img src="data:imageData/jpg;charset=urf8;base64,<?php echo base64_encode($row['imageData']);?>"/>



			<?php


		}
		?>

	</div>
	<?php	
}

else
{
	?>
	<p class="status error">Image not found....</p>
	<?php
}
?>