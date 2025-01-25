<?php

class Customer_m extends CI_Model {

    // Constructor to initialize the model
    function __construct()
    {
        // Call the Model constructor from the parent class
        parent::__construct();
    }
    
    // Function to retrieve a customer by their TC number
    function get_customer($TCno)
    {
        // Query the 'customer' table where 'customer_TCno' matches the provided TC number
        $query = $this->db->get_where('customer', array('customer_TCno' => $TCno));
        
        // Check if the query was successful
        if($query) {
            // Return the result as an array of objects
            return $query->result();
        } else {
            // If the query failed, return the query object (could be false)
            return $query;
        }
    } 
    
    // Function to add a new customer
    function add_customer($data)
    {
        // Insert the provided data into the 'customer' table
        $this->db->insert('customer', $data);
        // Optionally, you could return the number of affected rows
        // return $this->db->affected_rows();
    }

    // Function to retrieve active customers based on a stored procedure
    function get_active_customers()
    {
        // Get today's date in 'Y-m-d' format
        $date = date('Y-m-d');
        
        // Call the stored procedure 'get_customers' with today's date as a parameter
        $q = $this->db->query("CALL get_customers('$date')");

        // Initialize an array to store customer data
        $data = array();
        
        // Loop through the result set and add each customer to the data array
        foreach ($q->result() as $customer) {
            $data[] = $customer;
        }
        
        // Return the array of active customers
        return $data;
    }
}
