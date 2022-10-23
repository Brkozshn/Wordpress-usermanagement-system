<?php
/**
* Plugin Name: Burak Admin Menu
* Description: Admin Menu for users
*/

//include 'C:\xampp\htdocs\wordpress\wp-includes\plugin.php';

//require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'plugin.php';

//require_once( dirname(path:) . 'wp-includes/plugin.php');

include 'C:\xampp\htdocs\wordpress\wp-load.php';
require_once('C:\xampp\htdocs\wordpress\wp-admin\includes\user.php');

function burak_admin_menu() {
    
    add_menu_page('Forms', 'All Users', 'manage_options', 'burak-admin-menu', 'burak_admin_menu_main', 'dashicons-admin-users',4);
    
    add_submenu_page('burak-admin-menu','Adding Users', 'Add User', 'manage_options','burak-admin-menu-sub-adduser','burak_admin_menu_sub_adduser');
    
      add_submenu_page('burak-admin-menu','Showing Users', 'Display Users', 'manage_options','burak-admin-menu-sub-displayuser','burak_admin_menu_sub_displayuser');
}

     add_action('admin_menu', 'burak_admin_menu');

function burak_admin_menu_main() {

    // This function has to do editing and displaying the users.

    echo "<table class='widefat fixed'>";
    echo "<th>ID</th>";
    echo "<th>Name</th>";
    echo "<th>Email</th>";
    echo "<th>Message</th>";


    echo '<div class="wrap"><h2>All Users Panel</h2>Please select an option </div>';
}

function burak_admin_menu_sub_adduser() {
  ?>
    <a id="edit-user"></a>
        <?php
    
    $validation_messages = [];
	$success_message = '';
    global $wpdb;
	global $user;

	if ( isset( $_POST['contact_form'] ) ) {

		//Sanitize the data
		$full_name = isset( $_POST['full_name'] ) ? sanitize_text_field( $_POST['full_name'] ) : '';
		$email     = isset( $_POST['email'] ) ? sanitize_text_field( $_POST['email'] ) : '';
		$message   = isset( $_POST['message'] ) ? sanitize_textarea_field( $_POST['message'] ) : '';

		//Validate the data
		if ( strlen( $full_name ) === 0 ) {
			$validation_messages[] = esc_html__( 'Please enter a valid name.', 'twentytwentyone' );
		}

		if ( strlen( $email ) === 0 or
		     ! is_email( $email ) ) {
			$validation_messages[] = esc_html__( 'Please enter a valid email address.', 'twentytwentyone' );
		}

		if ( strlen( $message ) === 0 ) {
			$validation_messages[] = esc_html__( 'Please enter a valid message.', 'twentytwentyone' );
		}

	}

	//Display the validation errors
	if ( ! empty( $validation_messages ) ) {
		foreach ( $validation_messages as $validation_message ) {
			echo '<div class="validation-message">' . esc_html( $validation_message ) . '</div>';
		}
	}

	//Display the success message
	if ( strlen( $success_message ) > 0 ) {
		echo '<div class="success-message">' . esc_html( $success_message ) . '</div>';
	}

    if (isset($_GET['editID'])){
	    $UserID = $_GET['editID'];

       // Use sql command to get the wanted user information.
	    $user = $wpdb->get_results("SELECT * FROM wp_user_table WHERE User_ID = $UserID");
	    //exit( var_dump( $wpdb->last_query ) );
       // Information for the previous user. We can print out in here.
        //$ad = $user->Name;
        //$mail = $user->Email;
        //$mes = $user->Message;

	    if ( isset( $_POST['submit'] ) ) {

		    $name = $_POST['full_name'];
		    $email = $_POST['email'];
		    $message = $_POST['message'];

		    $table_name = $wpdb->prefix.'user_table';
		    $data_update = array(
			    'name' => $name,
			    'email' => $email,
			    'message' => $message
		    );
		    $data_where = array('User_ID' => $UserID);
		    $execute = $wpdb->update($table_name , $data_update, $data_where);

		    if ($execute == 'False')
		    {echo "Could not editted";}
		    else{
			    echo "Editted Successfully";
			    header('location:http://localhost/wordpress/wp-admin/admin.php?page=burak-admin-menu-sub-displayuser');
		    }
	    }
    }
	?>

    <!-- Echo a container used that will be used for the JavaScript validation -->
    <div id="validation-messages-container"></div>

    <form id="contact-form" action=""
          method="POST">

        <input type="hidden" name="contact_form">

        <div class="form-section">
            <label for="full-name"><?php echo esc_html( 'Full Name', 'twentytwentyone' ); ?></label>
            "<input type="text" id="full-name" name="full_name" value="$user['User_ID']">
        </div>

        <div class="form-section">
            <label for="email"><?php echo esc_html( 'Email', 'twentytwentyone' ); ?></label>
	        <input type='text' id='email' name='email' value="$user['Email']">
        </div>

        <div class="form-section">
            <label for="message"><?php echo esc_html( 'Message', 'twentytwentyone' ); ?></label>
            <textarea id="message" name="message">$user['Message']</textarea>
        </div>

        <input type="submit" id="contact-form-submit" value="<?php echo esc_attr( 'Submit', 'twentytwentyone' ); ?>">

    </form>

	<?php
       
     if(isset($_POST['full_name']) && isset($_POST['email']) && isset($_POST['message'])) {
            $name = $_POST['full_name']; 
            $email = $_POST['email'];
            $message = $_POST['message'];
        
            $default = array(
            'name' => $name,
            'email' =>$email,
            'message' => $message
                );
             
            $item = shortcode_atts( $default, $_REQUEST );
            $wpdb->insert( 'wp_user_table', $item );
            }            
        } 

function burak_admin_menu_sub_displayuser() {
    
    ?>
    <div class="wrap">
		<h2>User Details</h2>
		<?php
		global $wpdb;
		$users = $wpdb->get_results("SELECT * FROM wp_user_table ORDER BY User_ID DESC;");
		echo "<table class='widefat fixed'>";
		echo "<th>ID</th>";
		echo "<th>Name</th>";
		echo "<th>Email</th>";
		echo "<th>Message</th>";

		foreach($users as $users){
			echo "<tr>";
			echo "<td><input type='text' name='ID' value=" . $users->User_ID . " size='1' readonly/></td>";
			$UserID = $users->User_ID;
			echo "<td>".$users->Name."</td>";
			echo "<td>".$users->Email."</td>";
			echo "<td>".$users->Message."</td>";
            echo "<td><button class='btn btn-primary'><a href='admin.php?page=burak-admin-menu-sub-adduser&editID=$users->User_ID'class= text-large'> Edit User </a></button></td>";
            echo "<td><button class='btn btn-primary'><a href='delete_admin.php?deleteID=$users->User_ID 'class= text-large'> Delete User </a></button></td>";
           // echo "<td></td>"

            echo "</tr>";
		}

		echo "</table>"; ?>

   </div>

     <?php
	}
?>