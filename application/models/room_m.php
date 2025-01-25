<?php

class Room_m extends CI_Model {

    // Constructor to initialize the model
    function __construct()
    {
        // Call the Model constructor from the parent class
        parent::__construct();
    }
    
    // Function to get all room types
    function get_room_types()
    {
        $query = $this->db->get('room_type'); // Retrieve all records from room_type table
        $data = array();

        if($query) {
            foreach ($query->result() as $row) {
                $data[] = $row; // Add each row to the data array
            }
        }
        // Return the data array if it contains results, otherwise return false
        return count($data) ? $data : false;
    } 

    // Function to get all rooms
    function get_rooms()
    {
        // Get rooms ordered by room_id
        $query = $this->db->order_by('room_id')->get('room');
        $data = array();
        $i = -1;

        foreach (@$query->result() as $row) {
            // Check if a new room type or room id range has started
            if ($i == -1 || $data[$i]->room_type != $row->room_type || $data[$i]->max_id + 1 != $row->room_id) {
                $i++;
                // Create a new entry for this room type
                $data[$i] = (object)['room_type' => $row->room_type, 'min_id' => intval($row->room_id), 'max_id' => intval($row->room_id)];
            } else {
                // Increment the max_id if the room continues the same type
                $data[$i]->max_id++;
            }
        }
        // Return the data array if it contains results, otherwise return false
        return count($data) ? $data : false;
    }

    // Function to add a new room type
    function addRoomType($type, $price, $details, $quantity)
    {
        $data = array(
            'room_type' => $type,
            'room_price' => $price,
            'room_details' => $details,
            'room_quantity' => $quantity
        );
        // Insert the new room type into the database
        $this->db->insert('room_type', $data);
        // Return the number of affected rows
        return $this->db->affected_rows();
    }

    // Function to delete a room type
    function deleteRoomType($room_type)
    {
        // Delete the specified room type from the database
        $this->db->delete('room_type', array('room_type' => $room_type));
        // Return the number of affected rows
        return $this->db->affected_rows();
    }

    // Function to get details of a specific room type
    function getRoomType($room_type)
    {
        // Query to get room type details
        $query = $this->db->get_where('room_type', array('room_type' => $room_type));
        return $query->result();
    }

    // Function to edit an existing room type
    function editRoomType($type, $price, $details, $quantity)
    {
        $data = array(
            'room_type' => $type,
            'room_price' => $price,
            'room_details' => $details,
            'room_quantity' => $quantity
        );

        // Update the specified room type in the database
        $this->db->where('room_type', $type);
        $this->db->update('room_type', $data); 
    }

    // Function to get rooms of a specific type
    function getRoom($room_type)
    {
        // Query to get all rooms of the specified type
        $query = $this->db->get_where('room', array('room_type' => $room_type));
        return $query->result();
    }

    // Function to check availability of a room range
    function isAvailRange($room_type, $min_id, $max_id) {
        // Query to find rooms not of the specified type within the given id range
        $query = $this->db->get_where('room', array('room_type !=' => $room_type, 'room_id >=' => $min_id, 'room_id <=' => $max_id));
        return $query->result();
    }

    // Function to get a specific range of rooms
    function getRoomRange($room_type, $min_id, $max_id) {
        // Query to find rooms within the specified id range
        $query = $this->db->get_where('room', array('room_id >=' => $min_id, 'room_id <=' => $max_id));
        return $query->result();
    }

    // Function to delete a range of rooms
    function deleteRoomRange($min_id, $max_id) {
        // Delete rooms within the specified id range
        $this->db->delete('room', array('room_id >=' => $min_id, 'room_id <=' => $max_id));
        // Return the number of affected rows
        return $this->db->affected_rows();
    }

    // Function to add a range of rooms
    function addRoomRange($room_type, $min_id, $max_id) {
        $data = array();
        // Create an array of room entries to insert
        for ($i = $min_id; $i <= $max_id; ++$i) {
            $data[] = array('room_type' => $room_type, 'room_id' => $i);
        }
        // Insert the array of room entries into the database
        $this->db->insert_batch('room', $data);
        // Return the number of affected rows
        return $this->db->affected_rows();
    }

    // Function to add a sale for a room
    function add_room_sale($data) {
        // Join room_type table to retrieve price for the room
        $query = $this->db->join("room_type", "room_type.room_type = room.room_type", "left")->get_where("room", array('room_id' => $data['room_id']));
        if (!$query || $query->num_rows() == 0) {
            return false; // If no room is found, return false
        }
        // Get the price of the room
        $price = $query->result();
        $data['room_sales_price'] = $price[0]->room_price;
        $data['total_service_price'] = 0; // Initialize total service price
        // Insert the room sale into the database
        $this->db->insert('room_sales', $data);
    }
}
