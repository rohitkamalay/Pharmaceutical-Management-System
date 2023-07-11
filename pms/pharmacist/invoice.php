<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['pmspid']==0)) {
  header('location:logout.php');
  } else{


// Code for deleting product from cart
if(isset($_GET['delid']))
{
$rid=intval($_GET['delid']);
$query=mysqli_query($con,"delete from tblcart where Id='$rid'");
 echo "<script>alert('Data deleted');</script>"; 
  echo "<script>window.location.href = 'cart.php'</script>";     


}



if(isset($_POST['submit']))
  {
    $custname=$_POST['customername'];
    $custmobilenum=$_POST['mobilenumber'];
    $billiningnum= mt_rand(100000000, 999999999);
    $modepayment=$_POST['modepayment'];


$query="update tblcart set BillingId='$billiningnum',IsCheckOut=1 where IsCheckOut=0;";  
$query.="insert into  tblcustomer(BillingNumber,CustomerName,MobileNumber,ModeofPayment) value('$billiningnum','$custname','$custmobilenum','$modepayment');";
$result = mysqli_multi_query($con, $query);
if ($result) {

echo '<script>alert("Invoice created successfully. Billing number is "+"'.$billiningnum.'")</script>';
echo "<script>window.location.href='search.php'</script>";

}
  
}
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
 
  <title>
    Pharmacy Management System - Invoice
  </title>
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
  <link href="assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="assets/css/argon-dashboard.css?v=1.1.0" rel="stylesheet" />

</head>

<body class="">
  <?php include_once('includes/navbar.php');?>
  <div class="main-content">
    <!-- Navbar -->
  <?php include_once('includes/sidebar.php');?>
    <!-- End Navbar -->
    <!-- Header -->
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      <!-- Table -->
      <div class="row">
        <div class="col" id="exampl">
          <div class="card shadow">
            <div class="card-header border-0">


              <h3 class="mb-4">Invoice #<?php echo $_SESSION['invoiceid']?></h3>
<?php     
$pmspid= $_SESSION['pmspid'];
$billingid=$_SESSION['invoiceid'];
$ret=mysqli_query($con,"select distinct tblcustomer.CustomerName,tblcustomer.MobileNumber,tblcustomer.ModeofPayment,tblcustomer.BillingDate from tblcart join tblcustomer on tblcustomer.BillingNumber=tblcart.BillingId where  tblcart.PharmacistId='$pmspid' and tblcustomer.BillingNumber='$billingid'");

while ($row=mysqli_fetch_array($ret)) {
?>

  <div class="table-responsive">
    <table class="table align-items-center" style="font-size:22px !important;" border="1">
            <tr>
<th>Customer Name:</th>
<td> <?php  echo $row['CustomerName'];?>  </td>
<th>Customer Number:</th>
<td> <?php  echo $row['MobileNumber'];?>  </td>
</tr>

<tr>
<th>Mode of Payment:</th>
<td colspan="3"> <?php  echo $row['ModeofPayment'];?>  </td>

</tr>
</table>

</div>
<?php } ?>


            </div>
            <div class="table-responsive" style="margin-top:2%">
              <table class="table align-items-center" style="font-size:22px;" border="1">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">S.NO</th>
                    <th scope="col">Medicine Name</th>
                    <th scope="col">Quantity</th>
                     <th scope="col">Price(per unit)</th>
                     <th scope="col">Total</th>
                    
                  </tr>
                </thead>
                <tbody>
                  <?php
$ret=mysqli_query($con,"select tblcart.ID,tblmedicine.MedicineName,tblcart.ProductQty,tblmedicine.Priceperunit from tblcart join tblmedicine on tblcart.ProductId=tblmedicine.ID  where tblcart.PharmacistId='$pmspid' and tblcart.BillingId='$billingid'");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>
              
                <tr>
                  <td><?php echo $cnt;?></td>
            
                 
                  <td><?php  echo $row['MedicineName'];?></td>
                  <td><?php  echo ($pq=$row['ProductQty']);?></td>
                  <td><?php  echo($ppu= $row['Priceperunit']);?></td>
                  <td><?php  echo($total=$pq*$ppu);?></td>

                </tr>
                
                <?php 
$cnt=$cnt+1;
$gtotal+=$total;
}?>
<tr>
                  <th colspan="4" style="text-align: center;">Grand Total</th>
                  <th colspan="2"><?php  echo $gtotal;?></th>
                </tr>
                </tbody>
              </table>
  
  <p style="margin-top:1%"  align="center">
  <i class="fa fa-print fa-2x" style="cursor: pointer;"  OnClick="CallPrint(this.value)" ></i>
</p>
            </div>
            <div class="card-footer py-4">
           
            </div>
          </div>
        </div>
      </div>
      <!-- Dark table -->
     
      <!-- Footer -->
    <?php include_once('includes/footer.php');?>
    </div>
  </div>
  <!--   Core   -->
  <script src="assets/js/plugins/jquery/dist/jquery.min.js"></script>
  <script src="assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!--   Optional JS   -->
  <!--   Argon JS   -->
  <script src="assets/js/argon-dashboard.min.js?v=1.1.0"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "argon-dashboard-free"
      });
  </script>
  <script>
function CallPrint(strid) {
var prtContent = document.getElementById("exampl");
var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
WinPrint.document.write(prtContent.innerHTML);
WinPrint.document.close();
WinPrint.focus();
WinPrint.print();
WinPrint.close();
}
</script>
</body>

</html>
<?php }  ?>