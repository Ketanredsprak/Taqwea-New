<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\FaqRepository;
use App\Repositories\CmsRepository;
use Exception;

/**
 * Class for cms pages opration
 */
class CmsController extends Controller
{
    protected $cmsRepository;
    protected $faqRepository;

    /**
     * Function __construct
     *
     * @param FaqRepository $faqRepository [explicite description]
     * @param CmsRepository $cmsRepository [explicite description]
     * 
     * @return void
     */
    public function __construct(FaqRepository $faqRepository, CmsRepository $cmsRepository)
    {
        $this->cmsRepository = $cmsRepository;
        $this->faqRepository = $faqRepository;
    }

    /**
     * Show CMS
     * 
     * @param \Illuminate\Http\Request $request [explicite description]
     * 
     * @return View
     */
    public function index(Request $request)
    {
        if (isset($request->lang) && !empty($request->lang)) {
            setUserLanguage($request->get('lang'));
        }
        $cms = $this->cmsRepository->getCmsDetails(['slug' => $request->slug]);
        if (!$cms) {
            abort(404);
        }
        return view('frontend.cms.index', ['cms' => $cms]);
    }

    /**
     * Show faq
     * 
     * @param Request $request 
     * 
     * @return View
     */
    public function faq(Request $request)
    {
        if (isset($request->lang) && !empty($request->lang)) {
            setUserLanguage($request->get('lang'));
        }
        return view('frontend.cms.faq.index');
    }

    /**
     * Get list of faq
     * 
     * @param \Illuminate\Http\Request $request [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function faqList(Request $request)
    {
        try {
            $params = $request->all();
            $faqs = $this->faqRepository->getFaqs($params);
            $html = view('frontend.cms.faq.faq-list', ['faqs' => $faqs])->render();
            return $this->apiSuccessResponse($html, trans('message.faq_list'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }
}
