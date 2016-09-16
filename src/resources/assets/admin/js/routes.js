import {routes} from 'helpers/routes';

routes(({page, route}) => {
    page(':lang/admin', function(context, next) {
        page(`/${context.params.lang}/admin/dashboard`);
    });

    page(':lang/admin/dashboard', route('dashboard'));

    page(':lang/admin/login', route('login'));

    page(':lang/admin/user', route('users'));
    page(':lang/admin/user/:create(create)', route('user'));
    page(':lang/admin/user/:id', route('user'));

    page(':lang/admin/text', route('texts'));

    page('*', route('notFound'));
});
