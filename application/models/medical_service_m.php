<?php

class Medical_service_m extends CI_Model {

    // Constructor to initialize the model
    function __construct()
    {
        // Call the Model constructor from the parent class
        parent::__construct();
    }
    
    // Function to retrieve all medical services
    function get_medicalServices()
    {
        // Query to get all records from the 'medical_service' table
        $query = $this->db->from('medical_service')->get();
        $data = array();

        // Loop through the query result and add each row to the data array
        foreach (@$query->result() as $row)
        {
            $data[] = $row; // Add each medical service to the data array
        }
        
        // Return the array of medical services if not empty, else return false
        if(count($data))
            return $data;
        return false;
    }

    // Function to add a new medical service
    function addMedicalservice($medicalserviceOpenTime, $medicalserviceCloseTime, $medicalserviceDetails)
    {
        // Prepare the data array for insertion
        $data = array(
            'medicalservice_open_time' => $medicalserviceOpenTime,
            'medicalservice_close_time' => $medicalserviceCloseTime,
            'medicalservice_details' => $medicalserviceDetails
        );
        
        // Insert the data into the 'medical_service' table
        $this->db->insert('medical_service', $data);
        // Return the number of affected rows to confirm insertion
        return $this->db->affected_rows();
    }

    // Function to delete a medical service by ID
    function deleteMedicalservice($medicalservice_id)
    {
        // Delete the medical service record with the specified ID
        $this->db->delete('medical_service', array('medicalservice_id' => $medicalservice_id));
        // Return the number of affected rows to confirm deletion
        return $this->db->affected_rows();
    }

    // Function to edit an existing medical service's details
    function editMedicalservice($medicalservice_id, $medicalservice_open_time, $medicalservice_close_time, $medicalservice_details)
    {
        // Prepare the data array for updating
        $data = array(
            'medicalservice_open_time' => $medicalservice_open_time,
            'medicalservice_close_time' => $medicalservice_close_time,
            'medicalservice_details' => $medicalservice_details
        );

        // Specify the medical service ID to update
        $this->db->where('medicalservice_id', $medicalservice_id);
        // Update the medical service record in the 'medical_service' table
        $this->db->update('medical_service', $data); 
    }

    // Function to retrieve a specific medical service by ID
    function get_medicalservice($medicalservice_id)
    {
        // Query the 'medical_service' table for the specified medical service ID
        $query = $this->db->get_where('medical_service', array('medicalservice_id' => $medicalservice_id));
        // Return the result as an array
        return $query->result();
    }

}
