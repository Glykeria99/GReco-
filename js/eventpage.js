

function DeleteEvent() {
    var txt;

  var r = confirm("Διαγραφή αυτού του event;");
  if (r == true) {
    txt = "You pressed OK!";
    return true;
  } else {
    txt = "You pressed Cancel!";
    return false;
  }

  document.getElementById("demo").innerHTML = txt;

}
function Delete() {
  var txt;
  var r = confirm("Διαγραφή αυτού του σχολίου;");
  if (r == true) {
    txt = "You pressed OK!";
    return true;
  } else {
    txt = "You pressed Cancel!";
    return false;
  }
  document.getElementById("demo").innerHTML = txt;
}