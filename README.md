# blade
php模板引擎，来自laravel

### 安装

`composer require igo9go/blade`

### 调用

1. 引入composer包

2. 定义views目录和cache目录

3. 调用view()函数


```
 <?php
  
require __DIR__ . '/vendor/autoload.php';

define('VIEWPATH', 'views');
define('CACHEPATH', 'cache');


echo view('homepage', ['name' => 'John Doe']);
```