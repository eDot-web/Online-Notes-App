$(function(){
    // define variables
    var activeNote = 0;
    var editMode = false;

    // load notes    
    fetch('./loadnotes.php')
    .then(response => response.text())
    .then(data=>{
        $("#notes").html(data);
        clickonNote();
        clickonDelete();
    })

    .catch(()=>{
        $("#alertContent").text("Something's fishy! Please try again later.");
    })



    // add new note:ajax call to createnote.php
    $('#addNote').click(function(){
        fetch('createnote.php')
        .then(response => response.text())
        .then(data => {
            if(data == 'error'){
                $('#alertContent').text("There was an issue inserting the new note in the database :(");
                $('#alert').fadeIn();
            }else{
                activeNote = data;
                $("textarea").val("");
                showHide(["#notepad", "#allNotes"],["#notes","#addNote","#edit","#done"]);
                $('textarea').focus();
            }
        })
        .catch(()=>{
            $("#alertContent").text("Something's fishy! Please try again later.");
            $('#alert').fadeIn();
        })
    });

    $('#allNotes').click(function(){
        fetch('./loadnotes.php')
        .then(response => response.text())
        .then(data=>{
            $("#notes").html(data);
            showHide(['#addNote','#edit','#notes'],['#allNotes','#notepad']);
            clickonNote();
            clickonDelete();
        })

        .catch(()=>{
            $("#alertContent").text("Something's fishy! Please try again later.");
        })
    });


    $("textarea").keyup(function(){
        let datatopost = {note: $(this).val(), id:activeNote};
        var json = JSON.stringify(datatopost);
        // console.log(json);

        const url = './updatenote.php';
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
            if(data == 'error'){
                $("#alertContent").text("There was an issue updating note! Please try again later.");
                $('#alert').fadeIn();
            }
        })
        .catch(()=>{
            $("#alertContent").text("There was an issue updating note! Please try again later.");
            $('#alert').fadeIn();
        })
    });


    $('#edit').click(function(){
        editMode = true;
        $('.noteheader').addClass('col-xs-7 col-sm-9');
        showHide(['#done', '.delete'],[this]);
    });

    $('#done').click(function(){
        editMode = false;
        $('.noteheader').removeClass("col-xs-7 col-sm-9");

        showHide(['#edit'],['#done','.delete']);
    });


    function clickonDelete(){
        $('.delete').click(function(){
            var deleteButton = $(this);
            var notetodelete = deleteButton.next().attr('id');

            let datatopost = {id:notetodelete};
            var json = JSON.stringify(datatopost);
            // console.log(json);

            const url = './deletenote.php';
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
                if(data == 'error'){
                    $("#alertContent").text("There was an issue deleting note! Please try again later.");
                    $('#alert').fadeIn();
                }else{
                    deleteButton.parent().remove();
                }
            })
            .catch(()=>{
                $("#alertContent").text("There was an issue deleting note! Please try again later.");
                $('#alert').fadeIn();
            })

        });
    }


    function clickonNote(){
        $('.noteheader').click(function(){
            if(!editMode){
                activeNote = $(this).attr('id');
                $('textarea').val($(this).find('.text').text());
                showHide(["#notepad", "#allNotes"],["#notes","#addNote","#edit","#done"]);
                $('textarea').focus();
            }
        });
    }


    function showHide(array1, array2){
        for(let i=0; i<array1.length; i++){
            $(array1[i]).show();
        }
        for(let i=0; i<array2.length; i++){
            $(array2[i]).hide();
        }
    }



    // var datafromform = $(this).serializeArray();
    // // const datatopost = new FormData(document.querySelector('#signupform'));
    
    // const datatopost = {};
    // datafromform.forEach(element => {
    //     datatopost[element['name']] = element['value']
    //     // console.log(element['name'],element['value']);
    // });
    // var json = JSON.stringify(datatopost);
    // // console.log(json);

    // // console.log(datatopost);

    // 
    

    // click on all notes button

    // click on done after editing

    // edit mode: (show delete buttons, ...)


    // functions:
        // click on a note
        // click on delete
        // show hide fn


});