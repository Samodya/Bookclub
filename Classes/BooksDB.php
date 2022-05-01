<?php
    require("Connection.php");
    class Book{
        private $BID;
        private $ISBN;
        private $title;
        private $authors=array();
        private $year;
        private $price;
        private $publisher;
        private $cover;
        private $descrip;

        public function __construct($_ISBN,$_title,$_authors,$_year,
                                    $_price,$_publisher,$_cover,$_descrip){
            $this->ISBN=$_ISBN;
            $this->title=$_title;
            $this->authors=$_authors;
            $this->year=$_year;
            $this->price=$_price;
            $this->publisher=$_publisher;
            $this->cover=$_cover;
            $this->descrip=$_descrip;
        }

        public function SetBID($_BID){
            $this->BID=$_BID;
        }

        public function GetBID(){
            return $this->BID;
        }

        public function SetISBN($_ISBN){
            $this->ISBN=$_ISBN;
        }

        public function GetISBN(){
            return $this->ISBN;
        }
    
        public function SetTitle($_title){
            $this->title=$_title;
        }
    
        public function GetTitle(){
            return $this->title;
        }
    
        public function SetAuthor($_authors){
            $this->authors = $_authors;
        }

        public function GetAuthor($_index){
            return $this->authors[$_index] ;
        }

        public function GetAuthorCount(){
            return sizeof($this->authors);
        }

    
        public function SetYear($_year){
            $this->year=$_year;
        }
    
        public function GetYear(){
            return $this->year;
        }
    
        public function SetPrice($_price){
            $this->price=$_price;
        }
    
        public function GetPrice(){
            return $this->price;
        }
    
        public function SetPublisher($_publisher){
            $this->publisher=$_publisher;
        }
    
        public function GetPublisher(){
            return $this->publisher;
        }
    
        public function SetCover($_cover){
            $this->cover=$_cover;
        }
    
        public function GetCover(){
            return $this->cover;
        }
    
        public function SetDescrip($_descrip){
            if($_descrip!=null || $_descrip!="")
                $this->descrip=$_descrip;
            else
                $this->descrip="No Description has been provided for this Book";
        }
    
        public function GetDescrip(){
            return $this->descrip;
        }

        ///DB Methods
        public function AddBooks(){
            try {
                $conn=Connection::GetConnection();
                $query="INSERT INTO `book`(`ISBN`, `Title`, `Year`, 
                `Price`, `Publisher`, `Cover`, `Description`)
                 VALUES (:ISBN,:Title,:Byear,:price,:publisher,:cover,:descrip)";
                $stmt=$conn->prepare($query);
                $stmt->bindParam(":ISBN",$this->ISBN,PDO::PARAM_STR);
                $stmt->bindParam(":Title",$this->title,PDO::PARAM_STR);
                $stmt->bindParam(":Byear",$this->year,PDO::PARAM_INT);
                $stmt->bindParam(":price",$this->price,PDO::PARAM_INT);
                $stmt->bindParam(":publisher",$this->publisher,PDO::PARAM_STR);
                $stmt->bindParam(":cover",$this->cover,PDO::PARAM_STR);
                $stmt->bindParam(":descrip",$this->descrip,PDO::PARAM_STR);
                $stmt->execute();
                return $conn->lastInsertId();
             } catch (PDOException $e) {
                throw $e;
             }
        } 

        public function AddAuthor($BID,$AName){
            try {
                $conn = Connection::GetConnection();
                $query="INSERT INTO `authors`(`BID`, `Author`)
                  VALUES (:BID,:aname)";
                $stmt =$conn->prepare($query);
                $stmt->bindParam(":BID",$BID,PDO::PARAM_INT);
                $stmt->bindParam(":aname",$AName,PDO::PARAM_STR);         
                $stmt->execute();
         
            } catch (PDOException $th) {
                throw $th;
            }
         }

       public static function GetBooks(){
        try {
            $conn = Connection::GetConnection();
            $query="SELECT `ID`, `ISBN`, `Title`, `Year`, `Price`, `Publisher`, `Cover`,
                    `Description` FROM `book`";
            $stmt=$conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $books=array();
            foreach($result as $value){
                $authors=array();
                $book=new Book($value['ISBN'],$value['Title'],$authors,$value['Year'],
                    $value['Price'],$value['Publisher'],$value['Cover'],$value['Description']);
                 $book->SetBID($value['ID']);
                 $book->SetAuthor($book->GetAuthors());
                 array_push($books,$book);
            }
            return $books;
        } catch (PDOException $th) {
            throw $th;
        }
       }

       public function GetAuthors(){
        try {
            $conn = Connection::GetConnection();
            $query = "SELECT `Author` FROM `authors` WHERE `BID`=:BID";
            $stmt=$conn->prepare($query);
            $stmt->bindParam(":BID",$this->BID,PDO::PARAM_STR);
            $stmt->execute();
            $authors=array();
            $result=$stmt->fetchAll();

            foreach ($result as $value) {
               array_push($authors,$value[0]);
            }
            return $authors;
        } catch (PDOException $th) {
            throw $th;
        }
       }

       public function updateBooks(){
           try {
            $conn = Connection::GetConnection();
            $query="UPDATE `book` SET `ISBN`=:ISBN,`Title`=:Title,
                                       `Year`=:Byear,`Price`=:price,
                                       `Cover`=:cover,`Publisher`=:publisher,
                                       `Description`=:descrip 
                                       WHERE `ID`=:ID";
            $stmt =$conn->prepare($query);
            $stmt->bindParam(":ID",$this->BID,PDO::PARAM_INT);
            $stmt->bindParam(":ISBN",$this->ISBN,PDO::PARAM_STR);
            $stmt->bindParam(":Title",$this->title,PDO::PARAM_STR);
            $stmt->bindParam(":Byear",$this->year,PDO::PARAM_INT);
            $stmt->bindParam(":price",$this->price,PDO::PARAM_INT);
            $stmt->bindParam(":cover",$this->cover,PDO::PARAM_STR);
            $stmt->bindParam(":publisher",$this->publisher,PDO::PARAM_STR);
            $stmt->bindParam(":descrip",$this->description,PDO::PARAM_STR);
            $stmt->execute(); 
           } catch (PDOException $th) {
               throw $th;
           }
       }

       public static function DeleteBooks($bid){
        try {
            $conn=Connection::GetConnection();
            $query="DELETE FROM `book` WHERE `ID`=:ID";
             $stmt=$conn->prepare($query);
             $stmt->bindParam(":ID",$bid,PDO::PARAM_INT);
             $stmt->execute();
        } catch (PDOException $th) {
            throw $th;
        }
    }

    public  function DeleteAuthor()
   {
      try {
         $conn = Connection::GetConnection();
         $query="Delete From `authors` WHERE `BID`=:ID";
         $stmt =$conn->prepare($query);
         $stmt->bindParam(":ID",$this->BID,PDO::PARAM_INT);
         $stmt->execute();         
         
      } catch (PDOException $th) {
         throw $th;
      }
   }
}

    
?>