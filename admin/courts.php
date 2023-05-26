<?php
require('db_config.php');
require('essential.php');
adminLogin();

if(isset($_GET['approve'])){

    $frm_data = filteration($_GET);

    $q = "UPDATE `courts` SET `status`= 2 WHERE `id`=?";
    $v = [$frm_data['approve']];

    if(update($q,$v,'i')){
        alert('success','Approved');
    }

}
if(isset($_GET['reject'])){

    $frm_data = filteration($_GET);

    $q = "UPDATE `courts` SET `status`= 0 WHERE `id`=?";
    $v = [$frm_data['reject']];

    if(update($q,$v,'i')){
        alert('success','Rejected');
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courts and Field</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Poppins:ital,wght@0,400;0,500;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        .h-front {
            font-family: 'Merienda', cursive;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            display: none;
        }

        .custom-bg {
            background-color: #2ec;
        }

        .custom-bg:hover {
            background-color: #279e8c;
        }

        .h-line {
            width: 150px;
            margin: 0 auto;
            height: 1.7px;
        }

        #dashboard-menu{
            position: fixed;
            height: 100%;
        }

        .custom-alert{
            position: fixed;
            top: 80px;
            right: 25px;
        }
    </style>

</head>
<body class="bg-light">
<?php require('inc/header.php') ;?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">Courts</h3>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="text-end mb-4">
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-courts">
                        <i class="bi bi-plus-square"></i>add
                        </button>
                    </div>
                    <div class="table-responsive-lg" style="height: 450px; overflow-y: scroll;">
                        <table class="table table-hover broder">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Book From</th>
                                    <th scope="col">Book To</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <?php
                                    $q = "SELECT * FROM `courts` ORDER BY `id` DESC";
                                    $data = mysqli_query($con,$q);
                                    $i=1;

                                    while($row = mysqli_fetch_assoc($data)){
                                        if($row['status']==0){
                                            $status = "<button  class='btn btn-dark btn-sm shadow-none'>Available</button>";
                                        }
                                        else if($row['status']==1){
                                            $status = "<a href='?approve=$row[id]' class ='btn btn-sm rounded-pill btn-primary'>Approve</a>"; 
                                            $status.= "<a href='?reject=$row[id]' class ='btn btn-sm rounded-pill btn-danger'>Reject</a";
                                        }
                                        else if($row['status']==2){
                                            $status = "<button  class='btn btn-custom-bg btn-sm shadow-none'>Booked</button>";
                                        }
                                        echo<<<query
                                            <tr>
                                                <td>$i</td>
                                                <td>$row[name]</td>
                                                <td>$row[book_from]</td>
                                                <td>$row[book_to]</td>
                                                <td>$status</td>


                                            </tr>
                                        query;
                                        $i++;
                                    }


                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    <!--Add_Model_Court-->
                <div class="modal fade" id="add-courts" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="add_court_form">   
                                <div class="modal-header">
                                    <h5 class="modal-title d-flex align-items-center">Add Court</h5>
                                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label  class="form-label">Name</label>
                                            <input type="text" class="form-control shadow-none" name="name" id="name_inp">


                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Book From</label>
                                            <input type="date" class="form-control shadow-none" name="Book_From" id="book_from_inp">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Book To</label>
                                            <input type="date" class="form-control shadow-none" name="Book_To" id="book_to_inp">
                                        </div>
                                    </div>   
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <button type="reset" class="btn btn-dark shadow-none">Close</button>
                                    <button type="submit"  class="btn btn-dark shadow-none">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
     let add_court_form = document.getElementById('add_court_form');
add_court_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_courts();
});

function add_courts() {
    let data = ['name','isAvailable'];
    let data_inp = ['name_inp','isAvailable_inp']; 
        
    let data_arg = "";

    for(i=0;i<data.length;i++){
        data_arg += data[i] + "=" + document.getElementById(data_inp[i]).value + "&";
    }
    data_arg += "add_court";
    console.log(data_arg);

    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/courts_ad.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.onload = function() {
        var myModal = document.getElementById("add-courts");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        console.log(this.responseText);
        if (this.responseText == 1) {
            console.log("success");
            alert('success', 'New court added');
            add_court_form.reset();
        } else {
            alert('error', 'Server Down');
        }
    };
    xhr.send(data_arg);
    /*$.ajax({
          url: 'ajax/courts_ad.php',
          data: formData,
          type: 'POST',
          processData: false,
          contentType: false,
          success: function (data) {
            root.innerHTML = 'FormData Object Send Successfully!'
          },
          error: function (err) {
            root.innerHTML = 'FormData Object Send Failed!'
          },
        })*/
}

function toggle_status(id,val)
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/courts_ad.php", true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.onload = function() {
        if(this.responseText==1){
            alert('success','Status toggled');
        }
        else{
            alert('success','Server Down!');
        }
    }

    xhr.send('toggle_status='+id+'&value='+val);
    
}

/*
function get_all_courts()
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/courts_ad.php", true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.onload = function() {
        document.getElementById('court-data').innerHTML = this.responseText;
    }

    xhr.send('get_all_courts')
    
}

window.onload = function(){
    get_all_courts();
       
    }*/
</script>       
        
    
</body> 