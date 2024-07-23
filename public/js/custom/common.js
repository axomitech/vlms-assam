$(document).on('click','.save-btn',function(){
    var url = $(this).data('url');
    var message = $(this).data('message');
    var formData = new FormData($($(this).data('form'))[0]); 
    confirmSubmission(url,formData,message,1);
});

function confirmSubmission(url,formData,confirmMessage,refreshStatus){
    var successResponse = null;
    Swal.fire({
        title: 'Are you sure?',
        text: confirmMessage,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
        }).then((result) => {
        if (result.isConfirmed) {
            
            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
                data: formData,
                success: function (response) {
                    // handle success response
                    var candidateId = 0;
                    for(var i = 1; i < response.length; i++){
                        if(response[i].candidate){
                            candidateId = response[i].candidate
                        }
                    }
                    if(candidateId > 0){
                        $('.candidate').val(candidateId);
                    }
                    successConfirm(response[1].status,response[1].message,refreshStatus);
                },
                error: function (response) {
                    // handle error response
                    if(response.status == 422){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! Please check the form',
                          })
                        displayErrors(response);
                    }
                    console.log(response);
                },
                contentType: false,
                processData: false
            });
        }
    })

    return successResponse;
}

function displayErrors(response){
    var j = JSON.parse(response.responseText);
    Object.keys(j.errors).forEach(function(key) {
                $('.'+key.replace(/\./g,'')).text(j.errors[key]);
    });
}

$(document).on('focus','.form-control',function(){
    $('.'+$(this).attr('name')).text("");
})

function successConfirm(status,message,responseStatus){
    Swal.fire({
    title: status.substr(0,1).toUpperCase()+status.substr(1),
    text: message,
    icon: status,
    showCancelButton: false,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
        }).then((result) => {
        if (result.isConfirmed) {
            if(status != 'error'){
                if(responseStatus == 1){
                    var url = window.location.href;
                    var urlComponent = url.split('/');
                    if(urlComponent[urlComponent.length-1] == 'rcapacity'){
                        window.location.replace(window.location.origin+'/capacity');
                    }else{
                        location.reload();
                    }
                    
                }
            }
        }
    })
}