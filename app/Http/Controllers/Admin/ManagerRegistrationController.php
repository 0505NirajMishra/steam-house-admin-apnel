<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\ManagerRequest;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Services\ManagerUserService;
use App\Services\UserService;
use App\Services\FileService;
use App\Services\ManagerLanguageService;
use App\Services\UtilityService;
// use App\Services\UserIntrestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Log;



class ManagerRegistrationController extends Controller
{
    protected $mls, $change_password, $assign_role, $uploads_image_directory;
    protected $index_view, $create_view, $edit_view, $detail_view, $tabe_view, $product_history_view;
    protected $index_route_name, $create_route_name, $detail_route_name, $edit_route_name;
    protected $bookService, $utilityService, $intrestService;

    public function __construct()
    {

        //Data
        $this->uploads_image_directory = 'files/managerregistrations';
        //route
        $this->index_route_name  = 'admin.managerregistrations.index';
        $this->create_route_name = 'admin.managerregistrations.create';
        $this->detail_route_name = 'admin.managerregistrations.show';
        $this->edit_route_name   = 'admin.managerregistrations.edit';

        //view files
        $this->index_view  = 'admin.managerfolder.index';
        $this->create_view = 'admin.managerfolder.create';
        $this->edit_view   = 'admin.managerfolder.edit';

        $this->detail_view = 'admin.managerfolder.details';
        $this->tabe_view   = 'admin.managerfolder.profile';


        //service files
        $this->user = new ManagerUserService();
        // $this->intrestService = new UserIntrestService();
        $this->utilityService = new UtilityService();

        //mls is used for manage language content based on keys in messages.php
        $this->mls = new ManagerLanguageService('messages');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $items = $this->user->datatable();

        if (!empty($request['search'])) {

            $items=UserService::user_search($request);

            if(count($items)>0){

                return view('admin.managerfolder.index',['user'=>$items,'search'=>$request->search]);
            }
                return redirect()->back()->withSuccess('Search Data Not Found');
        }
        return view('admin.managerfolder.index',['user'=>$items,'search'=>$request->search]);
    }


    public function create(Request $request)
    {

        // $manager=user::where('role','1')->get();
        $location = DB::table('location')->get();
        return view($this->create_view, compact('location'));
        // return view($this->create_view);

    }

    public function store(ManagerRequest $request)
    {

        $input = $request->except(['_token', 'proengsoft_jsvalidation']);

        if(!empty($input['image'])){
            $manager_image=$request->file('image');
            $picture=FileService::fileUploaderWithoutRequest($manager_image,'managerregistrations/image/');
            $input['image']= $picture;

        }
        $haspassword=Hash::make($request->password);
                        $input['password']=$haspassword;
        $battle = $this->user->create($input);
        return redirect()->route($this->index_route_name)->with('success',
        $this->mls->messageLanguage('created', 'manager', 1));

    }


    public function show(User $user)
    {
        return view($this->detail_view,compact('user'));
    }


    public function edit($id)
    {



        $manager=User::where('role','1')->where('id',$id)->first();
       $image=$manager->image;
        $location = DB::table('location')->get();

        return view($this->edit_view,compact('manager','image','location'));
    }


    public function update(Request $request,User $user)
    {

        $input = $request->except(['_method', '_token', 'proengsoft_jsvalidation']);

        if(!empty($input['image']))
            {
                $manager_image=$request->file('image');
                $picture=FileService::fileUploaderWithoutRequest($manager_image,'managerregistrations/image/');
                $input['image']= $picture;
        }

        if($input['password']!='' || $input['c_password']!='')
        {
            $input['password']=Hash::make($request->password);
            $input['c_password']=Hash::make($request->c_password);
        }

        $this->user->update($input,$user);
        return redirect()->route($this->index_route_name)->with('success',$this->mls->messageLanguage('updated', 'manager', 1));

    }

    public function destroy($id)
    {

        $result=UserService::delete_user($id);

        return redirect()->back()->withSuccess('Data Delete Successfully!');

    }


    public function locationdata($id){

        $data=DB::table('users')->select('*','users.id as id')->join('location','location.location_id','=','users.address')->
        join('service_request','service_request.user_id','=','users.id')->where('users.id',$id)->first();
        $manager=DB::table('users')->select('name','id')->where('id',$data->manager_id)->first();
        return $manager->name;

    }



    // public function livedata(Request $request){

    //     try {

    //         $livedata= Http::get('http://122.187.205.206:5008/api/Values/GetAllData?key=steam8108');

    //         print_r($livedata);
    //         die;
    //         $input = [

    //             'livedata'=>$livedata,
    //             'created_at' => Carbon::now(),
    //             'updated_at' => Carbon::now()
    //         ];

    //             $updatedata=DB::table('livedata')->where('id',1)->update($input);

    //     } catch (exception $e) {

    //         return response()->json('error', $e);

    //     }


    // }






}
