<?php
require_once './include/header.php';
require_once './config/config.php';
require_once './models/Booking.php';

$booking = new Booking($pdo);

if(isset($_POST['booking-submit'])){
    $bid=$_POST['bid'];
    $cost=$_POST['cost'];
    
}


if (isset($_POST['submit-pay'])) {
    $ammount = $_POST['ammount']; 
    $bid = $_POST['bookid']; 
    $cost=$_POST['cost'];
    if($cost==$ammount){
        if($booking->BookingPayment($bid,$ammount)){
            $_SESSION['message'] = 'Booking Canceled Successfully';
            header("Location: p_feedback.php?bookid=$bid");
            exit();
        }else{
            $_SESSION['message'] = 'Booking Cancellation Failed';
            header("Location: p_bookingHistory.php");
            exit();
        }
    }
    else{
        $_SESSION['message'] = 'Booking Cancellation Failed';
        header("Location: p_bookingHistory.php");
        exit();
    }
} 


?>

<main class="">
     <!-- Cancel Booking Section -->
     <div class="container py-5">
        <h3 class="text-center mb-4">Payment</h3>
            <div class="row justify-content-center">

                <!---->
                    <div class="col-md-8 mb-4">
                        <div class="card">
                            <div class="card-body ">
                                 <form action="p_payment.php" method="POST">
                                    <h5 class="card-title">Booking #<?php echo $bid; ?></h5>
                                    <h5 class="card-title">Ammount #:Rs<?php echo $cost; ?></h5>
                                    <div class="form-group txt-br">
                                        <input type="hidden" class="form-control" value="<?php echo $bid; ?>" name="bookid">
                                        <input type="hidden" class="form-control" value="<?php echo $cost; ?>" name="cost">
                                        <input type="text" class="form-control" id="email" name="ammount" placeholder="Ammount" required>
                                    </div>
                                    <!-- Form to Cancel Booking -->
                                
                                        <input type="hidden" name="bid" value="<?php ?>">
                                        <button type="submit" name="submit-pay" class="btn btn-primary btn-block">Pay</button>
                                    </form>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
</main>
<div class="row mt-5">
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

</div>
<?php include './include/footer.php'?>