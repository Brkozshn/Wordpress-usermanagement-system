
<?php
include 'C:\xampp\htdocs\wordpress\wp-load.php';
require_once('C:\xampp\htdocs\wordpress\wp-admin\includes\user.php');

global $wpdb;

?>

<?php

if ( isset( $_GET['editID'] ) ) {

	$UserID = $_GET['editID'];

	/*if ( isset( $_POST['submit'] ) ) {

       // $execute = $wpdb->get_results( "UPDATE wp_user_table SET Name=$name WHERE User_ID = $UserID ;");

        $name = $_POST['full_name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        $format=("%d");
        $whereFormat=("%d");
        $table_name = $wpdb->prefix.'user_table';
        $data_update = array(
                'name' => $name,
                'email' => $email,
                'message' => $message
        );
        $data_where = array('User_ID' => $UserID);
        $execute = $wpdb->update($table_name , $data_update, $data_where);
        //exit( var_dump( $wpdb->last_query ) );

        if ($execute == 'False')
            {echo "Could not editted";}
        else{
            echo "Editted Successfully";
            header('location:http://localhost/wordpress/wp-admin/admin.php?page=burak-admin-menu-sub-displayuser');
        }
    }*/
}
?>

