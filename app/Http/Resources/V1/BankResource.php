<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Bank;

class BankResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $loggedInUser = Auth::user();
        return [
            'id' => $this->id ?? $this->testimonial_id,
            'bank_name' => $this->bank_name,
            'bank_code' => $this->bank_code,
            'tutor_count' => $this->tutor_count,
            'status' => $this->status,
            'translations' => $this->when(
                $loggedInUser && $loggedInUser->isAdmin(),
                function () {
                    $bank = Bank::where('id', $this->id)->first();
                    $translations = [];
                    if ($bank->translations) {
                        foreach ($bank->translations as $translation) {
                            $translations[$translation->language] = $translation->bank_name;
                        } 
                    }
                    return $translations;
                }
            ),
        ];
    }
}
