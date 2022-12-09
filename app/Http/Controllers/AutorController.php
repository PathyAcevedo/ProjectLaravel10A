<?php

namespace App\Http\Controllers;
use App\Models\Autores;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class AutorController extends Controller
{
    public function index(){
        /*$books = Libro::with('category','autores', 'editorial')->get();
        return[
            "error"=>false,
            "error"=>"Successful",
            "data"=> $books
        ];*/
        $autor = Autores::orderBy('name', 'asc')->get();
        return $this->getResponse200($autor);
    }

    /*public function response(){
        return[
            "error"=> true,
            "message" => "Wrong Action",
            "data" => []
        ];
    }*/

    public function store(Request $request){
        $response = $this->response();

            $autor = new Autores();
            $autor->name = $request->name;
            $autor->paterno = $request->paterno;
            $autor->materno =$request->materno;
            $autor->save();

            return $this->getResponse201("autor","created",$autor);
    }

    public function update(Request $request,$id){
        $response = $this->response();
        $autor = Autores::Find($id);

        DB::beginTransaction();
        try{

            $autor->name = $request->name;
            $autor->paterno = $request->paterno;
            $autor->materno =$request->materno;
            $autor->update();

            DB::commit();
            return $this->getResponse201("autor","updated",$autor);
        }catch(Exception $e){
            DB::rollBack();
            return $this->getResponse500();
        }
    }



    public function destroy(Request $request,$id)
    {

        $autor = Autores::Find($id);
        if($autor){
            $autor->delete();
            return $this->getResponseDelete200("autor");
        }else{
            return $this->getResponse404();
        }
    }

    public function show($id){
        $autor = Autores::Find($id);
        if($autor){
            return $this->getResponse200("autor","showed",$autor);
        }else{
            return $this->getResponse404();
        }
    }
}
