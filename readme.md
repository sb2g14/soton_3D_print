## 3dprint.clients.soton.ac.uk web site 

What is new in version 1.3?

- How to use page with 3D printers?  
(http://3dprint.clients.soton.ac.uk/printers/index)

- Printer performance in printer details 
(http://3dprint.clients.soton.ac.uk/issues/show/1)

- If you would like update or resolve the current issue with a certain printer you just need to click on Viw/Update or Resolve button or access issues via 3Dprinters->Pending issues

- To log a new printer issue go to 3Dprinters->Log an Issue->Select printer->Log a New Issue or via home->Issues->+

- Updated Pending Jobs page. New button "Show currently approved jobs" leads to the list of jobs that have just been approved by a demonstrator. We added link to display all the jobs history. (As requested by some of you).

- 3Dhubs manager now can edit the job after it has finished by adjusting the printing time and material amount. Therefore, it is now possible to manage overnight jobs. And the cost tracking is more precise. The failed jobs requested by the 3Dhubs manager are not charged. In addition to that, while performing joined jobs the 3dhubs menager can reqest multiple jobs on the same printer. 



Remember to fulfill all license requirements for the pulled packages ASAP...

## Laravel Roles Permissions Admin - Spatie version

This is a Laravel 5.4 adminpanel starter project with roles-permissions management based on [Spatie Laravel-permission package](https://github.com/spatie/laravel-permission), [AdminLTE theme](https://adminlte.io/) and [Datatables.net](https://datatables.net).

We've also created almost identical project based on Joseph Silber's Bouncer package: [see here](https://github.com/LaravelDaily/laravel-roles-permissions-bouncer)

Part of this project was generated automatically by [QuickAdminPanel system](https://quickadminpanel.com/).

![Larancer screenshot](http://webcoderpro.com/roles-permissions-manager-spatie.png)

## Usage

This is not a package - it's a full Laravel project that you should use as a starter boilerplate, and then add your own custom functionality.

- Clone the repository with `git clone`
- Copy `.env.example` file to `.env` and edit database credentials there
- Run `composer install`
- Run `php artisan key:generate`
- Run `php artisan migrate --seed` (it has some seeded data - see below)
- That's it: launch the main URL and login with default credentials `admin@admin.com` - `password`

This boilerplate has one role (`administrator`), one permission (`users_manage`) and one administrator user.

With that user you can create more roles/permissions/users, and then use them in your code, by using functionality like `Gate` or `@can`, as in default Laravel, or with help of Spatie's package methods.

## License

The [MIT license](http://opensource.org/licenses/MIT).

## Notice

We are not responsible for any functionality or bugs in **AdminLTE**, **Laravel-permission** or **Datatables** packages or their future versions, if you find bugs there - please contact vendors directly.
