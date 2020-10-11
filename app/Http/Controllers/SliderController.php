<?php

namespace App\Http\Controllers;

use App\Slider;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Yajra\Datatables\Datatables;
use Symfony\Component\HttpFoundation\Response;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $slider = Slider::all();
            return Datatables::of($slider)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-outline-danger btn-round waves-effect waves-light name="delete" id="' . $data->id . '" onclick="sliderdelete(\'' . $data->id . '\')"><i class="icon-trash"></i></a>&nbsp;&nbsp;<a class="btn btn-outline-warning btn-round waves-effect waves-light name="edit" href="' . route('slider.edit', $data->id) . '" id="' . $data->id . '" ><i class="ti-pencil"></i></a>';
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.slider.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'main_image' => 'required|mimes:jpeg,png,jpg|max:4048'
        ];
        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response(['errors' => $error->errors()->all()], Response::HTTP_OK);
        }

        $slider = new Slider();

        $imgdestination = '/SliderImages';
        if ($request->hasfile('main_image')) {
            // foreach ($request->file('upl') as $image) {
            $sliderimages = $request->file('main_image');
            $imgname = $this->generateUniqueFileName($sliderimages, $imgdestination);
            $slider->image_path = $imgname;
        }

        $slider->title = $request->title;
        $slider->description = $request->description;
        if ($slider->save()) {
            return response([
                'success' => 'Slider Added Succesfully',
            ], Response::HTTP_OK);
        } else {
            return response([
                'warning' => 'Slider not added ',
            ], Response::HTTP_OK);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SLider  $sLider
     * @return \Illuminate\Http\Response
     */
    public function show(SLider $sLider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SLider  $sLider
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $sliders = Slider::where('id', $id)->get();


        return view('admin.slider.edit', compact('sliders'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SLider  $sLider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'main_image' => 'mimes:jpeg,png,jpg|max:4048'
        ];
        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response(['errors' => $error->errors()->all()], Response::HTTP_OK);
        }

        $slider = Slider::find($id);

        $imgdestination = '/SliderImages';
        if ($request->hasfile('main_image')) {
            // foreach ($request->file('upl') as $image) {
            $sliderimages = $request->file('main_image');
            $imgname = $this->generateUniqueFileName($sliderimages, $imgdestination);
            $slider->image_path = $imgname;
        }
        $slider->title = $request->title;
        $slider->description = $request->description;
        if ($slider->update()) {
            return response(['success' => 'Slider updated succesfully'
            ], Response::HTTP_OK);
        } else {
            return response(['warning' => 'Slider not updated',
            ], Response::HTTP_OK);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SLider  $sLider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $slider_id = $request->slider_id;
            $slider = Slider::find($slider_id);
            if ($slider) {
                $slider->delete();
                return response([
                    'success' => false,
                    'message' => 'Slider  deleted Succesfully',
                ], Response::HTTP_OK);
            } else {
                return response([
                    'success' => True,
                    'message' => 'Slider  not deleted',
                ], Response::HTTP_OK);
            }
        }
    }


    public function generateUniqueFileName($image, $destinationPath)
    {
        $initial = "Macrolan";
        $random = Str::random();
        $name = $initial  . $random . time() . '.' . $image->getClientOriginalExtension();
        if ($image->move(public_path() . $destinationPath, $name)) {
            return $name;
        } else {
            return null;
        }
    }

}
