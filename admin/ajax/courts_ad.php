<?php 
    require('../essential.php');
    require('../db_config.php');
    adminLogin();

    
    if(isset($_POST['add_court'])){

        
        $frm_Data = filteration($_POST);
        //print_r($frm_Data);
        
        $q1 = "INSERT INTO `courts`( `name`, `isAvailable`) VALUES (?,?)";
        $value = [$frm_Data["name"], $frm_Data["isAvailable"]];
    
       //if(insert($q1,$values,'si')){
          // $flag = 1;

        //}
        $res = insert($q1,$value,'si');
        echo $res;

    }
    
    if(isset($_POST['toggle_status'])){

        $frm_data = filteration($_POST);

        $q = "UPDATE `courts` SET `status`=? WHERE `id`=?";
        $v = [$frm_data['value'],$frm_data['toggle_status']];

        if(update($q,$v,'ii')){
            echo 1;
        }
        else{
            echo 0;
        }

    }


/*
    if(isset($_POST['user_queries']))
    {
        $frm_data = filteration($_POST);
        $q = "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
        $value = [$frmData["name"], $frmData["email"], $frmData["subject"], $frmData["message"]];

        $res = insert($q,$value,'ssss');
        echo $res;
    } */

    if(isset($_POST['update_badminton_court'])){

        $frm_data = filteration($_POST);

        $q = "UPDATE `courts` SET `status`= 1 WHERE `book_from`=? AND `book_to`=? AND `name`=?";
        $v = [$frm_data['book_from'],$frm_data['book_to'],$frm_data['name']];

        
        $res = update($q,$v,'sss');
        echo $res;

    }

    if(isset($_POST['approve'])){

        $frm_data = filteration($_POST);

        $q = "UPDATE `courts` SET `status`= 2 WHERE `id`=?";
        $v = [$frm_data['id']];

        
        $res = update($q,$v,'i');
        echo $res;

    }
    if(isset($_POST['reject'])){

        $frm_data = filteration($_POST);

        $q = "UPDATE `courts` SET `status`= 0 WHERE `id`=?";
        $v = [$frm_data['id']];

        
        $res = update($q,$v,'i');
        echo $res;

    }

    
?>
