<?php

namespace Deployer;

use Deployer\Configuration\Configuration;

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

set('php_version', '7.4');

host('ec2-18-191-250-207.us-east-2.compute.amazonaws.com')
//   ->hostname('18.191.250.207')
    ->setHostname('18.191.250.207')
    // ->set('hostname', '18.191.250.207')
    ->set('labels', ['stage' => 'prod'])
//   ->user('root')
    ->setRemoteUser('root')
    // ->set('php_version', '7.4')
    ->setDeployPath('/var/www/html');

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
    // 'deploy:cleanup',
]);
