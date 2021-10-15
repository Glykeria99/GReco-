function checkPassword(form) { 
                password1 = form.psw.value; 
                password2 = form.pswrepeat.value;
                      
                // If Not same return False.     
                if (password1 != password2) { 
                    alert ("\nPassword did not match: Please try again...") 
                    return false; 
                } 
  
                // If same return True. 
                else{ 
                    alert("Password Match: Welcome to GReco!") 
                    return true; 
                } 
            } 
