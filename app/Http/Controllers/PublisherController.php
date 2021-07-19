<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publisher;
use App\Http\Requests\PublisherRequest;
use App\Repositories\RepositoryInterface\PublisherRepositoryInterface;

class PublisherController extends Controller
{
    public function __construct(PublisherRepositoryInterface $publisherRepository)
    {
        $this->publisherRepository = $publisherRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publishers = $this->publisherRepository->getLatest();

        return view('admin.publishers.index', compact('publishers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.publishers.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PublisherRequest $request)
    {
        $this->publisherRepository->create($request->all());

        return redirect()->route('publishers.index')->with('add_success', trans('message.add_success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($pub_id)
    {
        $publisher = $this->publisherRepository->find($pub_id);

        return view('admin.publishers.edit', compact('publisher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PublisherRequest $request, $pub_id)
    {
        $this->publisherRepository->update($pub_id, $request->all());

        return redirect()->route('publishers.index')->with('update_success', trans('message.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($pub_id)
    {
        $this->publisherRepository->delete($pub_id);

        return redirect()->route('publishers.index')->with('del_success', trans('message.del_success'));
    }
}
