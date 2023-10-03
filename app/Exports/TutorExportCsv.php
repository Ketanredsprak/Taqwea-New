<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Http\Resources\V1\UserResource;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;

/**
 * TutorExportCsv
 */
class TutorExportCsv implements FromCollection, ShouldAutoSize, WithHeadings
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
        $post['user_type'] = 'tutor';
        $post['is_paginate'] = true;
        $post['subscription'] = true;
        $post['report'] = true;
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
            $item['user_subjects'] = $item['user_subjects']->resolve();
            $item['user_levels'] = $item['user_levels']->resolve();
            $item['user_grades'] = $item['user_grades']->resolve();
            $item['tutor_subscription'] = $item['tutor_subscription']->resolve();
            $item['tutor_educations'] = $item['tutor_educations']->resolve();
            $item['tutor_detail'] = $item['tutor_detail']->resolve();

            $data['id'] = $key+1;
            $data['tutor_name'] = ($item['name']) ? $item['name'] : $filler;
            $data['gender'] = ($item['gender']) ? $item['gender'] : $filler;
            $data['email']  = ($item['email']) ? $item['email'] : $filler;
            $data['phone_no'] = ($item['phone_number']) ? $item['phone_number'] : $filler;
            $data['rating'] = ($item['rating']) ? $item['rating'] : $filler;
            $data['subject'] = (count($item['user_subjects']) > 0) ? $this->multipleValue($item['user_subjects'], 'name') : $filler;
            $data['level'] = (count($item['user_levels']) > 0) ? $this->multipleValue($item['user_levels'], 'name') : $filler;
            $data['grades'] = (count($item['user_grades']) > 0) ? $this->multipleValue($item['user_grades'], 'name') : $filler;
            $data['education'] = (count($item['tutor_educations']) > 0) ? $this->multipleValue($item['tutor_educations'], 'degree') : $filler;
            $data['experience'] = ($item['tutor_detail']) ? $item['tutor_detail']['experience'] : $filler;
            $data['date_of_joining'] = ($item['created_at']) ? changeDateToFormat($item['created_at']) : $filler;
            $data['verification_status'] = ($item['approval_status']) ? $item['approval_status'] : $filler;
            $data['account_status'] = ($item['status']) ? $item['status'] : $filler;
            $data['current_subscription'] = (count($item['tutor_subscription']) > 0) ? $item['tutor_subscription']['subscription']['subscription_name'] : $filler;
            $data['completed_classes'] = ($item['classes_completed']) ? $item['classes_completed'] : $zeroFiller;
            $data['completed_webinars'] = ($item['webinar_completed']) ? $item['webinar_completed'] : $zeroFiller;
            $data['added_blogs'] = ($item['blogs_count']) ? $item['blogs_count'] : $zeroFiller;
            $data['overall_revenue'] = ($item['payment_earning']['total_earning']) ? $item['payment_earning']['total_earning'] : $zeroFiller;
            $data['wallet_amount'] = ($item['walletBalance']) ? $item['walletBalance'] : $zeroFiller;
            $data['points'] = ($item['availablePoint']) ? $item['availablePoint'] : $zeroFiller;
            $data['current_due_amount'] = ($item['payment_earning']['total_due']) ? $item['payment_earning']['total_due'] : $zeroFiller;
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
            'Gender',
            'Email',
            'Phone No',
            'Rating',
            'Subject',
            'Level',
            'Grades',
            'Education',
            'Experience',
            'Date of Joining',
            'Verification Status',
            'Account Status',
            'Current Subscription',
            'Completed Classes',
            'Completed Webinars',
            'Added Blogs',
            'Overall Revenue',
            'Wallet Amount',
            'Points',
            'Current Due Amount'
        ];
    }

    /**
     * Method multipleValue
     *
     * @param $data            array|object
     * @param $valueToBePicked value to be picked
     *
     * @return string
     */
    public function multipleValue($data, $valueToBePicked)
    {
        $returnString = '';
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                if ($returnString != '') {
                    $returnString .= ' | ' ;
                }
                $returnString .= $value[$valueToBePicked];
            }
        }
        $returnString = preg_replace("/\|$/", '', $returnString);

        return $returnString;
    }
}
