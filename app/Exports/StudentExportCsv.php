<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\ClassBooking;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Http\Resources\V1\UserResource;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

/**
 * StudentExportCsv
 */
class StudentExportCsv implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $userRepository;
    protected $request;

    /**
     * Method __construct
     *
     * @param UserRepository $userRepository [explicite description]
     * @param Request        $request        [explicite description]
     *
     * @return void
     */
    public function __construct(
        $userRepository,
        $request
    ) {
        $this->userRepository = $userRepository;
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
        $post['user_type'] = 'student';
        $post['is_paginate'] = true;
        if (!empty($post['from_date'])) {
            $post['from_date'] = Carbon::parse($post['from_date'])->format("Y-m-d");
        }
        if (!empty($post['to_date'])) {
            $post['to_date'] = Carbon::parse($post['to_date'])->format("Y-m-d");
        }
        $users = $this->userRepository->getUsers($post);
        $usersCollection = UserResource::collection($users)->resolve();
        $exports = array();
        $filler = "N/A";
        $zeroFiller = "0";
        foreach ($usersCollection as $key => $item) {
            $data['id'] = $key + 1;
            $data['student_name'] = ($item['name']) ? $item['name'] : $filler;
            $data['gender'] = ($item['gender']) ? $item['gender'] : $filler;
            $data['email']  = ($item['email']) ? $item['email'] : $filler;
            $data['phone_no'] = ($item['phone_number']) ? $item['phone_number'] : $filler;
            $data['rating'] = ($item['rating']) ? $item['rating'] : $filler;
            $data['date_of_joining'] = ($item['created_at']) ? changeDateToFormat($item['created_at']) : $filler;
            $data['account_status'] = ($item['status']) ? $item['status'] : $filler;
            $data['completed_classes'] = ($item['student_purchase']['count_class']) ? $item['student_purchase']['count_class'] : $zeroFiller;
            $data['completed_webinars'] = ($item['student_purchase']['count_webinar']) ? $item['student_purchase']['count_webinar'] : $zeroFiller;
            $data['blogs_purchased'] = ($item['student_purchase']['count_blog']) ? $item['student_purchase']['count_blog'] : $zeroFiller;
            $data['wallet_amount'] = ($item['walletBalance']) ? $item['walletBalance'] : $zeroFiller;
            $data['points'] = ($item['availablePoint']) ? $item['availablePoint'] : $zeroFiller;

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
            'Student Name',
            'Gender',
            'Email',
            'Phone Number',
            'Ratings',
            'Date of Joining',
            'Account Status',
            'Completed Classes',
            'Completed Webinars',
            'Blogs Purchased',
            'Wallet Amount',
            'Points'
        ];
    }
}
