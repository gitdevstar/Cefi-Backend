<?php

namespace Deployer;

require 'recipe/laravel.php';
require 'recipe/rsync.php';
require 'recipe/provision.php';

set('application', 'My App');
set('ssh_multiplexing', true);

set('rsync_src', function () {
    return __DIR__;
});


add('rsync', [
    'exclude' => [
        '.git',
        '/.env',
        '/storage/',
        '/vendor/',
        '/node_modules/',
        '.github',
        'deploy.php',
    ],
]);

task('deploy:secrets', function () {
    file_put_contents(__DIR__ . '/.env', getenv('DOT_ENV'));
    upload('.env', get('deploy_path') . '/shared');
});

host('ec2-18-191-250-207.us-east-2.compute.amazonaws.com')
//   ->hostname('18.191.250.207')
    // ->stage('production')
//   ->user('root')
    ->set('hostname', '18.191.250.207')
    ->setRemoteUser('root')
    ->set('php_version', '7.4')
    ->set('deploy_path', '/var/www/html');

// host('staging.myapp.io')
//   ->hostname('104.248.172.220')
//   ->stage('staging')
//   ->user('root')
//   ->set('deploy_path', '/var/www/my-app-staging');

desc('Provision the server');
task('provision', [
    'provision:php',
    'provision:composer',
]);

after('deploy:failed', 'deploy:unlock');

desc('Deploy the application');

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'rsync',
    'deploy:secrets',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'artisan:storage:link',
    'artisan:view:cache',
    'artisan:config:cache',
    'artisan:migrate',
    'artisan:queue:restart',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);
