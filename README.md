# SKTM

[![Join the chat at https://gitter.im/sktm/Lobby](https://badges.gitter.im/sktm/Lobby.svg)](https://gitter.im/sktm/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bantenprov/sktm/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/sktm/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/bantenprov/sktm/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/sktm/build-status/master)
[![Latest Stable Version](https://poser.pugx.org/bantenprov/sktm/v/stable)](https://packagist.org/packages/bantenprov/sktm)
[![Total Downloads](https://poser.pugx.org/bantenprov/sktm/downloads)](https://packagist.org/packages/bantenprov/sktm)
[![Latest Unstable Version](https://poser.pugx.org/bantenprov/sktm/v/unstable)](https://packagist.org/packages/bantenprov/sktm)
[![License](https://poser.pugx.org/bantenprov/sktm/license)](https://packagist.org/packages/bantenprov/sktm)
[![Monthly Downloads](https://poser.pugx.org/bantenprov/sktm/d/monthly)](https://packagist.org/packages/bantenprov/sktm)
[![Daily Downloads](https://poser.pugx.org/bantenprov/sktm/d/daily)](https://packagist.org/packages/bantenprov/sktm)

SKTM

### Install via composer

- Development snapshot

```bash
$ composer require bantenprov/sktm:dev-master
```

- Latest release:

```bash
$ composer require bantenprov/sktm
```

### Download via github

```bash
$ git clone https://github.com/bantenprov/sktm.git
```

#### Edit `config/app.php` :

```php
'providers' => [
    /*
    * Laravel Framework Service Providers...
    */
    Illuminate\Auth\AuthServiceProvider::class,
    Illuminate\Broadcasting\BroadcastServiceProvider::class,
    Illuminate\Bus\BusServiceProvider::class,
    Illuminate\Cache\CacheServiceProvider::class,
    Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
    Illuminate\Cookie\CookieServiceProvider::class,
    //...
    Bantenprov\Sktm\SktmServiceProvider::class,
    //...
```

#### Lakukan migrate :

```bash
$ php artisan migrate
```

#### Lakukan publish semua komponen :

```bash
$ php artisan vendor:publish --tag=sktm-publish
```

#### Lakukan auto dump :

```bash
$ composer dump-autoload
```

#### Lakukan seeding :

- Seeding semua seeder

```bash
$ php artisan db:seed --class=BantenprovSktmSeeder
```

- Seeding secara individual

```bash
$ php artisan db:seed --class=BantenprovSktmSeederMasterSktm
$ php artisan db:seed --class=BantenprovSktmSeederSktm
```

#### Edit menu `resources/assets/js/menu.js`

```javascript
{
    name: 'Dashboard',
    icon: 'fa fa-dashboard',
    childType: 'collapse',
    childItem: [
        //...
        // Master SKTM
        {
            name: 'Master SKTM',
            link: '/dashboard/master-sktm',
            icon: 'fa fa-angle-double-right'
        },
        // SKTM
        {
            name: 'SKTM',
            link: '/dashboard/sktm',
            icon: 'fa fa-angle-double-right'
        },
        //...
    ]
},
```

```javascript
{
    name: 'Admin',
    icon: 'fa fa-lock',
    childType: 'collapse',
    childItem: [
        //...
        // Master SKTM
        {
            name: 'Master SKTM',
            link: '/admin/master-sktm',
            icon: 'fa fa-angle-double-right'
        },
        // SKTM
        {
            name: 'SKTM',
            link: '/admin/sktm',
            icon: 'fa fa-angle-double-right'
        },
        //...
    ]
},
```

#### Tambahkan components `resources/assets/js/components.js` :

```javascript
//... Master SKTM ...//

import MasterSktmAdminShow from '~/components/bantenprov/sktm/master-sktm/MasterSktmAdmin.show.vue';
Vue.component('master-sktm-admin', MasterSktmAdminShow);

//... Echarts Master SKTM ...//

import MasterSktm from '~/components/bantenprov/sktm/master-sktm/MasterSktm.chart.vue';
Vue.component('master-sktm-echarts', MasterSktm);

import MasterSktmKota from '~/components/bantenprov/sktm/master-sktm/MasterSktmKota.chart.vue';
Vue.component('master-sktm-echarts-kota', MasterSktmKota);

import MasterSktmTahun from '~/components/bantenprov/sktm/master-sktm/MasterSktmTahun.chart.vue';
Vue.component('master-sktm-echarts-tahun', MasterSktmTahun);

//... Mini Bar Charts Master SKTM ...//

import MasterSktmBar01 from '~/components/views/bantenprov/sktm/master-sktm/MasterSktmBar01.vue';
Vue.component('master-sktm-bar-01', MasterSktmBar01);

import MasterSktmBar02 from '~/components/views/bantenprov/sktm/master-sktm/MasterSktmBar02.vue';
Vue.component('master-sktm-bar-02', MasterSktmBar02);

import MasterSktmBar03 from '~/components/views/bantenprov/sktm/master-sktm/MasterSktmBar03.vue';
Vue.component('master-sktm-bar-03', MasterSktmBar03);

//... Mini Pie Charts Master SKTM ...//

import MasterSktmPie01 from '~/components/views/bantenprov/sktm/master-sktm/MasterSktmPie01.vue';
Vue.component('master-sktm-pie-01', MasterSktmPie01);

import MasterSktmPie02 from '~/components/views/bantenprov/sktm/master-sktm/MasterSktmPie02.vue';
Vue.component('master-sktm-pie-02', MasterSktmPie02);

import MasterSktmPie03 from '~/components/views/bantenprov/sktm/master-sktm/MasterSktmPie03.vue';
Vue.component('master-sktm-pie-03', MasterSktmPie03);

//... SKTM ...//

import SktmAdminShow from '~/components/bantenprov/sktm/sktm/SktmAdmin.show.vue';
Vue.component('sktm-admin', SktmAdminShow);

//... Echarts SKTM ...//

import Sktm from '~/components/bantenprov/sktm/sktm/Sktm.chart.vue';
Vue.component('sktm-echarts', Sktm);

import SktmKota from '~/components/bantenprov/sktm/sktm/SktmKota.chart.vue';
Vue.component('sktm-echarts-kota', SktmKota);

import SktmTahun from '~/components/bantenprov/sktm/sktm/SktmTahun.chart.vue';
Vue.component('sktm-echarts-tahun', SktmTahun);

//... Mini Bar Charts SKTM ...//

import SktmBar01 from '~/components/views/bantenprov/sktm/sktm/SktmBar01.vue';
Vue.component('sktm-bar-01', SktmBar01);

import SktmBar02 from '~/components/views/bantenprov/sktm/sktm/SktmBar02.vue';
Vue.component('sktm-bar-02', SktmBar02);

import SktmBar03 from '~/components/views/bantenprov/sktm/sktm/SktmBar03.vue';
Vue.component('sktm-bar-03', SktmBar03);

//... Mini Pie Charts SKTM ...//

import SktmPie01 from '~/components/views/bantenprov/sktm/sktm/SktmPie01.vue';
Vue.component('sktm-pie-01', SktmPie01);

import SktmPie02 from '~/components/views/bantenprov/sktm/sktm/SktmPie02.vue';
Vue.component('sktm-pie-02', SktmPie02);

import SktmPie03 from '~/components/views/bantenprov/sktm/sktm/SktmPie03.vue';
Vue.component('sktm-pie-03', SktmPie03);
```

#### Tambahkan route di dalam file : `resources/assets/js/routes.js` :

```javascript
{
    path: '/dashboard',
    redirect: '/dashboard/home',
    component: layout('Default'),
    children: [
        //...
        // Master SKTM
        {
            path: '/dashboard/master-sktm',
            components: {
                main: resolve => require(['~/components/views/bantenprov/sktm/master-sktm/MasterSktmDashboard.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Master SKTM"
            }
        },
        // SKTM
        {
            path: '/dashboard/sktm',
            components: {
                main: resolve => require(['~/components/views/bantenprov/sktm/sktm/SktmDashboard.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "SKTM"
            }
        },
        //...
    ]
},
```

```javascript
{
    path: '/admin',
    redirect: '/admin/dashboard/home',
    component: layout('Default'),
    children: [
        //...
        // Master SKTM
        {
            path: '/admin/master-sktm',
            components: {
                main: resolve => require(['~/components/bantenprov/sktm/master-sktm/MasterSktm.index.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Master SKTM"
            }
        },
        {
            path: '/admin/master-sktm/create',
            components: {
                main: resolve => require(['~/components/bantenprov/sktm/master-sktm/MasterSktm.add.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Add Master SKTM"
            }
        },
        {
            path: '/admin/master-sktm/:id',
            components: {
                main: resolve => require(['~/components/bantenprov/sktm/master-sktm/MasterSktm.show.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "View Master SKTM"
            }
        },
        {
            path: '/admin/master-sktm/:id/edit',
            components: {
                main: resolve => require(['~/components/bantenprov/sktm/master-sktm/MasterSktm.edit.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Edit Master SKTM"
            }
        },
        // SKTM
        {
            path: '/admin/sktm',
            components: {
                main: resolve => require(['~/components/bantenprov/sktm/sktm/Sktm.index.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "SKTM"
            }
        },
        {
            path: '/admin/sktm/create',
            components: {
                main: resolve => require(['~/components/bantenprov/sktm/sktm/Sktm.add.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Add SKTM"
            }
        },
        {
            path: '/admin/sktm/:id',
            components: {
                main: resolve => require(['~/components/bantenprov/sktm/sktm/Sktm.show.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "View SKTM"
            }
        },
        {
            path: '/admin/sktm/:id/edit',
            components: {
                main: resolve => require(['~/components/bantenprov/sktm/sktm/Sktm.edit.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Edit SKTM"
            }
        },
        //...
    ]
},
```
