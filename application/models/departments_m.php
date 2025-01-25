<?php

class Departments_m extends CI_Model {

    // Constructor to initialize the model
    function __construct()
    {
        // Call the Model constructor from the parent class
        parent::__construct();
    }
    
    // Function to retrieve all departments
    function get_departments()
    {
        // Query the 'department' table to get all records
        $query = $this->db->from('department')->get();
        $data = array();

        // Loop through the query result and add each row to the data array
        foreach (@$query->result() as $row)
        {
            $data[] = $row;
        }
        
        // Return the array of departments if not empty, else return false
        if(count($data))
            return $data;
        return false;
    } 

    // Function to add a new department
    function addDepartment($departmentName, $departmentBudget)
    {
        // Prepare the data array for insertion
        $data = array('department_name' => $departmentName, 'department_budget' => $departmentBudget);
        // Insert the data into the 'department' table
        $this->db->insert('department', $data);
        // Return the number of affected rows to confirm insertion
        return $this->db->affected_rows();
    }

    // Function to delete a department by ID
    function deleteDepartment($department_id)
    {
        // Delete the department record with the specified ID
        $this->db->delete('department', array('department_id' => $department_id));
        // Return the number of affected rows to confirm deletion
        return $this->db->affected_rows();
    }

    // Function to edit an existing department's details
    function editEmployee($department_id, $departmentName, $departmentBudget)
    {
        // Prepare the data array for updating
        $data = array('department_name' => $departmentName, 'department_budget' => $departmentBudget);

        // Specify the department ID to update
        $this->db->where('department_id', $department_id);
        // Update the department record in the 'department' table
        $this->db->update('department', $data); 
    }

    // Function to retrieve a specific department by ID
    function getDepartment($department_id)
    {
        // Query the 'department' table for the specified department ID
        $query = $this->db->get_where('department', array('department_id' => $department_id));
        // Return the result as an array
        return $query->result();
    }

}
