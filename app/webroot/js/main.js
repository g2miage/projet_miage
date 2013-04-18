function WhenChecked()
{
    if(document.getElementById('UserRoleId').checked == 1) 
        { 
          
       document.getElementById('prestat').style.visibility='visible';
       
    }else{
        document.getElementById('prestat').style.visibility='hidden';
    }
}
    