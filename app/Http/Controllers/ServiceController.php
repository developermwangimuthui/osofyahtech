<?php

namespace App\Http\Controllers;

use App\Service;
use App\ServicePhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Yajra\Datatables\Datatables;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $service = Service::all();
            return Datatables::of($service)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-outline-danger btn-round waves-effect waves-light name="delete" id="' . $data->id . '" onclick="servicedelete(\''. $data->id . '\')"><i class="icon-trash"></i></a>&nbsp;&nbsp;<a class="btn btn-outline-warning btn-round waves-effect waves-light name="edit" href="' . route('service.edit', $data->id) . '" id="' . $data->id . '" ><i class="ti-pencil"></i></a>';
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.service.index');
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
            'service' => 'required',
            'description' => 'required',
            'main_image' => 'required|mimes:jpeg,png,jpg|max:4048',

        ];
        $error = Validator::make($request->all(), $rules);

            if ($error->fails()) {
                return response(['errors' => $error->errors()->all(),
                ], Response::HTTP_OK);
            }

        $imgdestination = '/ServiceImages';
        $gallerarray = [];
        if ($request->hasfile('main_image')) {
            // foreach ($request->file('upl') as $image) {
            $serviceimages = $request->file('main_image');
            $imgname = $this->generateUniqueFileName($serviceimages, $imgdestination);
        }

        // dd($request->file('gallery'));
        if ($request->hasfile('gallery')) {

            foreach ($request->file('gallery') as $image) {
                $galleryname = $this->generateUniqueFileName($image, $imgdestination);
                $gallerarray[] = $galleryname;
            }
        }

        $service = new Service();
        $service->service = $request->service;
        $service->description = $request->description;
        if ($service->save()) {

            $service_id = $service->id;
            $service_image = new ServicePhoto();
            $service_image->service_id = $service_id;
            $service_image->image_path = $imgname;
            $service_image->type = "main_image";
            $service_image->save();

            foreach ($gallerarray as $img) {
                $service_image = new ServicePhoto();
                $service_image->service_id = $service_id;
                $service_image->image_path = $img;
                $service_image->type = "gallery";
                $service_image->save();
            }
            return response(['success' => 'Service Added Successfully',
            ], Response::HTTP_CREATED);
        }
    }

    public function generateUniqueFileName($image, $destinationPath)
    {
        $initial = "Macrolan";
        $random = Str::random();
        $name = $initial . $random . time() . '.' . $image->getClientOriginalExtension();
        if ($image->move(public_path() . $destinationPath, $name)) {
            return $name;
        } else {
            return null;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $services = Service::where('id', $id)->get();
        $photos = ServicePhoto::where('service_id', $id)->get();

        return view('admin.service.edit', compact('services', 'photos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'service' => 'required',
            'description' => 'required',

        ];

        $error = Validator::make($request->all(), $rules);

            if ($error->fails()) {
                return response(['errors' => $error->errors()->all(),
                ], Response::HTTP_OK);
            }

        $imgdestination = '/ServiceImages';
        $gallerarray = [];
        if ($request->hasfile('main_image')) {
            $productimages = $request->file('main_image');
            $imgname = $this->generateUniqueFileName($productimages, $imgdestination);
            $service_image = new ServicePhoto();
            $service_image->service_id = $id;
            $service_image->image_path = $imgname;
            $service_image->type = "main_image";
            $service_image->save();
        }
        if ($request->hasfile('gallery')) {

            foreach ($request->file('gallery') as $image) {
                $galleryname = $this->generateUniqueFileName($image, $imgdestination);
                $gallerarray[] = $galleryname;
            }

            foreach ($gallerarray as $img) {
                $service_image = new ServicePhoto();
                $service_image->service_id = $id;
                $service_image->image_path = $img;
                $service_image->type = "gallery";
                $service_image->save();
            }

        }
        Service::where('id', $id)->update([
            'service' => $request->service,
            'description' => $request->description,
        ]);
        return response(['success' => 'Product Updated Succesfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $service_id = $request->service_id;
            $service = Service::find($service_id);
            if ($service) {
                $service->delete();
                return response(['success' => 'Service  deleted Succesfully',
                ], Response::HTTP_OK);
            } else {
                return response(['warning' => 'Service  not deleted',
                ], Response::HTTP_OK);
            }
        }
    }
    public function photoDestroy(Request $request)
    {
        $photo_id = $request->photo_id;
        if (ServicePhoto::where('id', $photo_id)->delete()) {
            return response(['success' => 'Photo  deleted Succesfully',
            ], Response::HTTP_OK);
        } else {
            return response(['warning' => 'Photo not deleted ',
            ], Response::HTTP_OK);
        }
    }
}
