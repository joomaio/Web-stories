<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
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

        $data = new \stdClass();
        if($limit == 0){
            $books = DB::table('books')->selectRaw('*')->orderByRaw('id DESC')->get();
        
            $paginate = new \stdClass();
            $paginate->numberOfPages = 1;

            $data->info = $paginate;
            $data->result = $books;
        }else{
            $books = DB::table('books')->selectRaw('*')->orderByRaw('id DESC')->limit($limit)->offset($offset)->get();
        
            $paginate = DB::table('books')->select(DB::raw('COUNT(*) AS numberOfPages'))->get();
            $paginate[0]->numberOfPages = ceil($paginate[0]->numberOfPages/$request->query("limit",10));
            
            $data->info = $paginate[0];
            $data->result = $books;
        }
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
        $req = $request->all();
        
        if(DB::table('books')->insert($request->all())){
            return response()->json("Book has been created",201);
        }
        else{
            return response()->json("Can not create");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  number  $id
     * @return \Illuminate\Http\Response
     */
    public function getBook($id)
    {
        $book = DB::table('books')->selectRaw('*')->whereRaw('id = ?',[$id])->get();
        
        return response()->json($book[0], 200);
    }
    
    /**
     * Display the resource by category.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function getBooksByCat($catid, Request $request)
    {
        $limit = $request->query("limit",10);
        $offset = ($request->query("page",1) - 1) * $limit;

        $books = DB::table('books')
        ->join('book_of_category', 'books.id', '=', 'book_of_category.id_book')
        ->join('categories', 'categories.id', '=', 'book_of_category.id_cat')
        ->select('books.*', 'categories.name AS catname')->whereRaw('book_of_category.id_cat='.$catid)->orderBy('books.name','DESC')
        ->limit($limit)->offset($offset)->get();

        $paginate = DB::table('books')
        ->join('book_of_category', 'books.id', '=', 'book_of_category.id_book')
        ->select(DB::raw('COUNT(*) AS numberOfPages'))->whereRaw('book_of_category.id_cat='.$catid)->get();
        
        $paginate[0]->numberOfPages = ceil($paginate[0]->numberOfPages/$request->query("limit",10));
      
        $data = new \stdClass();
        $data->info = $paginate[0];
        $data->result = $books;
        
        return response()->json($data, 200);
    }

    /**
     * Display the resource by category.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function searchBook($keyword, Request $request)
    {
        $limit = $request->query("limit",10);
        $offset = ($request->query("page",1) - 1) * $limit;

        $joinCat = $request->query("cat") ? ' JOIN `book_of_category` ON `book_of_category`.id_book=`books`.id':'';
        $cat = $request->query("cat") ? ' AND `book_of_category`.id_cat='.$request->query("cat"):'';
        $from = $request->query("from") ? ' AND `books`.created_time >="'.$request->query("from").' 00:00:00"':'';
        $to = $request->query("to") ? ' AND `books`.created_time <="'.$request->query("to").' 23:59:59"':'';

        $books = \DB::select('SELECT * FROM `books`'.$joinCat.' WHERE `books`.name like "%'.$keyword.'%"'.$cat.$from.$to.' LIMIT '.$limit.' OFFSET '.$offset);

        $paginate = \DB::select('SELECT count(*) as numberOfPages FROM `books`'.$joinCat.' WHERE `books`.name like "%'.$keyword.'%"'.$cat.$from.$to);
        $paginate[0]->numberOfPages = ceil($paginate[0]->numberOfPages/$request->query("limit",10));
      
        $data = new \stdClass();
        $data->info = collect($paginate[0]);
        $data->result = collect($books);
        
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
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
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        if(DB::table('books')->where('id',$id)->update($request->all())){
            $book = DB::table('books')->find($id);
            return response()->json($book,200);
        }
        else{
            return response()->json("Can not update");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(DB::table('books')->where('id', $id)->delete()){
            return response()->json("Book has been deleted",200);
        }
        else{
            return response()->json("Can not delete");
        }
    }
}
