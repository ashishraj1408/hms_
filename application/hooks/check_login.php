<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Define a class for handling post-controller hooks
class postControllerHook {

    // Function to check user login status and define constants
    function check_login() {
        // Get the CodeIgniter instance
        $CI =& get_instance();

        // Uncomment the next line to enable profiler for debugging
        // $CI->output->enable_profiler(TRUE);
        
        // Define constants based on session user data
        define('UID', $CI->session->userdata('uid'));              // User ID from session
        define('USERNAME', $CI->session->userdata('username'));    // Username from session
        define('FULLNAME', $CI->session->userdata('fullname'));    // Full name from session
        define('DEPARTMENT_NAME', $CI->session->userdata('department_name')); // Department name from session

        // Define SHOW_GUIDE constant based on session data
        define("SHOW_GUIDE", !$CI->session->userdata('show_guide')); // If 'show_guide' is not set, SHOW_GUIDE is true
    }
}
?>
