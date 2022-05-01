function AddAuthor(){
    var li=document.getElementById("author");
    li.innerHTML+='<input type="text" name="txtAuthor[]">';
}

function ConfirmDelete(){
    var conf= confirm("Are you sure, you want to delete?");
    if(conf)
                return true;
            else
            return false;
}