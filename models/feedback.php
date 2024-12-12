<?php
class feedback {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }


    public function AddFeedback($bookId, $overallRating, $performanceFeedback, $serviceFeedback, $qualityFeedback, $overallExperience) {
        try{
        $query = "INSERT INTO feedback (bookId, overallRating, performanceFeedback, serviceFeedback, qualityFeedback, overallExperience) 
                  VALUES (:bookId, :overallRating, :performanceFeedback, :serviceFeedback, :qualityFeedback, :overallExperience)";
        
        $statement = $this->pdo->prepare($query);
    
      
        $result = $statement->execute([
            "bookId" => $bookId,
            "overallRating" => $overallRating,
            "performanceFeedback" => $performanceFeedback,
            "serviceFeedback" => $serviceFeedback,
            "qualityFeedback" => $qualityFeedback,
            "overallExperience" => $overallExperience
        ]);
    
        return true;
    }
    catch (PDOException $e) {
        error_log("Error adding record: " . $e->getMessage());
        return false;
    }
    }
    

}
?>
