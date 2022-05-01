<?php
    class Book{
        private $ISBN;
        private $title;
        private $authors=array();
        private $year;
        private $price;
        private $publisher;
        private $cover;
        private $descrip;

        public function __construct($_ISBN,$_title,$_authors,$_year,$_price,$_publisher,$_cover,$_descrip){
            $this->ISBN=$_ISBN;
            $this->title=$_title;
            $this->authors=$_authors;
            $this->year=$_year;
            $this->price=$_price;
            $this->publisher=$_publisher;
            $this->cover=$_cover;
            $this->descrip=$_descrip;
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
        
    }

    
?>