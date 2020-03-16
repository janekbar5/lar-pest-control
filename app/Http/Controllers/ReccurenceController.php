<?php

namespace App\Http\Controllers;

use App\Reccurence;
use Illuminate\Http\Request;
use App\Repositories\ValidationRepository;
use App\Repositories\Interfaces\BackendRepositoryInterface;


class ReccurenceController extends Controller
{
    function __construct(ValidationRepository $vr, BackendRepositoryInterface $br, ImageController $im)
    {       
        $this->middleware('permission:location-list');
        $this->middleware('permission:location-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:location-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:location-delete', ['only' => ['destroy']]); 
        $this->br = $br;
        $this->vr = $vr;
        $this->im = $im;
    } 
	
    public function index()
    {
        //$reccurences = $this->br->getReccurences();
		/* $reccurences = []
		foreach($this->br->getReccurences() as $row){
			reccurences$row = []
		} */
		$reccurences = array();
        foreach ($this->br->getReccurences()->toArray() as $row) {
            //$r = new \stdClass();
            $r['name'] = $row['title'];
            $r['value'] = $row['id'];            
            $reccurences[] = $r;
        }       
		
        return response()->json([
		'reccurences' => $reccurences,		
		]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reccurence  $reccurence
     * @return \Illuminate\Http\Response
     */
    public function show(Reccurence $reccurence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reccurence  $reccurence
     * @return \Illuminate\Http\Response
     */
    public function edit(Reccurence $reccurence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reccurence  $reccurence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reccurence $reccurence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reccurence  $reccurence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reccurence $reccurence)
    {
        //
    }
}
