<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->query("limit",10);
        $offset = ($request->query("page",1) - 1) * $limit;

        $categories = DB::table('categories')->selectRaw('*')->limit($limit)->offset($offset)->get();
        
        $paginate = DB::table('categories')->select(DB::raw('COUNT(*) AS numberOfPages'))->get();
        $paginate[0]->numberOfPages = ceil($paginate[0]->numberOfPages/$request->query("limit",10));
      
        $data = new \stdClass();
        $data->info = $paginate[0];
        $data->result = $categories;
        return response()->json($data, 200);
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
        if(DB::table('categories')->insert($request->all())){
            return response()->json("Category has been created",201);
        }
        else{
            return response()->json("Can not create");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update($catid, Request $request)
    {
        if(DB::table('categories')->where('id',$catid)->update($request->all())){
            $category = DB::table('categories')->find($catid);
            return response()->json($category,200);
        }
        else{
            return response()->json("Can not update");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($catid)
    {
        if(DB::table('categories')->where('id', $catid)->delete()){
            return response()->json("Category has been deleted",200);
        }
        else{
            return response()->json("Can not delete");
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  number  $id
     * @return \Illuminate\Http\Response
     */
    public function getCategory($catid)
    {
        $category = DB::table('categories')->selectRaw('*')->whereRaw('id = ?',[$catid])->get();
        
        return response()->json($category[0], 200);
    }

    /**
     * Display the resource by category.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function searchCategory($keyword, Request $request)
    {
        $limit = $request->query("limit",10);
        $offset = ($request->query("page",1) - 1) * $limit;

        $categories = DB::table('categories')->selectRaw('*')
        ->whereRaw('name like "%'.$keyword.'%"')->limit($limit)->offset($offset)->get();

        $paginate = DB::table('categories')->select(DB::raw('COUNT(*) AS numberOfPages'))
        ->whereRaw('name like "%'.$keyword.'%"')->get();
        $paginate[0]->numberOfPages = ceil($paginate[0]->numberOfPages/$request->query("limit",10));
      
        $data = new \stdClass();
        $data->info = $paginate[0];
        $data->result = $categories;
        return response()->json($data, 200);
    }
}
