<?php

namespace App\Repositories;

use App\Models\SupportRequest;
use App\Models\User;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Mail\SupportEmailReply;
use App\Mail\UserSupportEmail;
use Illuminate\Database\Eloquent\Collection;

class SupportRequestRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return SupportRequest::class;
    }

    /**
     * Boot up the repository, pushing criteria
     * 
     * @return void
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Method addSupportRequest
     *
     * @param array $data [explicite description]
     *
     * @return SupportRequest
     */
    public function addSupportRequest(array $data): SupportRequest
    {
        $support = $this->create($data);
        $admin = User::getAdmin();
        if ($admin) {
            $admin_email = $admin->email;
            $emailTemplate = new UserSupportEmail($data);
            sendMail($admin_email, $emailTemplate);
        }

        return $support;
    }

    /**
     * Function ListSupportRequest
     *
     * @param $request $request
     * 
     * @return Collection
     */
    public function listSupportRequest($request)
    {
        $columns = ['id', 'name', 'email', 'message'];
        $query = $this->select($columns);

        $searchValue = $request->query('search')['value'];
        if ($searchValue) {
            $query->where('email', 'like', '%' . $searchValue . '%');
        }

        if ($request->filled('order')) {
            $sortDirection = $request->query('order')[0]['dir'];
            $column = $columns[$request->input('order.0.column')];
            $query->orderBy($column, $sortDirection);
        }

        $limit = $request['size'] ?? config('repository.pagination.limit');

        return $query->paginate($limit);
    }

    /**
     * Function getSupportRequest
     *
     * @param int  $id       [explicite description]
     * @param bool $withUser [explicite description]
     * 
     * @return SupportRequest
     */
    public function getSupportRequest(int $id): SupportRequest
    {
        return $this->where('id', $id)->first();
    }

    /**
     * Method sendReply
     *
     * @param array $data [explicite description]
     *
     * @return void
     */
    public function sendReply(array $data)
    {
        $supportEmail = $this->getSupportRequest($data['id']);
        if ($supportEmail) {
            $userName = $supportEmail->name;
            $emailData = [
                'name' => $userName,
                'replyText' => $data['reply_text']
            ];
            $emailTemplate = new SupportEmailReply($emailData);
            sendMail($supportEmail->email, $emailTemplate);
        }
    }
}
