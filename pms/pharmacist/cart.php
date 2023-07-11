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
$_SESSION['invoiceid']=$billiningnum;
echo '<script>alert("Invoice created successfully. Billing number is "+"'.$billiningnum.'")</script>';
echo "<script>window.location.href='invoice.php'</script>";

}
  
}
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
 
  <title>
    Pharmacy Management System - Cart
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
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
              <h3 class="mb-0">Cart</h3>
              <form method="post"  name="submit" method="post" action="">
                <p style="font-size:16px; color:red" align="left"> <?php if($msg){
    echo $msg;
  }  ?> </p>
  <div class="row">
  <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-username">Customer Name</label>
                        <input type="text" id="customername" name="customername" class="form-control form-control-alternative"  required="true" style="border:1px #000 solid;">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-username">Customer Mobile Number</label>
                        <input type="text" id="mobilenumber" name="mobilenumber" class="form-control form-control-alternative" required="true" maxlength="10" pattern="[0-9]+" style="border:1px #000 solid;">
                      </div>
                    </div>

  <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-username">Mode of payment</label>
                   <input type="radio" name="modepayment" value="cash" checked="true"> Cash
                           <input type="radio" name="modepayment" value="card"> Card
                      </div>
                    </div>

                    <div class="pl-lg-4">
                 <div class="text-center">
                  <button class="btn btn-primary my-4" type="submit" name="submit">Submit</button>
                </div>
                </div>
              </div>
                
              </form>
              
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">S.NO</th>
                    <th scope="col">Medicine Name</th>
                    <th scope="col">Quantity</th>
                     <th scope="col">Price(per unit)</th>
                     <th scope="col">Total</th>

                    <th scope="col">Action</th>
                    
                  </tr>
                </thead>
                <tbody>
                  <?php
                 $pmspid= $_SESSION['pmspid'];
$ret=mysqli_query($con,"select tblcart.ID,tblmedicine.MedicineName,tblcart.ProductQty,tblmedicine.Priceperunit from tblcart join tblmedicine on tblcart.ProductId=tblmedicine.ID where tblcart.IsCheckOut='0' && tblcart.PharmacistId='$pmspid'");
$cnt=1;
$num=mysqli_num_rows($ret);
if($num>0){
while ($row=mysqli_fetch_array($ret)) {

?>
              
                <tr>
                  <td><?php echo $cnt;?></td>
            
                 
                  <td><?php  echo $row['MedicineName'];?></td>
                  <td><?php  echo ($pq=$row['ProductQty']);?></td>
                  <td><?php  echo($ppu= $row['Priceperunit']);?></td>
                  <td><?php  echo($total=$pq*$ppu);?></td> 
                  <td><a href="cart.php?delid=<?php echo $row['ID'];?>" onclick="return confirm('Do you really want to Delete ?');">Delete</a></td>
                </tr>
                
                <?php 
$cnt=$cnt+1;
$gtotal+=$total;
}?>
<tr>
                  <th colspan="4" style="text-align: center;">Grand Total</th>
                  <th colspan="2"><?php  echo $gtotal;?></th>
                </tr>
<?php } else {?>

  <tr>
<td colspan="6" style="color:red; text-align:center"> No item found in cart</td>
  </tr>
<?php } ?>

                </tbody>
              </table>
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
</body>

</html>
<?php }  ?>