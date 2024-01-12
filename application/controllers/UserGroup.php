<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class UserGroup extends BaseController{
	function __construct(){
		parent::__construct();
		$this->isLoggedIn($this->global['idUser'],2,69);
    }
    
    function index(){
        $this->global['pageTitle'] = "SIMRS - User Group";
		$this->loadViews("masterdata/usergroup/body",$this->global,NULL,"masterdata/usergroup/footer");
    }

    function view(){
        $data = [
            'view' => $this->db->get("users_access")->result()
        ];
        $this->load->view("masterdata/usergroup/view",$data);
    }

    function add(){
        $this->global['pageTitle'] = "SIMRS - Tambah User Group";
		$this->loadViews("masterdata/usergroup/bodyAdd",$this->global,NULL,"masterdata/usergroup/footerAdd");
    }

    function addProses(){
        $group = $this->input->post("group");
        $menu = $this->input->post("menu");
        $submenu = $this->input->post("submenu");

        $data =  [
            'groups' => $group,
            'dateCreated' => date('Y-m-d H:i:s'),
            'menu' => $menu,
            'submenu' => $submenu
        ];

        $this->db->insert("users_access",$data);
    }

    function edit(){
        $this->global['pageTitle'] = "SIMRS - Edit User Group";
        $id = $this->uri->segment(3);
        $data = [
            'view' => $this->db->get_where("users_access",['id' => $id])->row()
        ];
		$this->loadViews("masterdata/usergroup/bodyEdit",$this->global,$data,"masterdata/usergroup/footerEdit");
    }

    function update(){
        $group = $this->input->post("group");
        $menu = $this->input->post("menu");
        $submenu = $this->input->post("submenu");
        $id = $this->input->post("id");

        $data = [
            'groups' => $group,
            'dateModified' => date('Y-m-d H:i:s'),
            'menu' => $menu,
            'submenu' => $submenu
        ];

        $this->modelPublic->update("users_access",[
            'id' => $id
        ],$data);

        //update hak akses user yg pake ini
        $dataUpdate = [
            'menu' => $menu,
            'sub_menu' => $submenu
        ];

        $this->modelPublic->update("users",['hakAkses' => $id],$dataUpdate);
    }

    function destroy(){
        $id = $this->input->post("id");
        $this->db->delete("users_access",['id' => $id]);

        //update hak akses user yg pake ini
        $dataUpdate = [
            'menu' => '',
            'sub_menu' => ''
        ];

        $this->modelPublic->update("users",['hakAkses' => $id],$dataUpdate);
    }
}