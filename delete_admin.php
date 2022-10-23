<?php

    //include 'C:\xampp\htdocs\wordpress\wp-content\plugins\burak-admin-menu\burak-admin-menu.php';
    include 'C:\xampp\htdocs\wordpress\wp-load.php';
    global $wpdb;
    require_once('C:\xampp\htdocs\wordpress\wp-admin\includes\user.php' );

    if (isset($_GET['deleteID'])) {

        $UserID = $_GET['deleteID'];
        echo "$UserID";
	    $users = $wpdb->get_results("SELECT * FROM wp_user_table WHERE User_ID = $UserID;");
		$response = $wpdb->get_results("DELETE FROM wp_user_table WHERE User_ID = $UserID ;");

        if ($response = array(
	            'name' => $users->Name,
	            'email' => $users->Email,
	            'message' => $users->Message,
            )) {
            echo "Deleted Successfully";
	        header('location:http://localhost/wordpress/wp-admin/admin.php?page=burak-admin-menu-sub-displayuser');
        }
        else {
            echo "Unable to delete";
        }

    }
