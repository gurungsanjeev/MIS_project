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
                   <div > Delivery Fee : Rs <span id="fee">0.00</span></div>
                   <div> Overall Price : Rs <span id="overall"><?php echo $tot ;?></span></div>
                   <input type="hidden" name="alltot" id="alltot" value="<?php echo $tot ;?>"/>
                  </p>  
                </div>
 
      </div>
    </div>
  </section>
 
 <section id="do_action">
    <div class="container">
      <div class="heading">
       
       
      <div class="row">
         <div class="row">
                   <div class="col-md-7">
              <div class="form-group">
                  <label> Payment Method : </label> 
                  <div class="radio" >
                      
                          <input type="radio"   class="paymethod" name="paymethod" id="deliveryfee" value="Cash on delivery" checked="true" data-toggle="collapse"  data-parent="#accordion" data-target="#collapseOne" unchecked> cash on delivery
                          
                          
                        
                      

                  </div> 
                  <label for="">or</label>


<!-- this is the epayment integration method -->

</form>
				   	<div>
                  <?php
                  $transaction_id = substr(bin2hex(random_bytes(4)), 0, 8);
                  $message ="total_amount=$tot,transaction_uuid=$transaction_id,product_code=EPAYTEST";
                $s = hash_hmac('sha256', $message, '8gBm/:&EnhH.1/q', true);
                $signature =  base64_encode($s); ?>
                
                
                <body style="font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4;">
  <!-- Wrapper -->
  <div style="max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <!-- Header -->
    <h2 style="text-align: center; color: #333;">eSewa Payment Information</h2>
    <p style="text-align: center; color: #666; margin-bottom: 20px; font-size: 14px;">Please verify your payment details before submission.</p>

    <!-- Payment Details -->
    <div style="margin-bottom: 15px;">
      <span style="font-weight: bold; color: #555;">Amount:</span>
      <span style="color: #333;"><?php echo $tot;?></span>
    </div>
    <div style="margin-bottom: 15px;">
      <span style="font-weight: bold; color: #555;">Tax Amount:</span>
      <span style="color: #333;">0</span>
    </div>
    <div style="margin-bottom: 15px;">
      <span style="font-weight: bold; color: #555;">Total Amount:</span>
      <span style="color: #333;"><?php echo $tot;?></span>
    </div>
    <div style="margin-bottom: 15px;">
      <span style="font-weight: bold; color: #555;">Transaction UUID:</span>
      <span style="color: #333;">241028</span>
    </div>
    <!-- <div style="margin-bottom: 15px;">
      <span style="font-weight: bold; color: #555;">Product Code:</span>
      <span style="color: #333;">EPAYTEST</span>
    </div> -->
    <div style="margin-bottom: 15px;">
      <span style="font-weight: bold; color: #555;">Product Service Charge:</span>
      <span style="color: #333;">0</span>
    </div>
    <div style="margin-bottom: 15px;">
      <span style="font-weight: bold; color: #555;">Product Delivery Charge:</span>
      <span style="color: #333;">0</span>
    </div>
    
    

    <!-- eSewa Submit Form -->
    <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
      <input type="text" id="amount" name="amount" value="<?php echo $tot ?>" required>
                    <input type="hidden" id="tax_amount" name="tax_amount" value ="0" required>
                    <input type="none" id="total_amount" name="total_amount" value="<?php echo $tot; ?>" style="display: none;" readonly required>
                    <input type="hidden" id="transaction_uuid" name="transaction_uuid" value="<?php echo $transaction_id ?>" required>
                    <input type="hidden" id="product_code" name="product_code" value ="EPAYTEST" required>
                    <input type="hidden" id="product_service_charge" name="product_service_charge" value="0" required>
                    <input type="hidden" id="product_delivery_charge" name="product_delivery_charge" value="0" required>
                    <input type="hidden" id="success_url" name="success_url" value="http://localhost/ecommerce/index.php?q=paymentReturn" required>
                    <input type="hidden" id="failure_url" name="failure_url" value="https://google.com" required>
                    <input type="hidden" id="signed_field_names" name="signed_field_names" value="total_amount,transaction_uuid,product_code" required>
                    <input type="hidden" id="signature" name="signature" value="<?php echo $signature ?>" required>

      <!-- Submit Button -->
      <button type="submit" onclick="return validatedate();" style="display: block; width: 100%; padding: 12px; border: none; background-color: #28a745; color: white; font-size: 16px; font-weight: bold; border-radius: 4px; cursor: pointer; text-align: center;">
        Process Payment
      </button>
    </form>
  </div>
</body>
 
              </div>
								





              </div> 
                        <div class="panel"> 
                                <div class="panel-body">
                                    <div class="form-group ">
                                     

                                    
                                        <div class="col-md-12">
                                          <!-- <label class="col-md-4 control-label" for=
                                          "PLACE">Place(City):</label> -->

                                          <!-- <div class="col-md-8"> -->
                                           <!-- <select class="form-control paymethod" name="PLACE" id="PLACE" onchange="validatedate()">  -->
                                           <!-- <option value="0" >Select</option> -->
                                              <?php 
                                            // $query = "SELECT * FROM `tblsetting` ";
                                            // $mydb->setQuery($query);
                                            // $cur = $mydb->loadResultList();

                                            // foreach ($cur as $result) {  
                                            //   echo '<option value='.$result->DELPRICE.'>'.$result->BRGY.' '.$result->PLACE.' </option>';
                                            // }
                                            // ?>
                                          <!-- </select> -->
                                          </div>
                                        </div>  
                                      
                                    </div>
    
                                </div>
                            </div> 
      
                        <input type="hidden"  placeholder="HH-MM-AM/PM"  id="CLAIMEDDATE" name="CLAIMEDDATE" value="<?php echo date('y-m-d h:i:s') ?>"  class="form-control"/>

                   </div>  
    
             
         
              </div>
<br/>
              <div class="row">
                <div class="col-md-6">
                    <a href="index.php?q=cart" class="btn btn-default pull-left"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;<strong>View Cart</strong></a>
                   </div>
                  <div class="col-md-6">
                      <button type="submit" class="btn btn-pup  pull-right " name="btn" id="btn" onclick="return validatedate();"   /> Submit Order <span class="glyphicon glyphicon-chevron-right"></span></button> 
                </div>  
              </div>
             
      </div>
    </div>
  </section><!--/#do_action-->
