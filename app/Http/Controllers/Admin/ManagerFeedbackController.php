<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\ManagerFeedbackRequest;
use Illuminate\Support\Facades\DB;
use App\Models\ManagerFeedbackModel;
use App\Services\ManagerFeedbackService;
use App\Services\FileService;
use App\Services\ManagerLanguageService;
use App\Services\UtilityService;
// use App\Services\UserIntrestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class ManagerFeedbackController extends Controller
{
    protected $mls, $change_password, $assign_role, $uploads_image_directory;
    protected $index_view, $create_view, $edit_view, $detail_view, $tabe_view, $product_history_view;
    protected $index_route_name, $create_route_name, $detail_route_name, $edit_route_name;
    protected $bookService, $utilityService, $intrestService;

    public function __construct()
    {

        //Data
        $this->uploads_image_directory = 'files/managerfeedbacks';

        //route

        $this->index_route_name  = 'admin.managerfeedbacks.index';
        $this->create_route_name = 'admin.managerfeedbacks.create';
        $this->detail_route_name = 'admin.managerfeedbacks.show';
        $this->edit_route_name   = 'admin.managerfeedbacks.edit';

        //view files

        $this->index_view  = 'admin.managerfeedbacksfolder.index';
        $this->create_view = 'admin.managerfeedbacksfolder.create';
        $this->edit_view   = 'admin.managerfeedbacksfolder.edit';




        //service files
        $this->managerfeedback = new ManagerFeedbackService();
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
        $items = $this->managerfeedback->datatable();

        if($request->ajax())
        {
            return view('admin.managerfeedbacksfolder.feedback_table',['managerfeedback'=>$items]);
        } else {
            return view('admin.managerfeedbacksfolder.index',['managerfeedback'=>$items]);
        }

    }


    public function create()
    {
        return view($this->create_view);
    }

    public function store(ManagerFeedbackRequest $request)
    {
        $input = $request->except(['_token', 'proengsoft_jsvalidation']);

        $battle = $this->managerfeedback->create($input);
        return redirect()->route($this->index_route_name)->with('success',
        $this->mls->messageLanguage('created', 'managerfeedback add', 1));
    }


    public function show(ManagerFeedbackModel $managerfeedback)
    {
        return view($this->detail_view,compact('managerfeedback'));
    }


    public function edit(ManagerFeedbackModel $managerfeedback)
    {
        return view($this->edit_view,compact('managerfeedback'));
    }


    public function update(ManagerFeedbackRequest $request, ManagerFeedbackModel $managerfeedback)
    {
        $input = $request->except(['_method', '_token', 'proengsoft_jsvalidation']);



        $this->managerfeedback->update($input,$managerfeedback);
        return redirect()->route($this->index_route_name)->with('success',
        $this->mls->messageLanguage('updated', 'managerfeedback update', 1));
    }

    public function destroy($id)
    {

        $result=DB::table('managerfeedback')->where('id', $id)->delete();

        return redirect()->back()->withSuccess('Data Delete Successfully!');

        if ($result) {
            return response()->json([
                'status' => 1,
                'title' => $this->mls->onlyNameLanguage('deleted_title'),
                'message' => $this->mls->onlyNameLanguage('managerfeedback delete'),
                'status_name' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'title' => $this->mls->onlyNameLanguage('deleted_title'),
                'message' => $this->mls->onlyNameLanguage('managerfeedback delete'),
                'status_name' => 'error'
            ]);
        }

    }





}
