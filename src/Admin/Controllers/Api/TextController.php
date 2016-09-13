<?php

namespace FourCms\Admin\Controllers\Api;

use App;
use Illuminate\Http\Request;
use FourCms\Admin\Controllers\ApiController;
use Longman\Platfourm\Text\Services\AutosaveTextsService;
use Longman\Platfourm\Text\Services\GetTextsService;
use Longman\Platfourm\Text\Services\GetTranslationsService;
use Longman\Platfourm\Text\Services\UpdateTextValueService;

class TextController extends ApiController
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('permission:text.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:text.update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:text.delete', ['only' => ['destroy']]);
    }

    /**
     * @SWG\Get(
     *     path="/admin/api/text",
     *     description="Texts list",
     *     tags={"Admin - Text"},
     *     @SWG\Parameter(
     *         description="Per page items count",
     *         name="perPage",
     *         required=false,
     *         type="integer",
     *         in="query",
     *         default="25"
     *     ),
     *     @SWG\Parameter(
     *         description="Page for pagination",
     *         name="page",
     *         required=false,
     *         type="integer",
     *         in="query",
     *         default="1"
     *     ),
     *     @SWG\Parameter(
     *         description="Comma separated fields",
     *         name="fields",
     *         required=false,
     *         type="string",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="Search string",
     *         name="search",
     *         required=false,
     *         type="string",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="Fields list for search",
     *         name="searchFields",
     *         required=false,
     *         type="string",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="Scope",
     *         name="scope",
     *         required=false,
     *         type="string",
     *         enum={"global", "admin", "site"},
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="sortBy field. Format: field1:asc,field2:desc",
     *         name="sortBy",
     *         required=false,
     *         type="string",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="",
     *     ),
     * )
     * Log the users list of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'perPage' => 'numeric|min:1',
            'page'    => 'numeric|min:1',
            'scope'   => 'in:global,admin,site',
        ]);

        $service = $this->app->make(GetTextsService::class);

        $fields  = $request->get('fields', '*');
        $perPage = $request->get('perPage');
        $page    = $request->get('page', 1);
        $sortBy  = $request->get('sortBy');
        $scope   = $request->get('scope');

        $options                 = [];
        $options['search']       = $request->get('search');
        $options['searchFields'] = $request->get('searchFields');
        if ($scope) {
            $options['scope'] = $scope;
        }
        $items = $service->run($fields, $options, $perPage, $page, $sortBy);

        return $this->response($items->toArray());
    }

    /**
     * @SWG\Put(
     *     path="/admin/api/text",
     *     description="Update text",
     *     tags={"Admin - Text"},
     *     @SWG\Parameter(
     *         description="Scope",
     *         name="scope",
     *         required=true,
     *         type="string",
     *         enum={"global", "admin", "site"},
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="Language",
     *         name="lang",
     *         required=true,
     *         type="string",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="Key",
     *         name="key",
     *         required=true,
     *         type="string",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="Value",
     *         name="value",
     *         required=true,
     *         type="string",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Updated data",
     *     ),
     * )
     *
     * Handle a bank profile update request for the application.
     *
     * @param  string                   $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'scope' => 'required|in:global,admin,site',
            'lang'  => 'required',
            'key'   => 'required',
        ]);

        $service = $this->app->make(UpdateTextValueService::class);

        $text = $service->run($request->only([
                                                 'scope',
                                                 'lang',
                                                 'key',
                                             ]), $request->get('value', ''));

        return $this->response($text->toArray());
    }

    /**
     * @SWG\Get(
     *     path="/admin/api/text/translations",
     *     description="Texts",
     *     tags={"Admin - Text"},
     *     @SWG\Response(
     *         response=200,
     *         description="",
     *     ),
     * )
     * List of application texts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTranslations(Request $request)
    {
        $service = App::make(GetTranslationsService::class);

        $options             = [];
        $options['in:scope'] = ['global', 'admin'];
        $items               = $service->run(['key', 'value'], $options);

        return $this->response($items);
    }

    /**
     * @SWG\Post(
     *     path="/admin/api/text/autosave",
     *     description="Creates new user",
     *     tags={"Admin - Text"},
     *     @SWG\Parameter(
     *         description="Language",
     *         name="lang",
     *         required=true,
     *         type="string",
     *         in="query",
     *         default="ge"
     *     ),
     *     @SWG\Parameter(
     *         description="Scope",
     *         name="scope",
     *         required=true,
     *         type="string",
     *         enum={"global", "admin", "site"},
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="Data (array)",
     *         name="data",
     *         required=true,
     *         type="array",
     *         items={},
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Created Texts",
     *     ),
     * )
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function autosave(Request $request)
    {
        if (!$this->app->environment('local')) {
            return $this->response('');
        }

        /*$request->query->set('lang', 'ge');
        $request->query->set('scope', 'global');
        $request->query->set('data', [
        'test1' => 'ასადასფა',
        'test2' => 'ასადასფა',
        'test3' => 'ასადასფა',
        'test4' => 'ასადასფა',
        ]);*/

        $this->validate($request, [
            'lang'  => 'required',
            'scope' => 'required|in:admin,site,global',
            'data'  => 'required',
        ]);

        $textService = $this->app->make(AutosaveTextsService::class);
        $textService->run($request->get('lang'), $request->get('scope'), $request->get('data'));

        return $this->response('');
    }
}
