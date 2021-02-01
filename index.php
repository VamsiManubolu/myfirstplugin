<!DOCTYPE html>
<html>
<head>
	<title></title>

	<!-- css code -->

	<style type="text/css">
		

	.title{
    font-family: sans-serif;
    color: #dc2d5e;
    text-align: center;
}
.heading{

	color: #000000;
}
.tabContainer{
    width: 100%;
    height: 350px;
}
.contenttable{

	border-collapse: collapse;
	margin:25px 0 0 250px;
	font-size: 0.9em;
	min-width: 400px;
}
.contenttable thead tr{
	background-color: #009879;
	color: #ffffff;
	text-align: left;
	font-weight: bold;
}

.contenttable th,
.contenttable td {
  padding: 12px 15px;
}
.contenttable tbody tr {
  border-bottom: 1px solid #dddddd;
}
.content-table tbody tr:nth-of-type(even) {
  background-color: #f3f3f3;
}

.content-table tbody tr:last-of-type {
  border-bottom: 2px solid #009879;
}

.content-table tbody tr.active-row {
  font-weight: bold;
  color: #009879;
}
.tabContainer .buttonContainer{
    height: 15%;
}
.tabContainer .buttonContainer button{
    width: 50%;
    height: 100%;
    float: left;
    border: none;
    outline:none;
    cursor: pointer;
    padding: 10px;
    font-family: sans-serif;
    font-size: 18px;
    background-color: #eee;
}
.tabContainer .buttonContainer button:hover{
    background-color: #d7d4d4;
}
.tabContainer .tabPanel{
    height: 85%;
    background-color: gray;
    color: white;
    text-align: center;
    padding-top: 105px;
    box-sizing: border-box;
    font-family: sans-serif;
    font-size: 22px;
    display: none;
}
	</style>
</head>
<body>


	<h1 class="title">Make Your Own Gravatar</h1>

	<div class="tabContainer">
		<div class="buttonContainer">
			<button onclick="showPanel(0,'#bdc3c7')">Upload Gravatar</button>
			<button onclick="showPanel(1,'#2c3e50')">Search User</button>
		</div>
		<div class="tabPanel">
			
			<h1 class="heading">Please upload your photo:</h1>


	<div id="content"> 
  
        <form method="POST" 
              action="" 
              enctype="multipart/form-data">
           
            <input type="file" 

                   name="uploadfile" 
                   value="" /> 

            <br>       
  
            <div> 
                <button type="submit"
                        name="upload"> 
                  UPLOAD 
                </button> 
            </div> 
            <br>
        </form> 
    </div>

    <hr>
		</div>
		<div class="tabPanel">
			<form method="post">
			<label>Search User</label>

			<input type="text" name="useremail" placeholder="Enter your Email Id" style="font-style: italic">
			<br>
			<br>
			<br>
			<br>

			<button type="submit" name="Search">Search</button>
			</form>
			<hr class="line">
		</div>
	</div>

	<script type="text/javascript">

		var tabButtons=document.querySelectorAll(".tabContainer .buttonContainer button");
		var tabPanels=document.querySelectorAll(".tabContainer  .tabPanel");

		function showPanel(panelIndex,colorCode) {
    		tabButtons.forEach(function(node){
        	node.style.backgroundColor="";
        	node.style.color="";
    		});
    	tabButtons[panelIndex].style.backgroundColor=colorCode;
    	tabButtons[panelIndex].style.color="white";
    	tabPanels.forEach(function(node){
        	node.style.display="none";
    });
    	tabPanels[panelIndex].style.display="block";
    	tabPanels[panelIndex].style.backgroundColor=colorCode;
}
showPanel(0,'#bdc3c7');

		


	</script>

</body>
</html>





<?php

// importing the connection.php file
include "connection.php";

// when user clicks the upload button then if condition is true
if(isset($_POST['upload']))
{

	
	$status='error';
	if(!empty($_FILES["uploadfile"]["name"]))
	{
		//Get File info
		$fileName = basename($_FILES["uploadfile"]["name"]);


		$filetype = pathinfo($fileName,PATHINFO_EXTENSION);

		// Allow certain file formats

		$allowTypes = array('jpg','png','jpeg','gif');

		if(in_array($filetype, $allowTypes))
		{
			$filename = $_FILES["uploadfile"]["name"];
			$image = $_FILES['uploadfile']['tmp_name'];
			$imgContent = addslashes(file_get_contents($image));

			//created my custom table with name imagetable having imageID(primary key),imageType,imageData as columns

			//insert image content in to imagetable in the vamsiminiOrange database

			$insert = $conn->query("INSERT into imagetable(imageType,imageData,uploaded) VALUES ('$filename','$imgContent',NOW())");

			// if inserted the values succesfully then following if condition is TRUE
			if($insert)
			{
				$status='success';
				// message to display after uploading successfully
				$statusMsg = "File uploaded successfully";
				// storing uploaded image in C:\xampp\htdocs\wptest\wp-content\uploads directory
				wp_upload_bits($_FILES['uploadfile']['name'], null, file_get_contents($_FILES['uploadfile']['tmp_name']));


				require( dirname(__FILE__) . '/../../../wp-load.php' );

				// to get the url from0


 
				$wordpress_upload_dir = wp_upload_dir();

				$profilepicture = $_FILES['uploadfile'];
				$new_file_path = $wordpress_upload_dir['path'] . '/' . $profilepicture['name'];
				
				$imageurl='http://localhost/wptest/wp-content/uploads/2021/01/';

				//image url is inserted in my user meta table with the help of user ID
				//concatinating the two strings to get the image url
				$myurl=$imageurl.$fileName;




				//getting current user details
				$current_user=wp_get_current_user();

    			$id=$current_user->ID;


    			// adding new meta key for the current user id and adding the metavalue as imageurl

				update_user_meta($id, 'userurl',$myurl);


			}

			else
			{
				$statusMsg = "File upload failed, please try again.";
			}
		}

		// if uploaded file is not from the $allowtypes array then the ollowing message is displayed

		else
		{
			$statusMsg = "Sorry , only JPG,JPEG,PNG,& GiG files are allowed to upload.";
		}
	}

	// if file is not choosen
	else
	{
		$statusMsg ="Please select an image file to upload.";
	}

	echo "<b>$statusMsg</b>";
	if($status=='success')
	{
		?>
		<br>
		<?php
		echo "<h3 your gravatar!!!!!!!! </h3>";

		?>
		<br>
		<br>
		<?php
		// below function is used to display the gravatar that user uploaded.
		require_once 'views.php';

	


	}

	
  
	

}

// For Fetching user details

if(isset($_POST['Search']))
{
		
		$user=get_user_by('email', $_POST['useremail']);
		if(!empty($user))
		{
			?>
		<!DOCTYPE html>
		<html>
		<body>
		<table class="contenttable">
			<thead>
				<tr>
						<th>profile image</th>
		    			<th>id</th>
		    			<th>First name</th>
		    			<th>Last name</th>
		    			<th>email</th>
		    
	    		</tr>
	    		<br>
				


			</thead>
		<tbody>
			<tr>
		 <td><?php echo get_avatar($user->ID);?></td>	
	     <td><?php echo $user->ID; ?></td>
	     <td><?php echo $user->first_name; ?></td>
	     <td><?php echo $user->last_name ;?></td>
	     <td><?php echo $user->user_email;?></td>
	     


	 	</tr>
		</tbody>

		
	 	</table>
		</body>
		</html>


		
			
		

	<?php

		}

		else
		{
			echo "<h3>User  Not Found</h3>";
		}
		
}



?>

