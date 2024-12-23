<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::all();

        /* 

        if(!empty($authors)) {
            return Response::json(['data' => $authors], 201);
        }
        
        else {
            return Response::json(['message' => 'No Record Found'], 404);
        }
        
        */



        if ($authors->isEmpty()) {
            return Response::json(['message' => 'No Record Found'], 404);
        } else {
            return Response::json(['data' => $authors], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = array();
        $data['author_name'] = $request->author_name;
        $data['author_contact_no'] = $request->author_contact_no;
        $data['author_country'] = $request->author_country;
        $data['created_at'] = Carbon::now();

        $rules = array (
            'author_name' => 'required',
            'author_contact_no' => 'required',
            'author_country' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {

            return $validator->errors();

        } else {

            $author = Author::create($data);
        
            if($author) {
                return Response::json(['message' => "New Author has been created successfully"], 200);
            }
            
            else {
                return Response::json(['message' => 'Something went wrong'], 404);
            }

        }

        
    }

    /**
     * Display the specified resource.
     */

     public function show($id)
     {
         $author = Author::find($id);
     
         if ($author) {
             return Response::json(['data' => $author], 200);
         } else {
             return Response::json(['message' => 'No Record Found'], 404);
         }
     }




  //  public function show(Author $author)
   // {
   //     $authorr = Author::find($author->id);
      /*
        if ($authorr !== null) {
            return Response::json(['data' => $authorr], 200);
        } else {
            return Response::json(['message' => 'No Record Found'], 404);
        }
      */

      /*
        if(!empty($authorr)) {
            return Response::json(['data' => $authorr], 200);
        } else {
            return Response::json(['message' => 'No Record Found'], 404);
        }

      /*

     //   if ($authorr) {
      //      return Response::json(['data' => $authorr], 200);
      //  } else {
      //      return Response::json(['message' => 'No Record Found'], 404);
      //  }
    //}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
       // $data = array();
       // $data['author_name'] = $request->author_name;
        //$data['author_contact_no'] = $request->author_contact_no;
        //$data['author_country'] = $request->author_country;
        //$data['updated_at'] = Carbon::now();

        $aut = Author::find($author->id);
        $aut->update($request->all());
       // $aut = Author::where('id', $author->id)->update($data);
        
        if($aut) {
            return Response::json(['message' => "Author Id {$author->id} data has been updated successfully"], 200);
        }
        
        else {
            return Response::json(['message' => 'Something went wrong'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        
        $aut = Author::where('id', $author->id)->delete();
        
        if($aut) {
            return Response::json(['message' => "Author Id {$author->id} has been deleted successfully"], 200);
        }
        
        else {
            return Response::json(['message' => 'Something went wrong'], 404);
        }
    }

    public function search($term) {

        $authors = Author::where('author_name', 'LIKE', '%' . $term . '%')->get();
        //$authors = Author::where('author_name', $term)->get();

       
        //$authors = Author::where('author_name', '=', trim($term))->get();

        if ($authors->isNotEmpty()) {
            return Response::json(['data' => $authors], 200);
        } else {
            return Response::json(['message' => 'No Record Found'], 404);
        }           
          

    }
}
