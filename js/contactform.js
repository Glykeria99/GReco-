
function Submit(buttonid){

  var el = document.getElementById('Submitbutton');
  var gettext = document.getElementsByClassName("textarea");
  var text= gettext[0].value;
  if (el.firstChild.data == "Υποβολή" && text!= ''){  
    el.firstChild.data = "Υποβλήθηκε!";
    el.style.backgroundColor ="#6a77dd";
  }
}

function validateForm() {
  
  var name = document.forms["contactform"]["Ονοματεπώνυμο"].value;
  var email = document.forms["contactform"]["E-mail"].value;
  var sub= document.forms["contactform"]["textarea"].value;
  if ((name == "") || (email == "") || (sub=="" )) {
    alert("Name must be filled out");
    return false;
  }
  else 
    return true;
}