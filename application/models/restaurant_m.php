<?php

class Restaurant_m extends CI_Model {

    // Constructor to initialize the model
    function __construct()
    {
        // Call the Model constructor from the parent class
        parent::__construct();
    }
    
    // Function to retrieve all restaurants
    function get_restaurants()
    {
        // Query to select all entries from the restaurant table
        $query = $this->db->from('restaurant')->get();
        $data = array();

        // Loop through the results and populate the data array
        foreach (@$query->result() as $row)
        {
            $data[] = $row; // Add each row to the data array
        }
        
        // Return the data array if it contains results, otherwise return false
        if(count($data))
            return $data;
        return false;
    } 

    // Function to add a new restaurant
    function addRestaurant($restaurantName, $restaurantOpenTime, $restaurantCloseTime, $restaurantDetails, $tableCount)
    {
        // Prepare the data for insertion
        $data = array(
            'restaurant_name' => $restaurantName,
            'restaurant_open_time' => $restaurantOpenTime,
            'restaurant_close_time' => $restaurantCloseTime,
            'restaurant_details' => $restaurantDetails,
            'table_count' => $tableCount
        );
        
        // Insert the data into the restaurant table
        $this->db->insert('restaurant', $data);
        // Return the number of affected rows
        return $this->db->affected_rows();
    } 

    // Function to delete a restaurant by name
    function deleteRestaurant($restaurant_name)
    {
        // Delete the restaurant entry from the table
        $this->db->delete('restaurant', array('restaurant_name' => $restaurant_name));
        // Return the number of affected rows
        return $this->db->affected_rows();
    }

    // Function to edit a restaurant's details
    function editRestaurant($restaurant_name, $restaurant_open_time, $restaurant_close_time, $restaurant_details, $tableCount)
    {
        // Prepare the updated data
        $data = array(
            'restaurant_name' => $restaurant_name,
            'restaurant_open_time' => $restaurant_open_time,
            'restaurant_close_time' => $restaurant_close_time,
            'restaurant_details' => $restaurant_details,
            'table_count' => $tableCount
        );

        // Specify which restaurant to update
        $this->db->where('restaurant_name', $restaurant_name);
        // Perform the update
        $this->db->update('restaurant', $data); 
    }

    // Function to retrieve a specific restaurant by name
    function getRestaurant($restaurant_name)
    {
        // Query to get the restaurant details
        $query = $this->db->get_where('restaurant', array('restaurant_name' => $restaurant_name));
        // Return the result
        return $query->result();
    }

    // Function to add a service booking for a restaurant
    function add_service($restaurant, $customer, $date, $table_num, $price)
    {
        // Prepare the data for insertion into restaurant_booking
        $data = array(
            'restaurant_name' => $restaurant,
            'customer_id' => $customer,
            'book_date' => $date,
            'table_number' => $table_num,
            'book_price' => $price
        );
        
        // Insert the booking data into the restaurant_booking table
        $this->db->insert('restaurant_booking', $data);
    }
}
