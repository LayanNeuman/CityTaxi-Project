<?php include './include/header.php'?>
<main class="bg-main">
    <!-- Login Form -->
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
             <h3 class="text-center mb-4">Who are you</h3>
            <div class="row">
                <div class="col-md-6">
                <p class="text-center mt-3">
                <a href="Passregister.php" ><button type="" class="btn btn-clrout btn-block p-5"><i class="fas fa-user icon"></i>Guest</button></a>
            </p>
                </div>
                <div class="col-md-6 " >
                <p class="text-center mt-3">
                <a href="Driverregister.php" ><button type="" class="btn btn-clrout btn-block p-5" > <i class="fas fa-car icon"></i> Driver</button></a>
            </p>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include './include/footer.php'?>