<?php require 'header.php';?>
<div class="container-fluid">
<main class="">
   <!-- Booking Form -->
   <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card p-4 shadow" style="width: 100%;">
            <h3 class=" text-center mb-1">Book Your Ride</h3>
            <form action="">
              <div class="row">
                   <div class="col-md-6 txt-br">
                        <label for="inputEmail4" class="form-label pt-4">FullName</label>
                        <input type="email" class="form-control" id="inputEmail4">
                    </div>
                    <div class="col-md-6 txt-br">
                        <label for="inputEmail4" class="form-label pt-4">Contact NO</label>
                        <input type="email" class="form-control" id="inputEmail4">
                    </div>

              </div>
                <div class="row">
                    <div class="col-md-6 txt-br">
                        <label for="inputEmail4" class="form-label pt-4">Pickup Location</label>
                        <input type="email" class="form-control" id="inputEmail4">
                    </div>
                    <div class="col-md-6 pt-2">
                        <div class="">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d18906.129712753736!2d6.722624160288201!3d60.12672284414915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x463e997b1b6fc09d%3A0x6ee05405ec78a692!2sJ%C4%99zyk%20trola!5e0!3m2!1spl!2spl!4v1672239918130!5m2!1spl!2spl" width="100%" height="150" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 txt-br">
                        <label for="inputEmail4" class="form-label pt-4">Drop-off Location</label>
                        <input type="email" class="form-control" id="inputEmail4">
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Total KM</h4>
                        <p>300km</p>
                        <h4>Total Ammount</h4>
                        <p>1500.00</p>
                    </div>
                    <div class="col-md-6 ">
                        <button type="submit" class="btn btn-secondary btn-block mt-2 p-3">Confirm Booking</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
</div>
<?php require 'footer.php';?>
