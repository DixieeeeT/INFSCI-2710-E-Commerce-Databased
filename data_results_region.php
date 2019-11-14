<?php
  // 1. Create a database connection
  $dbhost = "localhost";
  $dbuser = "root"; // your username here
  $dbpass = "19960120toBY!!"; // your password here
  $dbname = "db"; // your db name here
  $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  // Test if connection succeeded
  if(mysqli_connect_errno()) {
    die("Database connection failed: " . 
         mysqli_connect_error() . 
         " (" . mysqli_connect_errno() . ")"
    );
  }
?>
<?php
	$request = "";
    if(isset($_POST['region_sales'])){
		$request = "region_sales";
		$data3_query = "SELECT Region.region_name AS Region, SUM((Transaction.product_quantity)*(Transaction.price)) AS Revenue FROM Transaction, Region, Salesperson, Store WHERE Transaction.emp_id=Salesperson.emp_id AND Salesperson.store_id=Store.store_id AND Store.region_id=Region.region_id GROUP BY Region.region_name";
		$data3_result = mysqli_query($connection, $data3_query);
		if (!$data3_result) {
			die("Database query failed."); // bad query syntax
		}
    }
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="js/jquery-3.4.1.js"></script>
	<script src="js/ricks.js"></script>
	<title>Customer Interface</title>
</head>
<body>
	<header class = "container" style = "text-align: center">
		<h3 class = "col" style="display:inline">XXX's Cars</h3>&nbsp;&nbsp;
		<a class = "col" href="customers.php">Customer Interface</a>&nbsp;&nbsp;
		<a class = "col" href="data.php">Data Aggregation</a>&nbsp;&nbsp;
		<a class = "col" href="employees.php">Employee Login</a>&nbsp;&nbsp;
	</header>
	<br>
	<h2 style = "text-align: center">View Data Aggregation Result.</h2>
	<br>
	<div class = "text-center">
		<table class = "table">
		<?php 
		switch ($request) {
			case "region_sales":
				echo "<tr>
					<td><b>Region</b></td>
					<td><b>Revenue</b></td>
					</tr>";
					break;
		}
		?>
		<?php
			while($subject = mysqli_fetch_assoc($data3_result)) {
				$region3 = $subject['Region'];
				$revenue3 = $subject['Revenue'];
				
				// output data from each row
				echo "<tr>";
				echo "<td>" . $region3 . "</td>";
				echo "<td>" . $revenue3 . "</td>";
				echo "</tr>";
			}
		?>
		</table>
	</div>
</body>
</html>

<?php
	// 5. Close database connection
	mysqli_close($connection);
?>