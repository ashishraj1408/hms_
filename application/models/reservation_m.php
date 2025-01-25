<?php

class Reservation_m extends CI_Model {

    // Constructor to initialize the model
    function __construct()
    {
        // Call the Model constructor from the parent class
        parent::__construct();
    }
    
    // Function to get available rooms based on room type and date range
    function get_available_rooms($room_type, $checkin_date, $checkout_date)
    {
        // Call a stored procedure to retrieve available rooms
        $query = $this->db->query("CALL get_available_rooms('$room_type','$checkin_date','$checkout_date')");
        
        $this->db->reconnect(); // Ensure the database connection is active
        $data = array();

        // Loop through the query results and store them in an array
        foreach (@$query->result() as $row)
        {
            $data[] = $row; // Add each row to the data array
        }
        
        // Return the data array if it contains results, else return false
        if(count($data))
            return $data;
        return false;
    }

    // Function to add a new reservation
    public function add_reservation($data, $date=NULL)
    {
        // Set the reservation date in the data array
        $data['reservation_date'] = $date;
        
        // Insert the reservation data into the database
        $query = $this->db->insert('reservation', $data);
        // Optionally, you could return affected rows if needed
        // return $query->affected_rows();
    }
}
