<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['pmspid']==0)) {
  header('location:logout.php');
  } else{
// Code for add to cart

if(isset($_POST['cart']))
{
$pmid=$_SESSION['pmspid'];
$pid=$_POST['mid'];
$pqty=$_POST['pqty'];
$ischecout=0;
$remainqty=$_SESSION['rqty'];
if($pqty<=$remainqty)
{
$query=mysqli_query($con,"insert into tblcart(PharmacistId,ProductId,ProductQty,IsCheckOut) value('$pmid','$pid','$pqty','$ischecout')");
 echo "<script>alert('Medicine has been added in to the cart');</script>"; 
  echo "<script>window.location.href = 'search.php'</script>";     
} else{
$msg="You can't add quantity more than Remaining quantity";

}





}
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
 
  <title>
    Pharmacy Management System - Search Medicines
  </title>
  <!-- Favicon -->
  
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
              <form method="post"  name="search" method="post" action="">
                <p style="font-size:16px; color:red" align="left"> <?php if($msg){
    echo $msg;
  }  ?> </p>
  <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-username">Search Medicine</label>
                        <input type="text" id="searchdata" name="searchdata" class="form-control form-control-alternative" value="" required="true"  style="border:1px #000 solid;" placeholder="Search by Medicine Name">
                      </div>
                    </div>
                    <div class="pl-lg-4">
                 <div class="text-center">
                  <button class="btn btn-primary my-4" type="submit" name="search">Search</button>
                </div>
                </div>
                
              </form>
              <?php
if(isset($_POST['search']))
{ 

$sdata=$_POST['searchdata'];
  ?>
             <h4 align="center">Result against "<?php echo $sdata;?>" keyword </h4> 
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">S.NO</th>
                    <th scope="col"> Company</th>
                    <th scope="col"> Name</th>
                     <th scope="col"> Batch Number</th>
                     <th scope="col"> Qty</th>
                     <th scope="col"> Remaining Qty</th>
                     <th scope="col"> Buying Qty</th>
                    <th scope="col">Action</th>
                    
                  </tr>
                </thead>
                <form name="cart" method="post">
                <tbody>
                  <?php
$query=mysqli_query($con,"Select sum(ProductQty) as selledqty from tblcart  join tblmedicine on tblmedicine.ID=tblcart.ProductId where tblmedicine.MedicineName like '%$sdata%'");
$result=mysqli_fetch_array($query);
$qty=$result['selledqty'];
$ret=mysqli_query($con,"select * from  tblmedicine where MedicineName like '%$sdata%'");
$num=mysqli_num_rows($ret);
if($num>0){
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>
              
                <tr>
                  <input type="hidden" name="mid" value="<?php echo $row['ID'];?>">
                  <td><?php echo $cnt;?></td>
            
                 
                  <td><?php  echo $row['MedicineCompany'];?></td>
                  <td><?php  echo $row['MedicineName'];?></td>
                  <td><?php  echo $row['MedicineBatchno'];?></td>
                  <td><?php  echo $row['Quantity'];?></td>
                  <td><?php  echo ($_SESSION['rqty']=$row['Quantity']-$qty);?></td>
                  <td><input type="number" name="pqty" value="1" required="true" style="width:40px;"></td>
                  
                  <td><button type="submit" name="cart" class="btn btn-primary my-4">Add to Cart</button></td>
                </tr>
                <?php 
$cnt=$cnt+1;
} } else { ?>
  <tr>
    <td colspan="8"> No record found against this search</td>

  </tr>
   
<?php } }?>
                </tbody>
                </form>
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