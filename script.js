function doValidate() {
    console.log('Validating...');
    try {
        pw = document.getElementById('password').value;
        em = document.getElementById('email').value;
        console.log("Validating pw="+pw);
        if (pw == null || pw == "" || em == null || em == "") {
            alert("Both fields must be filled out");
            return false;
        }
        if (em.includes('@')){
            alert("Email address must contain @");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
}