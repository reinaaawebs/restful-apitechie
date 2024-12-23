<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('author')->get();

        /* 

        if(!empty($authors)) {
            return Response::json(['data' => $authors], 201);
        }
        
        else {
            return Response::json(['message' => 'No Record Found'], 404);
        }
        
        */



        if ($books->isEmpty()) {
            return Response::json(['message' => 'No Record Found'], 404);
        } else {
            return Response::json(['data' => $books], 200);
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
        $data['book_title'] = $request->book_title;
        $data['book_isbn'] = $request->book_isbn;
        $data['book_price'] = $request->book_price;
        $data['book_publish_year'] = $request->book_publish_year;
        $data['author_id'] = $request->author_id;
        $data['created_at'] = Carbon::now();

        $rules = array (
            'book_title' => 'required',
            'book_isbn' => 'required',
            'book_price' => 'required',
            'book_publish_year' => 'required',
            'author_id' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {

            return $validator->errors();

        } else {

            $book = Book::create($data);
        
            if($book) {
                return Response::json(['message' => "New Book has been created successfully"], 200);
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
         //$bok = Book::find($id);
         $bok = Book::with('author')->find($id);
        

     
         if ($bok) {
             return Response::json(['data' => $bok], 200);
         } else {
             return Response::json(['message' => 'No Record Found'], 404);
         }
     }




  //  public function show(Book $book)
   // {
   //     $bok = Book::find($book->id);
      /*
        if ($bok !== null) {
            return Response::json(['data' => $bok], 200);
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
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
       // $data = array();
       // $data['author_name'] = $request->author_name;
        //$data['author_contact_no'] = $request->author_contact_no;
        //$data['author_country'] = $request->author_country;
        //$data['updated_at'] = Carbon::now();

        $bok = Book::find($book->id);
        $bok->update($request->all());
       // $aut = Author::where('id', $author->id)->update($data);
        
        if($bok) {
            return Response::json(['message' => "Book data has been updated successfully"], 200);
        }
        
        else {
            return Response::json(['message' => 'Something went wrong'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {   
        
        $bok = Book::where('id', $book->id)->delete();
        
        if($bok) {
            return Response::json(['message' => "Book has been deleted successfully"], 200);
        }
        
        else {
            return Response::json(['message' => 'Something went wrong'], 404);
        }
    }
}
