function checkForm(frm){ 

var msg = ""; 
    if(!document.getElementById('first_name').value){ 
      msg += " First Name is required\n"; 
   }
  if(!document.getElementById('last_name').value){ 
      msg += "Surname is required\n"; 
   } 
     if(!document.getElementById('email').value){ 
      msg += "Email is required\n"; 
   } 
     if(!document.getElementById('lead_source').value){ 
      msg += "How did you hear about EBS? is required\n"; 
   }  
     if(!document.getElementById('00N20000001Hp9Q').value){ 
      msg += "Which courses ... more information on? is required\n"; 
   } 

   else
   {
	   if(!isvalidemail(document.getElementById('email').value)){ 
		      msg += "Email address is invalid\n"; 
	   } 

    }
   if(msg != ""){ 
      alert(msg); 	  
      return false; 
   } 
   else
   {   
	document.forms[0].submit();
	document.getElementById("00N20000001ItzG").value = location.href;
	return true;
   }
} 


function isvalidemail(s) {

		if (s.length > 0) {
			if (s.indexOf("@")!=-1 && s.indexOf(".")!=-1)  {
				//email is valid
				return true;	
			}
			else {
				//email is not valid
				return false;
			}			
		}
		else {
			//if string is empty just return true as we assume 
			//the field is not mandatory.
			return true;
		}
		
}




