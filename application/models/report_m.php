<?php

class Report_m extends CI_Model {

    // Constructor to initialize the model
    function __construct()
    {
        // Call the Model constructor from the parent class
        parent::__construct();
    }
    
    // Function to get today's service statistics
    function today_stats()
    {
        // Get today's date
        $date = date('Y-m-d');
        // Execute a stored procedure to get today's service counts
        $query = $this->db->query("CALL todays_service_count('$date')");
        $data = array();

        // Loop through the query result and organize it into an associative array
        foreach (@$query->result() as $row)
        {
            $data[$row->type] = $row->amount; // Map service type to its count
        }
        
        // Return the data array if not empty, else return false
        if(count($data))
            return $data;
        return false;
    }

    // Function to search for customers based on first or last name
    function search_customers($query)
    {
        // Query the customer table for matches on first or last name
        $query = $this->db->from("customer")->like('customer_firstname', $query)->or_like('customer_lastname', $query)->get();
        $data = array();
        
        // Collect the results into an array
        foreach ($query->result() as $res) {
            $data[] = $res;
        }
        
        return $data; // Return the array of matching customers
    }

    // Function to get a list of customers with their frequency and total amount paid
    function get_customer_freq_list() {
        $this->db->reconnect(); // Reconnect to the database
        // Select customer details along with total paid and check-in count
        $query = $this->db->select("customer.* , SUM(  `room_sales_price` +  `total_service_price` ) as total_paid, COUNT(*) as checkin_count")
                ->from("room_sales")
                ->join("customer", "customer.customer_id = room_sales.customer_id")
                ->group_by("customer_id")
                ->order_by('checkin_count','DESC')
                ->order_by('total_paid','DESC')
                ->get();
        $data = array();
        
        // Loop through the results and add them to the data array
        foreach ($query->result() as $res) {
            $data[] = $res;
        }
        
        return $data; // Return the customer frequency list
    }

    // Function to get the customer who has paid the most
    function get_customer_most_paid() {
        // Execute a complex query to find the customer with the maximum total paid
        $query = $this->db->query(
            "SELECT * , COUNT(*) as checkin_count,  SUM(  `room_sales_price` +  `total_service_price` ) AS total_paid
            FROM room_sales
            JOIN (
                SELECT MAX( total_paid ) AS max_paid
                FROM (                
                    SELECT customer_id, SUM(  `room_sales_price` +  `total_service_price` ) AS total_paid
                    FROM room_sales
                    GROUP BY  `customer_id`
                ) AS SRS
            ) AS MRS
            LEFT JOIN customer ON customer.customer_id = room_sales.customer_id
            GROUP BY room_sales.customer_id HAVING total_paid = max_paid"
        );
        $data = array();
        
        // Loop through the results and add them to the data array
        foreach ($query->result() as $res) {
            $data[] = $res;
        }
        
        return $data; // Return the customer with the highest payment
    }

    // Function to get frequency counts for the next week
    function get_next_week_freq() {
        $dates = array();
        $freq_counts = array();
        
        // Loop through the next 7 days
        for($day = 1; $day <= 7; ++$day) {
            $date = date("Y-m-d", strtotime("+$day day")); // Calculate the date
            // Query to count reservations for that date
            $query = $this->db->query("SELECT COUNT(*) as count FROM reservation WHERE checkin_date <= '$date' AND checkout_date >= '$date'");
            $row = $query->row_array(0); // Get the result as an array
            
            // Store the date and its frequency count
            $dates[] = $date;
            $freq_counts[] = intval($row['count']);
        }
        
        // Return both dates and their corresponding frequency counts
        return array('dates' => $dates, 'freq_counts' => $freq_counts);
    }
}
