$('#signupform').submit(function(event){
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

    const url = './signup.php';
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
        $("#signupmessage").html(data);
    })

    .catch(()=>{
        $("#signupmessage").html("<div class='alert alert-danger'>Something's fishy! Please try again later.</div>");
    })
    

    // $.ajax({
    //     url:"signup.php",
    //     type:"POST",
    //     data: datatopost,
    //     success: function(data){
    //         if(data){
    //             $("#signupmessage").html(data);
    //         }
    //     },
    //     error: function(){
    //         $("#signupmessage").html("<div class='alert alert-danger'>Something's fishy! Please try again later.</div>");
    //     }
    // });
});



$('#loginform').submit(function(event){
    event.preventDefault();

    // will form an array with objects with name:htmlattrname and value:formvalue
    var datafromform = $(this).serializeArray();
    // const datatopost = new FormData(document.querySelector('#signupform'));
    
    const datatopost = {};
    datafromform.forEach(element => {
        datatopost[element['name']] = element['value']
        // console.log(element['name'],element['value']);
    });
    var json = JSON.stringify(datatopost);
    // console.log(json);

    // console.log(datatopost);

    const url = './login.php';
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
        if(data !== "success"){
            $("#loginmessage").html(data);
        }else{
            window.location = "mainpageloggedin.php";
        }
    })

    .catch(()=>{
        $("#loginmessage").html("<div class='alert alert-danger'>Something's fishy! Please try again later.</div>");
    })
    

    // $.ajax({
    //     url:"signup.php",
    //     type:"POST",
    //     data: datatopost,
    //     success: function(data){
    //         if(data){
    //             $("#signupmessage").html(data);
    //         }
    //     },
    //     error: function(){
    //         $("#signupmessage").html("<div class='alert alert-danger'>Something's fishy! Please try again later.</div>");
    //     }
    // });
});


$('#forgotpasswordform').submit(function(event){
    event.preventDefault();

    // will form an array with objects with name:htmlattrname and value:formvalue
    var datafromform = $(this).serializeArray();
    // const datatopost = new FormData(document.querySelector('#signupform'));
    
    const datatopost = {};
    datafromform.forEach(element => {
        datatopost[element['name']] = element['value']
        // console.log(element['name'],element['value']);
    });
    var json = JSON.stringify(datatopost);
    // console.log(json);

    // console.log(datatopost);

    const url = './forgotpassword.php';
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
        console.log(data);
        $("#forgotpasswordmessage").html(data);
    })

    .catch(()=>{
        $("#forgotpasswordmessage").html("<div class='alert alert-danger'>Something's fishy! Please try again later.</div>");
    })
    

    // $.ajax({
    //     url:"signup.php",
    //     type:"POST",
    //     data: datatopost,
    //     success: function(data){
    //         if(data){
    //             $("#signupmessage").html(data);
    //         }
    //     },
    //     error: function(){
    //         $("#signupmessage").html("<div class='alert alert-danger'>Something's fishy! Please try again later.</div>");
    //     }
    // });
});