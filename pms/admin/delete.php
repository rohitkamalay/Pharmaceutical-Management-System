<?php 
session_start();
include 'includes/dbconnection.php';
if (isset($_GET['medicine'])) 
{
	if ($con->query("delete from tblmedicine where id = '$_GET[medicine]'")) 
	{
		header("location:manage-medicine.php");
	}
	else
		echo "error is:".$con->error;
}
if (isset($_GET['pharmacist'])) 
{
	if ($con->query("delete from tblpharmacist where id = '$_GET[pharmacist]'")) 
	{
		header("location:manage-pharmacist.php");
	}
	else
		echo "error is:".$con->error;
}
if (isset($_GET['company'])) 
{
	if ($con->query("delete from tblcompany where id = '$_GET[company]'")) 
	{
		header("location:manage-company.php");
	}
	else
		echo "error is:".$con->error;
}


 ?>