// Add Sweetalert code for the delete button
$(function(){
    $(document).on('click', '#delete', function(e){
        e.preventDefault();
        var link = $(this).attr("href");
        
        Swal.fire({   
            title: "Do you want to delete?", 
            text: "Delete This Data?",  
            icon: 'warning', 
            showCancelButton: true,   
            confirmButtonColor: "#3085d6",   
            confirmButtonText: "Yes",  
            cancelButtonColor: '#d33', 
            closeOnConfirm: false 
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Are you sure you want to delete?",
                    text: "Are you sure?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel"
                }).then((innerResult) => {
                    if (innerResult.isConfirmed) {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted',
                            'success'
                        ).then(function() {
                            window.location.href = link;
                        });
                    }
                });
            }
        });
    });
});
