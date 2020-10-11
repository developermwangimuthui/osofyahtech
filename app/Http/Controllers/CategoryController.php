<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $category = Category::all();
            return Datatables::of($category)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-outline-danger btn-round waves-effect waves-light name="delete" id="' . $data->id . '" onclick="categorydelete(\'' . $data->id . '\')"><i class="icon-trash"></i></a>&nbsp;&nbsp;
                    <a class="btn btn-outline-warning btn-round waves-effect waves-light name="edit" href="' . route('category.edit', $data->id) . '" id="' . $data->id . '" ><i class="ti-pencil"></i></a>
                    
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.category.index');
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
        if ($request->ajax()) {
            $category = new Category();
            $category->category = $request->category;
            if ($request->hasfile('image_path')) {
                $imgdestination = '/CategoryImages';
                $image = $request->file('image_path');
                $category->image_path = $this->generateUniqueFileName($image, $imgdestination);
            }
            if ($category->save()) {
                return response([
                    'success' => True,
                    'message' => 'Category  created Succesfully',
                ], Response::HTTP_OK);
            } else {
                return response([
                    'error' => True,
                    'message' => 'category not created',
                ], Response::HTTP_OK);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $categories = Category::where('id', $id)->get();


        return view('admin.category.edit', compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->category = $request->category;
        if ($request->hasfile('image_path')) {
            $imgdestination = '/CategoryImages';
            $image = $request->file('image_path');
            $category->image_path = $this->generateUniqueFileName($image, $imgdestination);
        }
        if ($category->update()) {
            return response([
                'success' => True,
                'message' => 'Category  updated Succesfully',
            ], Response::HTTP_OK);
        } else {
            return response([
                'success' => True,
                'message' => 'Category  failed to update',
            ], Response::HTTP_OK);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $category_id = $request->category_id;
            $category = Category::find($category_id);
            if ($category) {
                $category->delete();
                return response([
                    'success' => True,
                    'message' => 'Category  deleted Succesfully',
                ], Response::HTTP_OK);
            } else {
                return response([
                    'success' => True,
                    'message' => 'Category  not deleted',
                ], Response::HTTP_OK);
            }
        }
    }

    public function generateUniqueFileName($image, $destinationPath)
    {
        $initial = "musicfile_";
        $name = $initial  . bin2hex(random_bytes(8)) . '.' . $image->getClientOriginalExtension();
        if ($image->move(public_path() . $destinationPath, $name)) {
            return $name;
        } else {
            return null;
        }
    }
}
