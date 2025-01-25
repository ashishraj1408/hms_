<?php

class Sport_facility_m extends CI_Model {

    // Constructor to initialize the model
    function __construct()
    {
        // Call the Model constructor from the parent class
        parent::__construct();
    }
    
    // Function to get all sport facilities
    function get_sportFacilities()
    {
        // Retrieve all records from the sport_facilities table
        $query = $this->db->from('sport_facilities')->get();
        $data = array();

        foreach (@$query->result() as $row)
        {
            $data[] = $row; // Add each row to the data array
        }
        // Return the data array if it contains results, otherwise return false
        return count($data) ? $data : false;
    }

    // Function to add a new sport facility
    function addSportfacility($sportfacilityOpenTime, $sportfacilityCloseTime, $sportfacilityDetails)
    {
        // Prepare data for insertion
        $data = array(
            'sportfacility_open_time' => $sportfacilityOpenTime,
            'sportfacility_close_time' => $sportfacilityCloseTime,
            'sportfacility_details' => $sportfacilityDetails
        );
        // Insert the new sport facility into the database
        $this->db->insert('sport_facilities', $data);
        // Return the number of affected rows
        return $this->db->affected_rows();
    }

    // Function to delete a sport facility by ID
    function deleteSportfacility($sportfacility_id)
    {
        // Delete the specified sport facility from the database
        $this->db->delete('sport_facilities', array('sportfacility_id' => $sportfacility_id));
        // Return the number of affected rows
        return $this->db->affected_rows();
    }

    // Function to edit an existing sport facility
    function editSportfacility($sportfacility_id, $sportfacility_open_time, $sportfacility_close_time, $sportfacility_details)
    {
        // Prepare data for updating
        $data = array(
            'sportfacility_open_time' => $sportfacility_open_time,
            'sportfacility_close_time' => $sportfacility_close_time,
            'sportfacility_details' => $sportfacility_details
        );

        // Update the specified sport facility in the database
        $this->db->where('sportfacility_id', $sportfacility_id);
        $this->db->update('sport_facilities', $data); 
    }

    // Function to get a specific sport facility by ID
    function get_sportfacility($sportfacility_id)
    {
        // Query to get the sport facility details
        $query = $this->db->get_where('sport_facilities', array('sportfacility_id' => $sportfacility_id));
        return $query->result();
    }

    // Function to add a service for a sport facility
    function add_service($sport_facility, $customer, $date, $details, $price)
    {
        // Prepare data for service insertion
        $data = array(
            'sportfacility_id' => $sport_facility,
            'customer_id' => $customer,
            'employee_id' => UID, // Assuming UID is defined somewhere globally
            'dosport_date' => $date,
            'dosport_details' => $details,
            'dosport_price' => $price
        );
        // Insert the service record into the do_sport table
        $this->db->insert('do_sport', $data);
    }
}
