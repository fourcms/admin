<?php
/*
 * This file is part of the FourCms Admin package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FourCms\Admin\Controllers\Api;

use App\Models\Category;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use FourCms\Admin\Controllers\ApiController;
use Longman\Platfourm\Auth\Services\UpdateAvatarService;
use Longman\Platfourm\User\Services\DeleteUserService;
use Longman\Platfourm\User\Services\GetRolesService;
use Longman\Platfourm\User\Services\GetUsersService;
use Ramsey\Uuid\Uuid;

class HomeController extends ApiController
{

    public function index()
    {

        $metaData                 = [];
        $metaData['environment']  = $this->app->environment();
        $metaData['debug']        = config('app.debug') ? 'true' : 'false';
        $metaData['pusher_key']   = config('broadcasting.connections.pusher.key');
        $metaData['langs']        = implode(',', $this->app->getAvailableLocales());
        $metaData['default_lang'] = $this->app->getDefaultLocale();

        return $this->view('app')->with('metaData', $metaData);
    }

    public function error404()
    {
        abort(404);
    }

    public function test(Request $request)
    {
        DB::enableQueryLog();

        $root = Category::root();

        $cat = Category::findOrFail('b71a04b6-9c82-4fe2-89b0-2c0b1575986e');

        dump($cat->descendants()->get());
        die;
        //dump($root->siblings()->withDepth()->get());
        //die;

        $data  = [
            'lang'      => \App::getLocale(),
            'parent_id' => $root->id,
            'title'     => 'Sub 1.1',
        ];
        $cat11 = Category::create($data);

        $data  = [
            'lang'      => \App::getLocale(),
            'parent_id' => $root->id,
            'title'     => 'Sub 1.2',
        ];
        $cat12 = Category::create($data);

        $data  = [
            'lang'      => \App::getLocale(),
            'parent_id' => $root->id,
            'title'     => 'Sub 1.3',
        ];
        $cat13 = Category::create($data);

        $data  = [
            'lang'      => \App::getLocale(),
            'parent_id' => $cat11->id,
            'title'     => 'Sub 2.1',
        ];
        $cat21 = Category::create($data);

        $data  = [
            'lang'      => \App::getLocale(),
            'parent_id' => $cat12->id,
            'title'     => 'Sub 2.2',
        ];
        $cat22 = Category::create($data);

        $data  = [
            'lang'      => \App::getLocale(),
            'parent_id' => $cat21->id,
            'title'     => 'Sub 3.1',
        ];
        $cat31 = Category::create($data);

        $data  = [
            'lang'      => \App::getLocale(),
            'parent_id' => $cat22->id,
            'title'     => 'Sub 3.2',
        ];
        $cat32 = Category::create($data);

        $data  = [
            'lang'      => \App::getLocale(),
            'parent_id' => $cat31->id,
            'title'     => 'Sub 4.1',
        ];
        $cat41 = Category::create($data);

        $data  = [
            'lang'      => \App::getLocale(),
            'parent_id' => $cat32->id,
            'title'     => 'Sub 4.1',
        ];
        $cat42 = Category::create($data);

        dump($cat41);
        dump($cat42);
        die;

        $user = $this->getAuthService()->logoutAs();

        dump(DB::getQueryLog());

        dump($user->toArray());
        die;

        /*$user            = new User();
        $user->role_id   = 1;
        $user->email     = str_random();
        $user->firstname = 'AAAA';
        $user->lastname  = 'BBBBBB';
        $user->password  = bcrypt('BBBBBB');
        $user->save();*/

        $id   = 'a6a3a30e-330c-11e6-8abb-0242dcdb99ac';
        $user = User::with('entityLock')->find($id);

        dump($user->isLocked());
        dump($user->entityLock);
        dump(DB::getQueryLog());

        die;

        $userService = $this->app->make(GetUsersService::class);

        $fields  = $request->get('fields', '*');
        $perPage = $request->get('perPage', 10);
        $page    = $request->get('page', 1);
        $sortBy  = $request->get('sortBy');

        $options                 = [];
        $options['search']       = $request->get('search');
        $options['searchFields'] = $request->get('searchFields');
        $options['trashed']      = 1;
        $items                   = $userService->run($fields, $options, $perPage, $page, $sortBy);

        dump(DB::getQueryLog());
        dump($items->toArray());
        die;

        dump(config('cms'));
        die;

        $service = $this->app->make(UpdateAvatarService::class);
        $service->run();

        dump($service);
        die;

        $email    = 'akalongman@gmail.com';
        $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "&s=512";
        dump($grav_url);
        die;

        $this->validate($request, [
            'perPage' => 'numeric|min:1',
            'page'    => 'numeric|min:1',
        ]);

        $service = $this->app->make(GetRolesService::class);

        $fields  = $request->get('fields', '*');
        $perPage = $request->get('perPage', 25);
        $page    = $request->get('page', 1);
        $sortBy  = $request->get('sortBy');

        //$status  = $request->get('status');

        $options                 = [];
        $options['search']       = $request->get('search');
        $options['searchFields'] = $request->get('searchFields');
        $items                   = $service->run($fields, $options, $perPage, $page, $sortBy);

        dump(DB::getQueryLog());

        dump($items);
        die;

        $id      = '19eeeb10-2cb5-11e6-bcd9-0242fbb79d4e';
        $service = $this->app->make(DeleteUserService::class);
        $user    = $service->run($id);

        dump($user);
        die;

        $service = $this->app->make(GetRolesService::class);
        $items   = $service->run();

        dump($items);
        die;

        $user            = new User();
        $user->role_id   = 1;
        $user->email     = str_random();
        $user->firstname = 'AAAA';
        $user->lastname  = 'BBBBBB';
        $user->password  = bcrypt('BBBBBB');
        $user->save();

        dump($user);
        die;
        $user = User::find($user->id);
        $user->delete();

        /*$user = User::find('02fe580c-2c9f-11e6-b16b-0242fbb79d4e');
        $user->role_id = 1;
        $user->email = str_random();
        $user->firstname = 'AAAA1111';
        $user->lastname = 'BBBBBB111';
        $user->save();*/

        dump(DB::getQueryLog());
        die;

        $user = $this->authService->user();

        dump($user->role->perms->toArray());
        //dump($user->hasRole('super_admin'));
        die;

        // ABC
        dump($user->role->perms->toArray());
        die;

        $user->permissions = $user->role()->perms->toArray();

        $service = $this->app->make(GetUsersService::class);

        $per_page = $request->get('per_page', 10);
        $page     = $request->get('page', 1);

        $items = $service->run($per_page, ['*'], $page);

        dump(DB::getQueryLog());
        dump($items->toArray());
        die;

        dump(Uuid::uuid1()->toString());
        dump(Uuid::uuid4()->toString());
        die;
        dump('AAAA');

        return '- - -';
    }

}
