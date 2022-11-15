var search = document.getElementById("lookup");
var result = document.getElementById("result");
const xhttp = new XMLHttpRequest();

search.addEventListener("click", function(e){
  e.preventDefault(); //stop reload
  var req = document.getElementById("country").value;

  var url = "world.php?country=" + req;

  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == XMLHttpRequest.DONE){
       if (xhttp.status == 200) {
         var res = xhttp.responseText;
         result.innerHTML = res;


       }else{
         alert("An error has occurred. Please try again.");
       }
    }
  }
  xhttp.open("GET" , url, true);
  xhttp.send();
});
