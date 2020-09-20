$('#updateusernameform').submit(function(event){
    event.preventDefault();

    // will form an array with objects with name:htmlattrname and value:formvalue
    var datafromform = $(this).serializeArray();
    // const datatopost = new FormData(document.querySelector('#signupform'));
    
    const datatopost = {};
    datafromform.forEach(element => {
        datatopost[element['name']] = element['value'];
        // console.log(element['name'],element['value']);
    });
    var json = JSON.stringify(datatopost);
    // console.log(json);

    // console.log(datatopost);

    const url = './updateusername.php';
    const request = new Request(url,{
        method:'POST',
        // headers:{
        //     'Content-Type':'text/html'
        // },
        body:json
    });
    
    fetch(request)
    .then(response => response.text())
    .then(data=>{
        if(data){
            $("#updateusernamemessage").html(data);
        }else{
            location.reload();
        }
    })

    .catch(()=>{
        $("#updateusernamemessage").html("<div class='alert alert-danger'>Updating your username was not successful oh no :(</div>");
    })
});

$('#updateemailform').submit(function(event){
    event.preventDefault();

    // will form an array with objects with name:htmlattrname and value:formvalue
    var datafromform = $(this).serializeArray();
    // const datatopost = new FormData(document.querySelector('#signupform'));
    
    const datatopost = {};
    datafromform.forEach(element => {
        datatopost[element['name']] = element['value'];
        // console.log(element['name'],element['value']);
    });
    var json = JSON.stringify(datatopost);
    // console.log(json);

    // console.log(datatopost);

    const url = './updateemail.php';
    const request = new Request(url,{
        method:'POST',
        // headers:{
        //     'Content-Type':'text/html'
        // },
        body:json
    });
    
    fetch(request)
    .then(response => response.text())
    .then(data=>{
        $("#updateemailmessage").html(data);
    })
    .catch(()=>{
        $("#updateemailmessage").html("<div class='alert alert-danger'>Updating your username was not successful oh no :(</div>");
    })
});

$('#updatepasswordform').submit(function(event){
    event.preventDefault();

    // will form an array with objects with name:htmlattrname and value:formvalue
    var datafromform = $(this).serializeArray();
    // const datatopost = new FormData(document.querySelector('#signupform'));
    
    const datatopost = {};
    datafromform.forEach(element => {
        datatopost[element['name']] = element['value'];
        // console.log(element['name'],element['value']);
    });
    var json = JSON.stringify(datatopost);
    // console.log(json);

    // console.log(datatopost);

    const url = './updatepassword.php';
    const request = new Request(url,{
        method:'POST',
        // headers:{
        //     'Content-Type':'text/html'
        // },
        body:json
    });
    
    fetch(request)
    .then(response => response.text())
    .then(data=>{
        if(data){
            $("#updatepasswordmessage").html(data);
        }
    })

    .catch(()=>{
        $("#updatepasswordmessage").html("<div class='alert alert-danger'>Updating your username was not successful oh no :(</div>");
    })
});