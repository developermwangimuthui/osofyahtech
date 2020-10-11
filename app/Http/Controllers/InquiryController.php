<?php

namespace App\Http\Controllers;

use App\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Yajra\Datatables\Datatables;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $enquiries = Inquiry::orderBy('created_at', 'desc')->get();
            return Datatables::of($enquiries)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-outline-danger btn-round waves-effect waves-light name="delete" id="' . $data->id . '" onclick="enquirydelete(\''. $data->id . '\')"><i class="icon-trash"></i></a>';
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.enquiry.index');
    }

  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inquiry  $inquiry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $enquiry_id = $request->enquiry_id;
            $enquiry = Inquiry::find($enquiry_id);
            if ($enquiry) {
                $enquiry->delete();
                return response(['success' => 'Enquiry  deleted Succesfully',
                ], Response::HTTP_OK);
            } else {
                return response(['warning' => 'Enquiry  not deleted',
                ], Response::HTTP_OK);
            }
        }
    }
}
