  
function openingDef() {
    var k = document.getElementById('account');
    k.style.display = "none";
}

            function openTab(tab) {
                if (tab == "overview") {
                    var y = document.getElementById('account');
                }
                else {
                    var y = document.getElementById('overview');
                }

                var x = document.getElementById(tab);
                if (x.style.display === "none") {
                    x.style.display = "grid";
                    y.style.display = "none";
                }
            } 
        

//Εάν το προφίλ δεν είναι του ίδιου του χρήστη, να μηνεμφανίζονται τα κουμπια επισκόπηση και λογαριασμός.
//Εάν το προφίλ είναι του χρήστη εμφανίζονται και τα 2 κουμπιά αλλα δεν εμφανίζεται το κουμπί follow.
function profile(){
    var profile ='userid';
    
    var x = document.getElementById("overview-menu");
    var y = document.getElementById("acc-menu");
    if (profile==='userid')
    {
        var k = document.getElementById('account');
        k.style.display = "none";
        var button = document.getElementById('follow-butt');
        button.style.display = "none";
    }
    else {(profile.value!='userid')
        x.style.display = "none";
        y.style.display = "none";
        var acc = document.getElementById('account');
        acc.style.display = "none";}
      
}


function Edit(buttonid,inputid,submitbutt){
    
    var button = document.getElementById(buttonid).style.display='none';
    var submit = document.getElementById(submitbutt).style.display='inline-block';
    var input = document.getElementById(inputid);
    if(inputid == "pw-field")
    {
        input.type = "text";
    }
    input.disabled = false;
    
    button.attributes["type"] = "submit";

}