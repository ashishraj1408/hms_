<?php

class Employee_m extends CI_Model {

    // Constructor to initialize the model
    function __construct()
    {
        // Call the Model constructor from the parent class
        parent::__construct();
    }
    
    // Function to retrieve all employees along with their department details
    function get_employees()
    {
        // Query to join 'employee' table with 'department' table
        $query = $this->db->from('employee')->join('department', 'department.department_id=employee.department_id')->get();
        $data = array();

        // Loop through the query result and add each row to the data array
        foreach (@$query->result() as $row)
        {
            $data[] = $row;
            // Here we could access customer properties if needed, but it's commented out
        }
        
        // Return the array of employees if not empty, else return false
        if(count($data))
            return $data;
        return false;
    } 

    // Function to add a new employee
    function addEmployee($username, $password, $firstname, $lastname, $telephone, $email, $departmentid, $employee_type, $employee_salary, $employee_hiring_date)
    {
        // Prepare the data array for insertion
        $data = array(
            'employee_username' => $username,
            'employee_password' => $password,
            'employee_firstname' => $firstname,
            'employee_lastname' => $lastname,
            'employee_telephone' => $telephone,
            'employee_email' => $email,
            'department_id' => $departmentid,
            'employee_type' => $employee_type,
            'employee_salary' => $employee_salary,
            'employee_hiring_date' => $employee_hiring_date
        );
        
        // Insert the data into the 'employee' table
        $this->db->insert('employee', $data);
        // Return the number of affected rows to confirm insertion
        return $this->db->affected_rows();
    } 

    // Function to delete an employee by ID
    function deleteEmployee($employee_id)
    {
        // Delete the employee record with the specified ID
        $this->db->delete('employee', array('employee_id' => $employee_id));
        // Return the number of affected rows to confirm deletion
        return $this->db->affected_rows();
    }

    // Function to edit an existing employee's details
    function editEmployee($employee_id, $username, $password, $firstname, $lastname, $telephone, $email, $department_id, $employee_type, $employee_salary, $employee_hiring_date)
    {
        // Prepare the data array for updating
        $data = array(
            'employee_username' => $username,
            'employee_password' => $password,
            'employee_firstname' => $firstname,
            'employee_lastname' => $lastname,
            'employee_telephone' => $telephone,
            'employee_email' => $email,
            'department_id' => $department_id,
            'employee_type' => $employee_type,
            'employee_salary' => $employee_salary,
            'employee_hiring_date' => $employee_hiring_date
        );

        // Specify the employee ID to update
        $this->db->where('employee_id', $employee_id);
        // Update the employee record in the 'employee' table
        $this->db->update('employee', $data); 
    }

    // Function to retrieve a specific employee by ID
    function getEmployee($employee_id)
    {
        // Query the 'employee' table for the specified employee ID
        $query = $this->db->get_where('employee', array('employee_id' => $employee_id));
        // Return the result as an array
        return $query->result();
    }

    // Function to retrieve all departments for employee assignment
    function getDepartments()
    {
        // Query the 'department' table to get all records
        $query = $this->db->from('department')->get();
        $data = array();

        // Loop through the query result and add each row to the data array
        foreach ($query->result() as $row)
        {
            $data[] = $row;
            // Here we could access customer properties if needed, but it's commented out
        }
        
        // Return the array of departments if not empty, else return false
        if(count($data))
            return $data;
        return false;
    }   
}
