
<?php 

if (!isset($_SESSION['CUSID'])){
redirect(web_root."index.php");
}
 

     

$customerid =$_SESSION['CUSID'];
$customer = New Customer();
$singlecustomer = $customer->single_customer($customerid);

  ?>
 
<?php 
  $autonumber = New Autonumber();
  $res = $autonumber->set_autonumber('ordernumber'); 
?>


<form onsubmit="return orderfilter()" action="customer/controller.php?action=processorder" method="post" >   
<section id="cart_items">
    <div class="container">
      <div class="breadcrumbs">
        <ol class="breadcrumb">
          <li><a href="#">Home</a></li>
          <li class="active">Order Details</li>
        </ol>
      </div>
      <div class="row">
    <div class="col-md-6 pull-left">
      <div class="col-md-2 col-lg-2 col-sm-2" style="float:left">
        Name:
      </div>
      <div class="col-md-8 col-lg-10 col-sm-3" style="float:left">
        <?php echo $singlecustomer->FNAME .' '.$singlecustomer->LNAME; ?>
      </div>
       <div class="col-md-2 col-lg-2 col-sm-2" style="float:left">
        Address:
      </div>
      <div class="col-md-8 col-lg-10 col-sm-3" style="float:left">
        <?php echo $singlecustomer->CUSHOMENUM . ' ' . $singlecustomer->STREETADD . ' ' .$singlecustomer->BRGYADD . ' ' . $singlecustomer->CITYADD . ' ' .$singlecustomer->PROVINCE . ' ' .$singlecustomer->COUNTRY; ?>
      </div>
    </div>

    <div class="col-md-6 pull-right">
    <div class="col-md-10 col-lg-12 col-sm-8">
    <input type="hidden" value="<?php echo $res->AUTO; ?>" id="ORDEREDNUM" name="ORDEREDNUM">
      Order Number :<?php echo $res->AUTO; ?>
    </div>
    </div>
 </div>
      <div class="table-responsive cart_info"> 
 
              <table class="table table-condensed" id="table">
                <thead >
                <tr class="cart_menu"> 
                  <th style="width:12%; align:center; ">Product</th>
                  <th >Description</th>
                  <th style="width:15%; align:center; ">Quantity</th>
                  <th style="width:15%; align:center; ">Price</th>
                  <th style="width:15%; align:center; ">Total</th>
                  </tr>
                </thead>
                <tbody>    
                       
              <?php

              $tot = 0;
                if (!empty($_SESSION['gcCart'])){ 
                      $count_cart = @count($_SESSION['gcCart']);
                      for ($i=0; $i < $count_cart  ; $i++) { 

                      $query = "SELECT * FROM `tblpromopro` pr , `tblproduct` p , `tblcategory` c
                           WHERE pr.`PROID`=p.`PROID` AND  p.`CATEGID` = c.`CATEGID`  and p.PROID='".$_SESSION['gcCart'][$i]['productid']."'";
                        $mydb->setQuery($query);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result){ 
              ?>

                         <tr>
                         <!-- <td></td> -->
                          <td><img src="admin/products/<?php echo $result->IMAGES ?>"  width="50px" height="50px"></td>
                          <td><?php echo $result->PRODESC ; ?></td>
                          <td align="center"><?php echo $_SESSION['gcCart'][$i]['qty']; ?></td>
                          <td>Rs <?php echo  $result->PRODISPRICE ?></td>
                          <td>Rs <output><?php echo $_SESSION['gcCart'][$i]['price']?></output></td>
                        </tr>
              <?php
              $tot +=$_SESSION['gcCart'][$i]['price'];
                        }

                      }
                }
              ?>
            

                </tbody>
                
              </table>  
                <div class="  pull-right">
                  <p align="right">
                  <div > Total Price :   Rs <span id="sum">0.00</span></div>
                   <!-- <div > Delivery Fee : Rs <span id="fee">0.00</span></div> -->
                   <div> Overall Price : Rs <span id="overall"><?php echo $tot ;?></span></div>
                   <input type="hidden" name="alltot" id="alltot" value="<?php echo $tot ;?>"/>
                  </p>  
                </div>
 
      </div>
    </div>
  </section>

<!-- 
  <input type="hidden"  placeholder="HH-MM-AM/PM"  id="CLAIMEDDATE" name="CLAIMEDDATE" value="<?php echo date('y-m-d h:i:s') ?>"  class="form-control"/>

  <div class="row">
                <div class="col-md-6">
                    <a href="index.php?q=cart" class="btn btn-default pull-left"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;<strong>View Cart</strong></a>
                   </div>
                  <div class="col-md-6">
                      <button type="submit" class="btn btn-pup  pull-right " name="btn" id="btn" onclick="return validatedate();"   /> Submit Order <span class="glyphicon glyphicon-chevron-right"></span></button> 
                </div>  
              </div> -->




  

 
  <div>
  <div style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f9; text-align: center;">

<!-- Main Container -->
<div style="max-width: 600px; margin: 50px auto; background-color: #fff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); padding: 20px;">

    <!-- Success Icon -->
    <div style="margin-top: 20px;">
        <svg width="100" height="100" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="10" fill="#28a745"/>
            <path d="M8 12.5L11 15.5L16 9.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>

    <!-- Payment Success Message -->
    <h1 style="color: #28a745; font-size: 28px; margin-top: 10px;">Payment Successful!</h1>
    <p style="color: #555; font-size: 16px; line-height: 1.5;">
        Thank you for your payment. Your transaction has been successfully processed.
    </p>

    <!-- Order Information -->
    <div style="margin: 20px 0;">
        
        <p style="color: #333; font-size: 18px; margin: 5px;"><strong>Amount Paid:</strong> <?php echo $tot;?></p>
    </div>

    <!-- Back to Home Button -->
    <a href="http://localhost/ecommerce/" style="
        display: inline-block; 
        text-decoration: none; 
        color: #fff; 
        background-color: #28a745; 
        padding: 10px 20px; 
        border-radius: 5px; 
        font-size: 16px;
        margin-top: 20px;">
        Back to Home
    </a>
</div>


  

<!-- Footer -->

              </div>
      
      





				   	





              

  </form>

  <div class="table-responsive" style="margin-top:5%;">
    <h1 style="
    justify-content: center;
    display: flex; color:#560361;
">Order History</h1>
                            <form action=
                            "customer/controller.php?action=delete" method=
                            "post">
                                <table cellspacing="0" class=
                                "table table-striped table-bordered table-hover"
                                id="example" style="font-size:12px">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Order#</th>
                                            <th>Date Oredered</th>
                                            <th>TotalPrice</th>
                                            <th>PaymentMethod</th>
                                            <th>Status</th>
                                            <th width="150px">Remarks</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                                                    $query = "SELECT * FROM `tblsummary`  
                                                                  WHERE  `CUSTOMERID`=".$_SESSION['CUSID'] ." ORDER BY   `ORDEREDNUM` desc ";
                                                                  $mydb->setQuery($query);
                                                                  $cur = $mydb->loadResultList();

                                                                foreach ($cur as $result) {
                                                                  ?>
                                        <tr>
                                            <td width="5%"></td>
                                            <!--   <td width="10%"  class="orderid   "  data-target="#myOrdered" data-toggle="modal" data-id="<?php echo  $result->ORDEREDNUM; ?>">
                            <a href="#"  title="View list Of ordered products"  class="orderid   "  data-target="#myOrdered" data-toggle="modal" data-id="<?php echo  $result->ORDEREDNUM; ?>"><i class="fa fa-info-circle fa-fw"></i> view orders</a> 
                         </td> -->
                                            <!-- <td> <a href="#" class="get-id"  data-target="#myModal" data-toggle="modal" data-id="<?php echo  $result->ORDERNUMBER; ?>"><?php echo  $result->ORDERNUMBER; ?></a>
                               </td> -->
                                            <td>
                                            <?php echo  $result->ORDEREDNUM; ?>
                                            <!-- <a href="#"  title="View list Of ordered products"  class="orderid   "  data-target="#myOrdered" data-toggle="modal" data-id="<?php echo  $result->ORDEREDNUM; ?>"><i class="fa fa-info-circle fa-fw"></i><?php echo  $result->ORDEREDNUM; ?></a> --></td>
                                            <td>
                                            <?php echo date_format(date_create($result->ORDEREDDATE),"M/d/Y h:i:s") ; ?></td>
                                            <td>Rs
                                            <?php echo  $result->PAYMENT; ?></td>
                                            <td>
                                            <?php echo  $result->PAYMENTMETHOD; ?></td>
                                            <td>
                                            <?php echo  $result->ORDEREDSTATS; ?></td>
                                            <td>
                                            <?php echo  $result->ORDEREDREMARKS; ?></td>
                                            <!-- <td class="tooltip-demo">
                                                <a class=
                                                "orderid btn btn-pup btn-xs"
                                                data-id=
                                                "<?php echo $result->ORDEREDNUM; ?>"
                                                data-target="#myOrdered"
                                                data-toggle="modal" href="#"
                                                title=
                                                "View list Of ordered products">
                                                <i class=
                                                "fa fa-info-circle fa-fw"
                                                data-placement="left"
                                                data-toggle="tooltip" title=
                                                "View Order"></i> <span class=
                                                "tooltip tooltip.top">view</span></a>
                                            
                                            </td> -->
                                        </tr><?php
                                                                       
                                                                        } 
                                                                        ?>
                                    </tbody>
                                </table>
                            </form> 

  <script>
    // Trigger button click on page load
    (function() {
            document.getElementById('myButton').click();
        })();
  </script>