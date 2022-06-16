<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ShoppingList extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('session');
    $this->load->library('form_validation');
    $this->load->database();
  }

  public function index()
  {
    $lists = $this->db->get('lists')->result();
    $this->db->get('lists')->result();

    $category_lists = $this->db->select('lists.id as list_id, categories.title as cat_title')
      ->from('categories')->join('lists', 'categories.id = lists.category_id')->get()->result();
    // var_dump($category_lists); 
    $title = 'All list';
    $this->load->view('list/index', ['lists' => $lists, 'title' => $title, 'category_lists' => $category_lists]);
    $this->load->view('layout/header', ['title' => $title]);
    $this->load->view('layout/footer');
  }

  public function create()
  {
    $title = 'Create List';
    $categories = $this->db->get('categories')->result();
    $this->load->view('list/create', ['title' => $title, 'categories' => $categories]);
    $this->load->view('layout/header', ['title' => $title]);
    $this->load->view('layout/footer');
  }

  public function edit($id)
  {
    $list = $this->db->where(['id' => $id])->get('lists')->row();
    $categories = $this->db->get('categories')->result();
    $title = 'Edit list';
    $this->load->view('list/edit', ['list' => $list, 'title' => $title, 'categories' => $categories]);
    $this->load->view('layout/header', ['title' => $title]);
    $this->load->view('layout/footer');
  }

  public function store()
  {
    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('category_id', 'Category_id', 'required');

    if ($this->form_validation->run()) {
      $list = array(
        'title' => $this->input->post('title'),
        'category_id' => $this->input->post('category_id'),
      );

      $this->db->insert('lists', $list);
    } else {
      $errors = $this->form_validation->error_array();
      $this->session->set_flashdata('errors', $errors);
      redirect(base_url('list/create'));
    }

    redirect('/list');
  }

  public function update($id)
  {
    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('category_id', 'Category_id', 'required');
    $this->form_validation->set_rules('status', 'Status', '');

    if ($this->form_validation->run()) {
      $list = array(
        'title' => $this->input->post('title'),
        'category_id' => $this->input->post('category_id'),
        'status' => $this->input->post('status'),
      );

      $this->db->where(['id' => $id])->update('lists', $list);
    } else {
      $errors = $this->form_validation->error_array();
      $this->session->set_flashdata('errors', $errors);
      redirect(base_url('list/edit/' . $id));
    }

    redirect('/list');
  }

  public function show($id)
  {
    $list = $this->db->where(['id' => $id])->get('lists')->row();
    $title = 'Show list';
    $category_lists = $this->db->select('lists.id as list_id, categories.title as cat_title')
      ->from('categories')->join('lists', 'categories.id = lists.category_id')->get()->result();
    $this->load->view('list/show', ['list' => $list, 'title' => $title, 'category_lists' => $category_lists]);
    $this->load->view('layout/header', ['title' => $title]);
    $this->load->view('layout/footer');
  }

  public function delete($id)
  {
    $this->db->where(['id' => $id])->delete('lists');

    redirect('/list');
  }
}
