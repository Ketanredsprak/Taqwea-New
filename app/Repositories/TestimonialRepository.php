<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Testimonial;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Exception;


/**
 * Interface Repository.
 *
 * @package TestimonialRepository;
 */
class TestimonialRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Testimonial::class;
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
     * Method getRecentTestimonial 
     * 
     * @return Collection
     */
    public function getRecentTestimonial()
    {
        $size = config('repository.pagination.limit');
        return $this->orderBy('created_at', 'desc')
            ->withTranslation()->paginate($size);
    }

    /**
     * Method getTestimonials
     *
     * @param array $params [explicite description]
     *
     * @return void
     */
    public function getTestimonials(array $params = [])
    {
        $sortFields = [
            'id' => 'id',
            'name' => 'name',
            'rating' => 'rating',
            'content' => 'content'
        ];

        $limit = $params['size'] ?? config('repository.pagination.limit');
        $query = $this->withTranslation();

        if (!empty($params['search'])) {
            $query->whereTranslationLike('name', "%" . $params['search'] . "%");
        }

        $sort = $sortFields['id'];
        $direction = 'desc';

        if (array_key_exists('sortColumn', $params)) {
            if (isset($sortFields[$params['sortColumn']])) {
                $sort = $sortFields[$params['sortColumn']];
            }
        }

        if (array_key_exists('sortDirection', $params)) {
            $direction = $params['sortDirection'] == 'desc' ? 'desc' : 'asc';
        }
        if (in_array($sort, ['name'])) {
            $query->orderByTranslation($sort, $direction);
        } else if (in_array($sort, ['content'])) {
            $query->orderByTranslation($sort, $direction);
        } else {
            $query->orderBy($sort, $direction);
        }

        return $query->paginate($limit);
    }


    /**
     * Function createTestimonial
     *
     * @param $post [explicite description]
     * 
     * @return void
     */
    public function createTestimonial($post)
    {
        try {
            DB::beginTransaction();
            if (!empty($post['testimonial_file'])) {
                $post['testimonial_file'] = uploadFile(
                    $post['testimonial_file'],
                    'testimonial',
                );
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
     * Function updateTestimonial
     * 
     * @param $post [explicite description]
     * @param int $id   [explicite description]
     *
     * @return void
     */
    public function updateTestimonial($post, $id)
    {
        try {
            DB::beginTransaction();
            $testimonial = $this->find($id);

            if (!empty($post['testimonial_file'])) {
                $post['testimonial_file'] = uploadFile(
                    $post['testimonial_file'],
                    'testimonial'
                );
                deleteFile($testimonial->testimonial_file);
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
     * Function getTestimonial
     * 
     * @param $id 
     * 
     * @return void
     */
    public function getTestimonial(int $id)
    {
        return $this->where('id', $id)->first();
    }

    /**
     * Method deleteTestimonial
     *
     * @param int $id [explicite description]
     *
     * @return int
     */
    public function deleteTestimonial(int $id): int
    {
        return $this->delete($id);
    }
}
