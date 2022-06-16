<?php
 
 
class ShoppingList_model extends CI_Model{
 
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
        $lists = $this->db->get("lists")->result();
        return $lists;
    }
 
    /*
        Store the record in the database
    */
    public function store()
    {    
        $data = [
            'title' => $this->input->post('title'),
            // 'date_added' => $this->input->post('date_added'),
            // 'status' => $this->input->post('status'),
            'category_id' => $this->input->post('category_id'),
        ];
 
        $result = $this->db->insert('lists', $data);
        return $result;
    }
 
    /*
        Get an specific record from the database
    */
    public function get($id)
    {
        $list = $this->db->get_where('lists', ['id' => $id ])->row();
        return $list;
    }
 
 
    /*
        Update or Modify a record in the database
    */
    public function update($id) 
    {
        $data = [
            'title' => $this->input->post('title'),
            'date_added' => $this->input->post('date_added'),
            'status' => $this->input->post('status'),
            'category_id' => $this->input->post('category_id'),
        ];
 
        $result = $this->db->where('id', $id)->update('lists',$data);
        return $result;
                 
    }
 
    /*
        Destroy or Remove a record in the database
    */
    public function delete($id)
    {
        $result = $this->db->delete('lists', array('id' => $id));
        return $result;
    }
     
}
?>