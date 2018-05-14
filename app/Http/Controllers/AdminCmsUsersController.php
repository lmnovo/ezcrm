<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDbooster;

class AdminCmsUsersController extends \crocodicstudio\crudbooster\controllers\CBController {


	public function cbInit() {
		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->table               = 'cms_users';
		$this->primary_key         = 'id';
		$this->title_field         = "name";
		$this->button_action_style = 'button_icon';	
		$this->button_import 	   = FALSE;	
		$this->button_export 	   = FALSE;
        $this->button_bulk_action  = FALSE;
        $this->button_show         = FALSE;
		# END CONFIGURATION DO NOT REMOVE THIS LINE
	
		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = array();
		$this->col[] = array("label"=>trans('crudbooster.name'),"name"=>"name");
		$this->col[] = array("label"=>trans('crudbooster.email'),"name"=>"email");
		$this->col[] = array("label"=>trans('crudbooster.Privilege'),"name"=>"id_cms_privileges","join"=>"cms_privileges,name");
		$this->col[] = array("label"=>trans('crudbooster.photo'),"name"=>"photo","image"=>1);
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = array(); 		
		$this->form[] = array("label"=>trans('crudbooster.name'),"name"=>"name",'required'=>true,'validation'=>'required|alpha_spaces|min:3');
		$this->form[] = array("label"=>trans('crudbooster.email'),"name"=>"email",'required'=>true,'type'=>'email','validation'=>'required|email|unique:cms_users,email,'.CRUDBooster::getCurrentId());
		$this->form[] = array("label"=>trans('crudbooster.photo'),"name"=>"photo","type"=>"upload","help"=>"Recommended resolution is 200x200px",'required'=>false,'validation'=>'image|max:1000');
        $this->form[] = array('label'=>trans('crudbooster.date_birthday'),'name'=>'date_birthday','type'=>'date','required'=>true, 'validation'=>'required');
		$this->form[] = array("label"=>trans('crudbooster.Privilege'),"name"=>"id_cms_privileges","type"=>"select","datatable"=>"cms_privileges,name",'required'=>true);
		$this->form[] = array("label"=>trans('crudbooster.password'),"name"=>"password","type"=>"password","help"=>trans('crudbooster.password_message'));
        $this->form[] = array("label"=>trans('crudbooster.sign'),"name"=>"firma","type"=>"wysiwyg",'required'=>false);

        # END FORM DO NOT REMOVE THIS LINE
				
	}

	public function getProfile() {			

		$this->button_addmore = FALSE;
		$this->button_cancel  = FALSE;
		$this->button_show    = FALSE;			
		$this->button_add     = FALSE;
		$this->button_delete  = FALSE;	
		$this->hide_form 	  = ['id_cms_privileges'];

		$data['page_title'] = trans("crudbooster.label_button_profile");
		$data['row']        = CRUDBooster::first('cms_users',CRUDBooster::myId());

		$this->cbView('crudbooster::default.form',$data);				
	}

    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate data input before add data is execute
	    | ----------------------------------------------------------------------
	    | @arr
	    |
	    */
    public function hook_before_add(&$postdata) {
        //Your code here
        if($postdata['date_birthday'] == '') {
            $postdata['date_birthday'] = null;
        }

    }

    /*
        | ----------------------------------------------------------------------
        | Hook for manipulate data input before update data is execute
        | ----------------------------------------------------------------------
        | @postdata = input post data
        | @id       = current id
        |
        */
    public function hook_before_edit(&$postdata,$id) {
        if($postdata['date_birthday'] == '') {
            $postdata['date_birthday'] = null;
        }
    }

    public function getDelete($id) {
        $data = [];
        $data['users'] = DB::table('cms_users')->where('id', '!=', $id)->get();
        $data['id'] = $id;

        $this->cbView('leads.delete_user',$data);
    }

    public function getAssignto(\Illuminate\Http\Request $request) {
        $id = $request->get('original_user');
        $assignto= (int)$request->get('assignto');

        $leads = DB::table('account')->where('id_usuario', $id)->get();
        $clients = DB::table('clients')->where('id_usuario', $id)->get();

        foreach ($leads as $lead) {
            DB::table('account')->where('id', $lead->id)->update(['id_usuario'=> $assignto]);
        }

        foreach ($clients as $client) {
            DB::table('clients')->where('id', $client->id)->update(['id_usuario'=> $assignto]);
        }

        //delete user
        DB::table('cms_users')->where('id', $id)->delete();

        CRUDBooster::redirect(CRUDBooster::adminPath("users"),trans('crudbooster.assigned_leads'));
    }

}
