<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticlesSaveRequest;
use App\Http\Requests\ArticlesUpdateRequest;
use App\Http\Requests\SaveImageRequest;
use App\Models\ArticleImages_M;
use App\Models\Articles_M;
use App\Traits\ImageProcessing;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;


class Articles_C extends Controller
{
    use ImageProcessing;

    /**********************************************/
    public function index()
    {
        return view('articles.articles_data');
    }

    /**********************************************/
    public function create()
    {
        return view('articles.articles_form');
    }

    /**********************************************/
    public function save(ArticlesSaveRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $data['title'] = $request->title;
                $data['body'] = $request->body;
                $article = Articles_M::create($data);
                //This function is used below in this controller
               $this->save_article_image($article->id);
            });

            $request->session()->flash('toastMessage', translate('file_added_successfully'));
            return redirect()->route('articles_data');

        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }


    }

    /***********************************************/
    public function get_ajax_data(Request $request)
    {
        if ($request->ajax()) {


            $data = Articles_M::withCount('images')->get();
            $counter = 0;

            return DataTables::of($data)
                ->addColumn('id', function () use (&$counter) {
                    $counter++;
                    return $counter;
                })
                ->addColumn('title', function ($row) {

                    return $row->title;
                })
                ->addColumn('body', function ($row) {
                    return strip_tags($row->body);
                })
                ->addColumn('images_count', function ($row) {
                    return $row->images_count;
                })
                ->addColumn('actions', function ($row) {
                    return '
<div class="btn-group">
    <button style="font-size: 16px" type="button" class="btn btn-sm btn-secondary">' . translate('actions') . '</button>
    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-icon" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu">

        <li><a  class="hover-effect dropdown-item" target="_blank" href="' . route('edit_article', $row->id) . '"><i class="bi bi-info-circle-fill"></i> ' . translate('edit') . '</a></li>
        <li><a  class="hover-effect dropdown-item" onclick="return confirm(\'Are You Sure To Delete?\')" href="' . route('delete_article', $row->id) . '"><i class="bi bi-trash-fill"></i> ' . translate('delete') . '</a></li>
        <li><a  class="hover-effect dropdown-item"  href="' . route('article_details', $row->id) . '"><i class="bi bi-info"></i> ' . translate('details') . '</a></li>


    </ul>
</div>';

                })->rawColumns(['actions'])
                ->make(true);

            return $dataTable->toJson();
        }
    }


    /************************************************/
    public function edit($id)
    {

        $data['article'] = Articles_M::findOrFail($id);
        $data['images'] = ArticleImages_M::where('article_id_fk', $id)->get();
      //  dd($data['images']);
        return view('articles.articles_edit', $data);
    }

    /**********************************************/
    public function update(ArticlesUpdateRequest $request, $id)
    {
        try {
            $article = Articles_M::find($id);
            $data['title'] = $request->title;
            $data['body'] = $request->body;
            //dd($data);
            $article->update($data);
            $request->session()->flash('toastMessage', translate('file_added_successfully'));
            return redirect()->route('articles_data');
        } catch (\Exception $e) {
            test($e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /************************************************/
    public function delete(Request $request, $id)
    {
        try {
            DB::transaction(function () use ($id) {
                $article = Articles_M::findOrFail($id);
                $article->images()->delete();
                $article->delete();
            });
            $request->session()->flash('toastMessage', translate('file_added_successfully'));
            return redirect()->route('articles_data');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**********************************************/
    public function delete_image(Request $request,$image_id,$article_id)
    {
        try {
            $image = ArticleImages_M::findOrFail($image_id);
            $image->delete();
            $request->session()->flash('toastMessage', translate('file_added_successfully'));
            return redirect()->route('edit_article',$article_id);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    /************************************************/
    public function save_article_image(SaveImageRequest $request,$article_id)
    {
        try {
            if ($request->hasFile('images')) {
                $files = $request->file('images');
                foreach ($files as $file) {
                    //this is function from trait take file and name conctenated with random name
                    $dataX = $this->saveFile($file, $article_id);
                    $data_image['image'] = $dataX;
                    $data_image['article_id_fk'] = $article_id;
                    ArticleImages_M::create($data_image);
                }
            }
            $request->session()->flash('toastMessage', translate('file_added_successfully'));
            return redirect()->route('edit_article',$article_id);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /*************************************************/
    public function show($id)
    {
        $data['article'] = Articles_M::findOrFail($id);
        $data['images'] = ArticleImages_M::where('article_id_fk', $id)->get();

        return view('articles.articles_details', $data);
    }
}
