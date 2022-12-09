<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(){
        /*$books = Libro::with('category','autores', 'editorial')->get();
        return[
            "error"=>false,
            "error"=>"Successful",
            "data"=> $books
        ];*/
        $books = Libro::orderBy('title', 'asc')->get();
        return $this->getResponse200($books);
    }

    public function response(){
        return[
            "error"=> true,
            "message" => "Wrong Action",
            "data" => []
        ];
    }

    public function store(Request $request){
        $response = $this->response();
        $isbn = trim($request->isbn);
        $exitsIsbn = Libro::where('isbn',trim($request))->exists();
        if($exitsIsbn){
            $libro = new Libro();
            $libro->isbn = $isbn;
            $libro->title = $request->title;
            $libro->description = $request->description;
            $libro->published_date = Carbon::now();
            $libro->category_id  = $request->category["id"];
            $libro->editorial_id  = $request->editorial_id;
            $libro->save();
            foreach($request->autores as $item){
                $libro->autors()->attach($item);
            }
            $response["error"] = false;
            $response["message"] = "your book has been created";
            $response["data"] = $libro;
        }else{
            $response["message"] = "ISBN duplicated";
        }
        return $response;
    }

    public function update(Request $request,$id){
        $response = $this->response();
        $libro = Libro::Find($id);

        DB::beginTransaction();
        try{

            if($libro){
                $isbn = trim($request->isbn);
                $isbnOwner = Libro::where('isbn',$isbn)->first();
                if(!$isbnOwner || $isbnOwner->id == $libro->id){
                    $libro->isbn = $isbn;
                    $libro->title = $request->title;
                    $libro->description = $request->description;
                    $libro->published_date = Carbon::now();
                    $libro->category_id  = $request->category["id"];
                    $libro->editorial_id  = $request->editorial_id;
                    $libro->update();
                    //delete
                    foreach($libro->autores as $item){
                        $libro->autores()->detach($item->id);
                    }
                    //add new authors
                    foreach($request->autores as $item){
                        $libro->autores()->atach($item->id);
                    }
                    $books = Libro::with('category','autores', 'editorial')->where("id",$id)->get();
                    $response["error"] = false;
                    $response["message"] = "your book has been updated";
                    $response["data"] = $libro;
                }else{
                    $response["message"] = "ISBN duplicated!";
                }
            }else{
                $response["message"] = "Not found";
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
        return $response;
    }
}
