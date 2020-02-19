<?php

namespace App\Http\Controllers;

use App\History;
use Illuminate\Http\Request;
use App\Repositories\ValidationRepository;
use App\Repositories\Interfaces\BackendRepositoryInterface;


class HistoryController extends Controller
{
    function __construct(ValidationRepository $vr, BackendRepositoryInterface $br, ImageController $im)
    {       
        $this->middleware('permission:history-list');
        $this->middleware('permission:history-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:history-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:history-delete', ['only' => ['destroy']]); 
        $this->br = $br;
        $this->vr = $vr;
        $this->im = $im;
    }    
    /**/////////////////////////////////////////////////////////////////////////////////////////////1 INDEX
    public function index()
    {       
        //$users = $this->br->getHistory(); 
		$users = History::all();
        return response()->json([
		'rows' => $users
		]);
    }
}
