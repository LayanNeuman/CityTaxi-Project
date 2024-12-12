<?php
require_once './include/header.php';
require_once './config/config.php';
require_once './models/feedback.php';

$fdback = new feedback($pdo);
if (isset($_GET['bookid'])) {
    $bookid = $_GET['bookid'];

}

if (isset($_POST['submit-form'])) {
    // Capture the form data
    $overallRating = $_POST['overall']; 
    $performanceFeedback = $_POST['performance'];
    $serviceFeedback = $_POST['service'];
    $qualityFeedback = $_POST['quality'];
    $overallExperience = $_POST['overall_exp'];
    $bookId = $_POST['bookId'];

    if($fdback->AddFeedback($bookId, $overallRating, $performanceFeedback, $serviceFeedback, $qualityFeedback, $overallExperience)){
        header("Location: p_bookingHistory.php");
        exit();
    }else{
        header("Location: p_bookingHistory.php");
        exit();
    }

}


?>

<style>
    /* Global Styles */


.feedback-container {
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 600px;
}

h1 {
  text-align: center;
  color: #ff9c33;
}

p {
  font-size: 1rem;
  text-align: center;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 15px;
}

label {
  font-weight: bold;
  display: block;
  margin-bottom: 5px;
}

textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 1rem;
  resize: vertical;
}

textarea:focus {
  border-color: #007BFF;
  outline: none;
}

.submit-btn {
  background-color: #FFC300;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1rem;
  width: 100%;
  margin-top: 20px;
}

.submit-btn:hover {
  background-color: #ff9c33;
}

.submit-btn:focus {
  outline: none;
}

input[type="number"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 1rem;
}

input[type="number"]:focus {
  border-color: #007BFF;
  outline: none;
}
</style>
<main class="">
     <!-- Cancel Booking Section -->
     <div class="container py-5">
            <div class="row justify-content-center">

                <!---->
                    <div class="col-md-12 mb-4">
                    <div class="feedback-container">
                            <h1>We Value Your Feedback</h1>
                            <p>Please share your experience with us based on the following categories:</p>

                            <form action="p_feedback.php" method="POST">
                            <!-- Performance Rating -->
                            <div class="form-group">
                                <label for="overall">Overall Rating (1 to 5):</label>
                                <input type="number" id="overall" class="form-control" name="overall" min="1" max="5" required>
                            </div>

                            <div class="form-group">
                                <label for="performance">Performance:</label>
                                <textarea id="performance" name="performance" rows="4" placeholder="How was your experience in terms of punctuality, efficiency, comfort, and safety?"></textarea>
                            </div>

                            <!-- Superior Service Rating -->
                            <div class="form-group">
                                <label for="service">Superior Service:</label>
                                <textarea id="service" name="service" rows="4" placeholder="How did you find the timeliness of pickup, private usage, and customer care?"></textarea>
                            </div>

                            <!-- Quality Rating -->
                            <div class="form-group">
                                <label for="quality">Quality:</label>
                                <textarea id="quality" name="quality" rows="4" placeholder="How was the service quality, including the condition of the vehicle and courtesy of staff?"></textarea>
                            </div>

                            <!-- Overall Experience Rating -->
                            <div class="form-group">
                                <label for="overall_exp">Overall Experience:</label>
                                <textarea id="overall_exp" name="overall_exp" rows="4" placeholder="How was your overall experience?"></textarea>
                            </div>
                            <input type="hidden" name="bookId" value="<?php echo $bookid; ?>">
                            
                            <button type="submit" name="submit-form" class="submit-btn">Submit Feedback</button> 
                        </form>

                        </div>
                            
                    </div>
        </div>
    </div>
</main>
<?php include './include/footer.php'?>