<?php

class Massage_room_m extends CI_Model {

    // Constructor to initialize the model
    function __construct()
    {
        // Call the Model constructor from the parent class
        parent::__construct();
    }
    
    // Function to retrieve all massage rooms
    function get_massageRooms()
    {
        // Query to get all records from the 'massage_room' table
        $query = $this->db->from('massage_room')->get();
        $data = array();

        // Loop through the query result and add each row to the data array
        foreach (@$query->result() as $row)
        {
            $data[] = $row; // Add each room to the data array
        }
        
        // Return the array of massage rooms if not empty, else return false
        if(count($data))
            return $data;
        return false;
    }

    // Function to add a new massage room
    function addMassageroom($massageroomOpenTime, $massageroomCloseTime, $massageroomDetails)
    {
        // Prepare the data array for insertion
        $data = array(
            'massageroom_open_time' => $massageroomOpenTime,
            'massageroom_close_time' => $massageroomCloseTime,
            'massageroom_details' => $massageroomDetails
        );
        
        // Insert the data into the 'massage_room' table
        $this->db->insert('massage_room', $data);
        // Return the number of affected rows to confirm insertion
        return $this->db->affected_rows();
    }

    // Function to delete a massage room by ID
    function deleteMassageroom($massageroom_id)
    {
        // Delete the massage room record with the specified ID
        $this->db->delete('massage_room', array('massageroom_id' => $massageroom_id));
        // Return the number of affected rows to confirm deletion
        return $this->db->affected_rows();
    }

    // Function to edit an existing massage room's details
    function editMassageroom($massageroom_id, $massageroom_open_time, $massageroom_close_time, $massageroom_details)
    {
        // Prepare the data array for updating
        $data = array(
            'massageroom_open_time' => $massageroom_open_time,
            'massageroom_close_time' => $massageroom_close_time,
            'massageroom_details' => $massageroom_details
        );

        // Specify the massage room ID to update
        $this->db->where('massageroom_id', $massageroom_id);
        // Update the massage room record in the 'massage_room' table
        $this->db->update('massage_room', $data); 
    }

    // Function to retrieve a specific massage room by ID
    function get_massageroom($massageroom_id)
    {
        // Query the 'massage_room' table for the specified massage room ID
        $query = $this->db->get_where('massage_room', array('massageroom_id' => $massageroom_id));
        // Return the result as an array
        return $query->result();
    }

    // Function to add a massage service record
    function add_service($massage_room, $customer, $date, $details, $price)
    {
        // Prepare the data array for insertion into the 'massage_service' table
        $data = array(
            'massageroom_id' => $massage_room,
            'customer_id' => $customer,
            'employee_id' => UID, // Assuming UID is defined elsewhere (e.g., user session)
            'massage_date' => $date,
            'massage_details' => $details,
            'massage_price' => $price
        );
        
        // Insert the data into the 'massage_service' table
        $this->db->insert('massage_service', $data);
    }
}
