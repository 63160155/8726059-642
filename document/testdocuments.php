<form action="#" method="post">
    <input type="text" name = "docnum" id="docnumber" onkeyup="checkdocnum()"/>
    <div id = "disp">???</div>
    <button type="submit" class="btn btn-success" id="submit" >Save</button>
</form>

<script>
function checkdocnum() {
    var doc_num = document.getElementById("docnumber").value;
    document.getElementById("disp").innerHTML = doc_num;
    var xhttp = new XMLHttpRequest();
    //console.log(this.readyState);
    //console.log("hello");
    xhttp.onreadystatechange = function(){
        //console.log(this.readyState);
        // if(this.readyState == 2){
        // console.log("555");
        // }
        // if(this.readyState == 3){
        // console.log("666");
        //}
        //console.log(this.readyState);
        if (this.readyState == 4 && this.status ==200 ) {
            document.getElementById("disp").innerHTML = this.responseText;
            console.log(this.responseText);
            if (this.responseText != ""){
                document.getElementById("submit").disabled = true;
                document.getElementById("disp").innerHTML = "<a href='addstafftodocument.php?id=" + 
                this.responseText + "'>จัดการกรรมการ</a>";
            }else{
                document.getElementById("submit").disabled = false;
                document.getElementById("disp").innerHTML = "???";
            }
        }
    };
    //console.log("hello1");
    xhttp.open("GET", "check_docnum.php?doc_num=" + doc_num, true);
    //console.log("hello2");
    xhttp.send();
}
</script>