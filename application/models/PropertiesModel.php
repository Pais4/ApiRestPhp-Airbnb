<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PropertiesModel extends CI_Model {

	public function addProperty($property){
        $this->db->insert('properties', $property);
    }
    
    public function getAllProperties(){
        $response = $this->db->query("SELECT * FROM properties")->result();
        return $response;
    }

    public function getSortedByPrice(){
        $response = $this->db->query("SELECT * FROM properties ORDER BY price")->result();
        return $response;
    }

    public function getSortedUserProperties($userId){
        $response = $this->db->query("SELECT * FROM properties WHERE id_user = '${userId}' ORDER BY price")->result();
        return $response;
    }

    public function getSortedProperties(){
        $response = $this->db->query("SELECT * FROM properties ORDER BY price")->result();
        return $response;
    }

    public function updateProperty($property){

        $id = $property->id;
        $title = $property->title;
        $property_type = $property->property_type;
        $adress = $property->adress;
        $rooms = $property->rooms;
        $price = $property->price;
        $area = $property->area;
        $id_user = $property->id_user;

        $response = $this->db->query("UPDATE properties SET title = '${title}', property_type = '${property_type}', adress = '${adress}',
        rooms = '${rooms}', price = '${price}', area = '${area}', id_user = '${id_user}' WHERE id = '${id}'");
        return $response;
    }

    public function deleteProperty($id){
        $this->db->query("DELETE FROM properties WHERE id = {$id}");
    }

}