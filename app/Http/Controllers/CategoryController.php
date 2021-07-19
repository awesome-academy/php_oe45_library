<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Components\Recusive;
use App\Http\Requests\CategoryRequest;
use App\Repositories\RepositoryInterface\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
        
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->getLatest();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getCategory($parentID)
    {
        $data = $this->categoryRepository->getAll();
        $recusive = new Recusive($data);
        $htmlOption = $recusive->categoryRecusive($parentID);

        return $htmlOption;
    }

    public function create()
    {
        $htmlOption = $this->getCategory($parentID = '');
        
        return view('admin.categories.add', compact('htmlOption'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $this->categoryRepository->create($request->all());

        return redirect()->route('categories.index')->with('add_success', trans('message.add_success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($cate_id)
    {
        $category = $this->categoryRepository->find($cate_id);
        $htmlOption = $this->getCategory($category->parent_id);

        return view('admin.categories.edit', compact('category', 'htmlOption'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $cate_id)
    {
        $this->categoryRepository->update($cate_id, $request->all());

        return redirect()->route('categories.index')->with('update_success', trans('message.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cate_id)
    {
        $this->categoryRepository->delete($cate_id);

        return redirect()->route('categories.index')->with('del_success', trans('message.del_success'));
    }
}
