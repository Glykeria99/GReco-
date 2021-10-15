var sdg;

function stayActive(goalid) {


  var el = document.getElementById(goalid);
  var goal13 = document.getElementById("goal13");
  var goal14 = document.getElementById("goal14");
  var goal15 = document.getElementById("goal15")

  if (el.id=="goal13")
  { 
    goal13.style.filter = "grayscale(100%)";
    goal14.style.filter = "grayscale(0%)";
    goal15.style.filter = "grayscale(0%)";
    sdg = "climate action"
  }
    else if (el.id=="goal14")
  {
    goal13.style.filter = "grayscale(0%)";
    goal15.style.filter = "grayscale(0%)";
    goal14.style.filter = "grayscale(100%)";
    sdg = "life below water"
  }
  else if (el.id=="goal15")
  {
    goal13.style.filter = "grayscale(0%)";
    goal15.style.filter = "grayscale(100%)";
    goal14.style.filter = "grayscale(0%)";
    sdg = "life on land"
  }
}

function setSDG() {
      var elem = document.getElementById("sdg");
      elem.value = sdg;
 }