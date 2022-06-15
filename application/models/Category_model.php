<?php
 
 
class Category_model extends CI_Model{
 
    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url');
    }
 
    /*
        Get all the records from the database
    */
    public function get_all()
    {
        $categories = $this->db->get("categories")->result();
        return $categories;
    }
 
    /*
        Store the record in the database
    */
    public function store()
    {    
        $data = [
            'title' => $this->input->post('title'),
        ];
 
        $result = $this->db->insert('categories', $data);
        return $result;
    }
 
    /*
        Get an specific record from the database
    */
    public function get($id)
    {
        $category = $this->db->get_where('categories', ['id' => $id ])->row();
        return $category;
    }
 
 
    /*
        Update or Modify a record in the database
    */
    public function update($id) 
    {
        $data = [
            'title'        => $this->input->post('title'),
        ];
 
        $result = $this->db->where('id',$id)->update('categories',$data);
        return $result;
                 
    }
 
    /*
        Destroy or Remove a record in the database
    */
    public function delete($id)
    {
        $result = $this->db->delete('categories', array('id' => $id));
        return $result;
    }
     
}
?>