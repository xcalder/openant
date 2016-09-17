![](https://raw.githubusercontent.com/xcalder/openant/master/public/resources/default/image/logos/logo.jpg)

OpenAnt 多商家、多语言、自动拆单、自动记帐类似淘宝的电商系统
=========================
[![Build Status](https://travis-ci.org/meolu/walle-web.svg?branch=master)](https://travis-ci.org/meolu/walle-web)
[![Packagist](https://img.shields.io/packagist/v/meolu/walle-web.svg)](https://packagist.org/packages/meolu/walle-web)
[![CodeIgniter](data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMTAiIGhlaWdodD0iMjAiPjxsaW5lYXJHcmFkaWVudCBpZD0iYiIgeDI9IjAiIHkyPSIxMDAlIj48c3RvcCBvZmZzZXQ9IjAiIHN0b3AtY29sb3I9IiNiYmIiIHN0b3Atb3BhY2l0eT0iLjEiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3Atb3BhY2l0eT0iLjEiLz48L2xpbmVhckdyYWRpZW50PjxtYXNrIGlkPSJhIj48cmVjdCB3aWR0aD0iMjEwIiBoZWlnaHQ9IjIwIiByeD0iMyIgZmlsbD0iI2ZmZiIvPjwvbWFzaz48ZyBtYXNrPSJ1cmwoI2EpIj48cGF0aCBmaWxsPSIjNTU1IiBkPSJNMCAwaDc1djIwSDB6Ii8+PHBhdGggZmlsbD0iIzk3Q0EwMCIgZD0iTTEyNSAwaDg5djIwSDc1eiIvPjxwYXRoIGZpbGw9InVybCgjYikiIGQ9Ik0wIDBoMTY0djIwSDB6Ii8+PC9nPjxnIGZpbGw9IiNmZmYiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZvbnQtZmFtaWx5PSJEZWphVnUgU2FucyxWZXJkYW5hLEdlbmV2YSxzYW5zLXNlcmlmIiBmb250LXNpemU9IjExIj48dGV4dCB4PSIzNy41IiB5PSIxNSIgZmlsbD0iIzAxMDEwMSIgZmlsbC1vcGFjaXR5PSIuMyI+UG93ZXJlZCBieTwvdGV4dD48dGV4dCB4PSIzNy41IiB5PSIxNCI+UG93ZXJlZCBieTwvdGV4dD48dGV4dCB4PSIxNDAuNSIgeT0iMTUiIGZpbGw9IiMwMTAxMDEiIGZpbGwtb3BhY2l0eT0iLjMiPkNvZGVJZ25pdGVyIEZyYW1ld29yazwvdGV4dD48dGV4dCB4PSIxNDAuNSIgeT0iMTQiPkNvZGVJZ25pdGVyIEZyYW1ld29yazwvdGV4dD48L2c+PC9zdmc+)](http://www.codeigniter.org)

A web deployment tool, Easy for configuration, Fully functional, Smooth interface, Out of the box.
support git/svn Version control system, no matter what language you are, php/java/ruby/python, just as jenkins. you can deploy the code or output to multiple servers easily by walle.

[Home Page](https://www.walle-web.io) | [官方主页](https://www.walle-web.io) | [中文说明](https://github.com/meolu/walle-web/blob/master/docs/README-zh.md) | [文档手册](https://www.walle-web.io/docs/).

Now, there are more than hundreds of companies hosted walle for deployment, star walle if you like : )

* Support git/svn Version control system.
* User signup by admin/develop identity.
* Developer submit a task, deploy task.
* Admin audit task.
* Multiple project.
* Multiple Task Parallel.
* Quick rollback.
* Group relation of project.
* Task of pre-deploy（e.g: test ENV var）.
* Task of post-deploy（e.g: mvn/ant, composer install for vendor）.
* Task of pre-release（e.g: stop service）.
* Task of post-release（e.g: restart service）.
* Check up file md5.
* Multi-process multi-server file transfer (Ansible).


Requirements
------------

* Bash(git、ssh)
* LNMP/LAMP(php5.4+)
* Composer
* Ansible(Optional)

That's all. It's base package of PHP environment!


Installation
------------
```
git clone git@github.com:meolu/walle-web.git
cd walle-web
vi config/web.php # set up module db mysql connection info
composer install  # error cause by bower-asset, install：composer global require "fxp/composer-asset-plugin:*"
./yii walle/setup # init walle
```
Or [The Most Detailed Installation Guide](https://github.com/meolu/walle-web/blob/master/docs/install-en.md), any questions refer to [FAQ](https://github.com/meolu/walle-web/blob/master/docs/faq-en.md)

Quick Start
-------------

* Signup a admin user(`admin/admin` exists), then configure a project, add member to the project, detect it.
    * [git demo](https://github.com/meolu/walle-web/blob/master/docs/config-git-en.md)
    * [svn demo](https://github.com/meolu/walle-web/blob/master/docs/config-svn-en.md)
* Signup a develop user(`demo/demo` exists), submit a deployment.
* Project admin audit the deployment.
* Developer deploy the deployment.


Custom
--------
you would like to adjust some params to make walle suited for your company.

* Set suffix of email while signing in
    ```php
    vi config/params.php

    'mail-suffix'   => [  // specify the suffix of email, multiple suffixes are allow.
        'huamanshu.com',  // e.g: allow xyz@huamanshu.com only
    ]
    ```

* Configure email smtp
    ```php
    vi config/local.php

    'transport' => [
            'host'       => 'smtp.huamanshu.com',
            'username'   => 'service@huamanshu.com',
            'password'   => 'K84erUuxg1bHqrfD',
            'port'       => 25,
            'encryption' => 'tls',
        ],
        'messageConfig' => [
            'charset' => 'UTF-8',
            'from'    => ['service@huamanshu.com' => '花满树出品'],  // the same with username of mail module in config/web.php
        ],
    ```

* Configure the path for log
    ```php
    vi config/params.php

    'log.dir'   => '/tmp/walle/',
    ```

* Configure language
    ```php
    vi config/web.php +73

    'language'   => 'en',  # zh => 中文,  en => English
    ```


To Do List
----------

- Travis CI integration
- Mail events：specify kinds of events
- Gray released：specify servers
- Websocket instead of poll
- A manager of static source
- Configure variables
- Support Docker
- Open api
- Command line

Update
-----------------
```
./yii walle/upgrade    # upgrade walle
```


Architecture
------------
#### git/svn, user, host, servers
![](https://raw.github.com/meolu/docs/master/walle-web.io/docs/en/static/walle-flow-relation-en.png)

#### deployment flow
![](https://raw.github.com/meolu/docs/master/walle-web.io/docs/en/static/walle-flow-en.png)

Screenshots
-----------

#### project config
![](https://raw.github.com/meolu/docs/master/walle-web.io/docs/en/static/walle-config-edit-en.jpg)

#### sumbit a task
![](https://raw.github.com/meolu/docs/master/walle-web.io/docs/en/static/walle-submit-en.jpg)

#### list of task
![](https://raw.github.com/meolu/docs/master/walle-web.io/docs/en/static/walle-dev-list-en.jpg)

#### demo show
![](https://raw.github.com/meolu/docs/master/walle-web.io/docs/en/static/walle-en.gif)

## CHANGELOG
[CHANGELOG](https://github.com/meolu/walle-web/releases)


Discussing
----------
- [submit issue](https://github.com/meolu/walle-web/issues/new)
- email: wushuiyong@huamanshu.com
