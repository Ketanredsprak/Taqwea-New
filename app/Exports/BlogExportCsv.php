<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Repositories\BlogRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * BlogExportCsv class
 */
class BlogExportCsv implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $blogRepository;
    protected $request;

    /**
     * Function __construct 
     * 
     * @param BlogRepository $blogRepository [explicite description]
     * @param Request        $request        [explicite description]
     * 
     * @return void
     */
    public function __construct($request, $blogRepository)
    {
        $this->request = $request;
        $this->blogRepository = $blogRepository;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $post = $this->request->all();
        $post['is_paginate'] = true;
        if (!empty($post['from_date'])) {
            $post['from_date'] = Carbon::parse($post['from_date'])->format("Y-m-d");
        }
        if (!empty($post['to_date'])) {
            $post['to_date'] = Carbon::parse($post['to_date'])->format("Y-m-d");
        }
        $classes = $this->blogRepository->getBlogs($post);
        
        $exports = array();

        foreach ($classes as $key => $item) {
            $data['id'] = $key + 1;
            $data['name'] = ($item->tutor->name) ? $item->tutor->name : "N/A";
            $data['email'] = ($item->tutor->email) ? $item->tutor->email : "N/A";
            $data['blog_detail'] = ($item->blog_title) ? ($item->blog_title)  : 'N/A';
            $data['blog_description'] = ($item->blog_description) ? ($item->blog_description) : 'N/A';
            
            $exports[] = $data;
        }
        return collect($exports);
    }

    /**
     * Headings function Loading method for returning heading for excel
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Tutor Name',
            'Tutor Email',
            'Blog Title',
            'Blog Description'
        ];
    }
}
