<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Repositories\ClassRepository;
use Illuminate\Http\Request;

/**
 * ClassExportCsv
 */
class ClassExportCsv implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $classRepository;
    protected $request;

    /**
     * Method __construct
     *
     * @param ClassRepository $classRepository [explicite description]
     * @param Request         $request         [explicite description]
     *
     * @return void
     */
    function __construct(
        $classRepository,
        $request
    ) {
        $this->classRepository = $classRepository;
        $this->request = $request;
    }

    /**
     * Collection all Student data 
     * 
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $post = $this->request->all();
        $post['class_type'] = ['class'];
        $post['is_paginate'] = true;
        $classes = $this->classRepository->getClasses($post);
        $exports = array();

        foreach ($classes as $key => $item) {
            $data['id'] = $key + 1;
            $data['name'] = ($item->tutor->name) ? $item->tutor->name : "N/A";
            $data['email'] = ($item->tutor->email) ? $item->tutor->email : "N/A";
            $data['type'] = ($item->class_type) ? $item->class_type : "N/A";
            $data['class_description'] = ($item->class_description) ? ($item->class_description) : 'N/A';
            $data['class_capacity'] = ($item->no_of_attendee) ? ($item->no_of_attendee) : 'N/A';


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
            "Type",
            'Class Description',
            'Class Capacity'
        ];
    }
}
