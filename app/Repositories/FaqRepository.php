<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Faq;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Interface Repository.
 *
 * @package FaqRepository;
 */
class FaqRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Faq::class;
    }

    /**
     * Method boot
     *
     * @return void
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Undocumented function
     *
     * @param array $params 
     * 
     * @return Collection
     */
    public function getFaqs(array $params)
    {
        $limit = 10;
        $query = $this->withTranslation();

        if (!empty($params['search'])) {
            $query->whereTranslationLike('question', "%".$params['search']."%");
        }
         
        return $query->paginate($limit);
    }

    /**
     * Function createFaq
     *
     * @param $post [explicite description]
     * 
     * @return void
     */
    public function createFaq($post)
    {
        try {
            DB::beginTransaction();
            if (!empty($post['faq_file'])) {
                $post['faq_file'] = uploadFile(
                    $post['faq_file'],
                    'faq',
                    'public',
                    [
                        'width' => 300,
                        'height' => 150
                    ]
                );
                $fileType = getFileTypeFromMime($post['mimeType']);
                $post['type'] = $this->_getFaqType($fileType);
            }
            $result = $this->create($post);
            DB::commit();
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            throw ($e);
        }
    }

    /**
     * Function updateFaq
     * 
     * @param $post [explicite description]
     * @param int $id   [explicite description]
     *
     * @return void
     */
    public function updateFaq($post, $id)
    {
        try {
            DB::beginTransaction();
            if (!empty($post['faq_file'])) {
                $post['faq_file'] = uploadFile(
                    $post['faq_file'],
                    'faq'
                );
                $fileType = getFileTypeFromMime($post['mimeType']);
                $post['type'] = $this->_getFaqType($fileType);
            } else if (array_key_exists("old_images", $post)) {
                $post['faq_file'] = $post['old_images'];
            }
            $result = $this->update($post, $id);
            DB::commit();
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            throw ($e);
        }
    }

    /**
     * Function edit
     *
     * @param int $id [explicite description]
     * 
     * @return void
     */
    public function getFaq($id)
    {
        return $this->where('id', $id)->first();
    }

    /**
     * Method getFaqType
     *
     * @param string $fileType [explicite description]
     *
     * @return string
     */
    private function _getFaqType(string $fileType):string
    {
        $faqType = Faq::TYPE_TEXT;
        if ($fileType == Faq::TYPE_IMAGE) {
            $faqType = Faq::TYPE_IMAGE;
        } elseif ($fileType == Faq::TYPE_VIDEO) {
            $faqType = Faq::TYPE_VIDEO;
        } elseif ($fileType == Faq::TYPE_DOCUMENT) {
            $faqType = Faq::TYPE_DOCUMENT;
        }

        return $faqType;
    }
}
