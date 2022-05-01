<?php
   require("Classes/BooksDB.php");
    session_start();
    $books=Book::GetBooks();

    if (isset($_POST["btnEdit"])) {
        echo $_POST["btnEdit"];
    }

    if (isset($_POST["btnDelete"])) {
        Book::DeleteBooks($_POST["btnDelete"]);
    }
    
    if(isset($_POST["btnSave"])){

        $books=array();
        if(isset($_SESSION["book"])){
            $books=$_SESSION["book"];
        }

        $authors=array();

        foreach($_POST["txtAuthor"] as $a){
            array_push($authors,$a);
        }

        
        if(isset($_FILES["txtCover"])){
            $name=$_FILES["txtCover"]['name'];
            $info= new SplFileInfo($name);
            $newName="Images/Cover_Images/".$_POST["txtISBN"].'.'.$info->getExtension();
            move_uploaded_file($_FILES["txtCover"]['tmp_name'],$newName);
            
        }else{
            $newName="Images/Cover_Images/Default.jpg";
        }
        $book= new Book(
            $_POST["txtISBN"],
            $_POST["txtTitle"],
            $authors,
            $_POST["txtYear"],
            $_POST["txtPrice"],
            $_POST["txtPublish"],
            $newName,
            $_POST["txtDescrip"]
        );

        try {
            $BID=$book->AddBooks();
            for ($i=0; $i <$book->GetAuthorCount() ; $i++) { 
              $book->AddAuthor($BID,$book->GetAuthor($i));
            }
            echo "Book Added";
        } catch (Exeption $th) {
            echo $th;
        }
    }
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
    <script src="js/addauth.js"></script>
    
</head>
<body>
    <h1>Manage Books</h1>

    <form action="" method="post"  enctype="multipart/form-data" >
       <aside>
       <ul style="list-style:none;" class="bg-secondary">
            <li>Enter ISBN:</li>
            <li> <input type="text" name="txtISBN"
                value=""> </li>
            <li>Enter Title:</li>
            <li> <input type="text" name="txtTitle" 
                value=""> </li>
            <li>Author:</li>
            <li id="author"><input type="text" name="txtAuthor[]"
                value=""> 
                <button class="btn btn-warning btnAddauth" 
                type="submit" name="btnAddAuth" 
                onclick="AddAuthor()"><i class="bi bi-person-plus-fill"></i></button>
            </li>
            <li>Year:</li>
            <li> <input type="year" name="txtYear" 
                value="" require> </li>
            <li>Price:</li>
            <li> <input type="number" name="txtPrice" 
                value="" require> </li>
            <li><i class="bi bi-pencil-fill"></i> Publisher:</li>
            <li> <input type="text" name="txtPublish" 
                value="" require> </li>
            <li>Cover:</li>
            <li>
            <label for="exampleFormControlFile1">Insert Picture form here!</label>
                 <input type="file" name="txtCover" class="form-control-file btn btn-danger" id="exampleFormControlFile1"><br>
                 </li>
            <li>Description:</li>
            <li><textarea name="txtDescrip" cols="40" rows="10" >
            </textarea></li>
            <li><input class="btn btn-primary" type="submit" value="Save" name="btnSave">
                <input class="btn btn-primary" type="submit" value="Update" name="btnPrint">
            </li>
        </ul>
        </form>
       </aside>
        <main>
            <?php
                    $books=Book::GetBooks();  
                    if(sizeof($books)>0){

                        echo '<form class="" method="post"> 
                                <table class="table-primary">';
                        echo '<tr class="bg-warning pt-5">
                            <th>ISBN</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Year</th>
                            <th>Price</th>
                            <th>Publisher</th>
                            <th>Cover</th>
                            <th>Description</th>
                            </tr>';
                           // var_dump($books);
                           $r=0;
                        foreach($books as $b){
                           $row='<tr ">
                                <td>'.$b->GetISBN().'</td>
                                <td>'.$b->GetTitle().'</td>
                                <td>';
                                for($i=0; $i < $b->GetAuthorCount(); $i++){
                                    $row =  $row. $b->GetAuthor($i).'<br>';
                                }
                                $row .= '</td>
                                <td>'.$b->GetYear().'</td>
                                <td>'.$b->GetPrice().'</td>
                                <td>'.$b->GetPublisher().'</td>
                                <td> <img src="'.$b->GetCover().'" style="width:100px; height:100px;"></td>
                                <td>'.$b->GetDescrip().'</td>
                                <td><button class="btn btn-success m-md-2" type="submit" name="btnEdit" value="'.$r.'"
                                    ><i class="bi bi-pencil-fill"></i></button> 
                                    <button class="btn btn-danger m-md-2" type="submit" name="btnDelete" 
                                    onClick="ConfirmDelete()" value="'.$b->GetBID().'">
                                    <i class="bi bi-trash-fill"></i></button> </td>
                                </tr>';
                                echo $row;
                                $r++;
                        }
                        echo "</table></ form>";

                    }else
                        echo "No data to display";
            
            ?>
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
                integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
                crossorigin="anonymous"></script>
</body>
</html>