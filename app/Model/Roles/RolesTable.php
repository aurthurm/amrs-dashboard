<?php

namespace App\Model\Roles;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\RolesService;
use Illuminate\Support\Facades\File;

class RolesTable extends Model
{
    //
    protected $table = 'roles';
    public function saveRoles($request)
    {
        //to get all request values
        $data = $request->all();
        if ($request->input('roleName')!=null && trim($request->input('roleName')) != '') {
            $id = DB::table('roles')->insertGetId(
                ['role_name' => $data['roleName'],
                'role_code' => $data['roleCode'],
                'role_description' => $data['description'],
                'role_status' => $data['status'],
                ]
            );
        }
        return $id;
    }

    // Fetch All Roles List
    public function fetchAllRole()
    {
        $data = DB::table('roles')
                ->get()
                ;
        return $data;
    }

     // fetch particular roles details
     public function fetchRolesById($id)
     {
         $id = base64_decode($id);
         $data = DB::table('roles')
                 ->where('role_id', '=',$id )->get();
         return $data;
     }
 
     // Update particular roles details
     public function updateRoles($params,$id)
     {
         $data = $params->all();
         if ($params->input('roleName')!=null && trim($params->input('roleName')) != '') {
             $response = DB::table('roles')
                 ->where('role_id', '=',base64_decode($id))
                 ->update(
                    ['role_name' => $data['roleName'],
                    'role_code' => $data['roleCode'],
                    'role_description' => $data['description'],
                    'role_status' => $data['status'],
                    ]);
         }
         return 1;
     }
      //fetch all resource
      public function fetchAllResource(){
        $resourceResult = DB::table('resources')->orderBy('display_name','asc')->get();
        $count = count($resourceResult);
        for ($i = 0; $i < $count; $i++) {
            $resourceResult[$i]->privilege = DB::table('privileges')
                                            ->where('resource_id', '=',$resourceResult[$i]->resource_id)
                                            ->orderBy('display_name','asc')->get();
        }
        return $resourceResult;
   }

   //Role Save in Acl File
   public function mapRolePrivilege($params) {
    // dd($params->all());
    try {
            $roleCode=$params['roleCode'];
            $configFile =  "acl.config.json";
            if(file_exists(getcwd() . DIRECTORY_SEPARATOR . $configFile))
            {
                if(!is_writable(getcwd() . DIRECTORY_SEPARATOR . $configFile))
                    chmod (getcwd() . DIRECTORY_SEPARATOR . $configFile , 0755 );
                $config = json_decode(File::get( getcwd() . DIRECTORY_SEPARATOR . $configFile),true);
            }
            else
                $config = array();
                $config[$roleCode] = array();
            if(isset($params['resource']) && $params['resource']!='' && $params['resource']!=null){
                foreach ($params['resource'] as $resourceName => $privilege) {
                    $config[$roleCode][$resourceName] = $privilege;
                }
            }
            if (!is_writable(getcwd() . DIRECTORY_SEPARATOR . $configFile))
                chmod(getcwd() . DIRECTORY_SEPARATOR . $configFile, 0755);
            File::put( getcwd() . DIRECTORY_SEPARATOR . $configFile, json_encode($config));
            
        } catch (Exception $exc) {
    
            error_log($exc->getMessage());
            error_log($exc->getTraceAsString());
       }
    }
}
