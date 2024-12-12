<?php
include '../config/config.php';
include '../models/KmRate.php'; 


$rateClass = new RateClass($pdo);
$kmdetails = $rateClass->getKmRate();


if (isset($_POST['submit'])) {
    $kmRate = $_POST['kmRate'];
    $response = $rateClass->updateKmRate($kmRate);
}
?>

<?php require 'header.php';?>
<main>
    <div class="container-fluid">ss
        <!---Area---->
                    <div class="row">
                    <div class="col">
                    <div class="card">
                        <div class="card-body">
                        <h5 class="card-title mb-5 d-inline">Update KM Rate</h5>
                        <form method="POST" action="kmrate.php" enctype="multipart/form-data">
                              <!-- Per Kilometer Charges input -->
                            <div class="col-md-6 form-outline mb-4 mt-4">
                                <label for="">Per Kilometer Charges</label>
                                <?php foreach($kmdetails as $kmdata):?>
                            <input type="number" name="kmRate" value="<?php echo $kmdetails['kmRate']; ?>" class="form-control" placeholder="" />
                           <?php endforeach;?>
                        </div>
                            <!-- Submit button -->
                            <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Update</button>
                        </form>
                        </div>
                         </div>
                       </div>
                     </div>
        <!---Area---->
    </div>
</main>
<?php require 'footer.php';?>