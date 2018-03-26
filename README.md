# Sktm

[![Join the chat at https://gitter.im/sktm/Lobby](https://badges.gitter.im/sktm/Lobby.svg)](https://gitter.im/sktm/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bantenprov/sktm/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/sktm/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/bantenprov/sktm/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/sktm/build-status/master)
[![Latest Stable Version](https://poser.pugx.org/bantenprov/sktm/v/stable)](https://packagist.org/packages/bantenprov/sktm)
[![Total Downloads](https://poser.pugx.org/bantenprov/sktm/downloads)](https://packagist.org/packages/bantenprov/sktm)
[![Latest Unstable Version](https://poser.pugx.org/bantenprov/sktm/v/unstable)](https://packagist.org/packages/bantenprov/sktm)
[![License](https://poser.pugx.org/bantenprov/sktm/license)](https://packagist.org/packages/bantenprov/sktm)
[![Monthly Downloads](https://poser.pugx.org/bantenprov/sktm/d/monthly)](https://packagist.org/packages/bantenprov/sktm)
[![Daily Downloads](https://poser.pugx.org/bantenprov/sktm/d/daily)](https://packagist.org/packages/bantenprov/sktm)


# Sktm
Sktm

### Install via composer

- Development snapshot

```bash
$ composer require bantenprov/sktm:dev-master
```

- Latest release:

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
    //....
    Bantenprov\Sktm\SktmServiceProvider::class,
```

#### Lakukan migrate :

```bash
$ php artisan migrate
```

#### Publish database seeder :

```bash
$ php artisan vendor:publish --tag=sktm-seeds

```

#### Lakukan auto dump :

```bash
$ composer dump-autoload
```

#### Lakukan seeding :

```bash
$ php artisan db:seed --class=BantenprovSktmSeeder
```

#### Lakukan publish component vue :

```bash
$ php artisan vendor:publish --tag=sktm-assets
$ php artisan vendor:publish --tag=sktm-public
```
#### Tambahkan route di dalam file : `resources/assets/js/routes.js` :

```javascript
{
    path: '/dashboard',
    redirect: '/dashboard/home',
    component: layout('Default'),
    children: [
        //== ...
       {
        path: '/dashboard/sktm',
        components: {
            main: resolve => require(['./components/views/bantenprov/sktm/DashboardSktm.vue'], resolve),
            navbar: resolve => require(['./components/Navbar.vue'], resolve),
            sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
        },
        meta: {
            title: "Sktm"
        }
      }
        //== ...
    ]
},
```

```javascript
{
    path: '/admin',
    redirect: '/admin/dashboard/home',
    component: layout('Default'),
    children: [
        //== ...
        {
            path: '/admin/sktm',
            components: {
                main: resolve => require(['./components/bantenprov/sktm/Sktm.index.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Sktm"
            }
        },
        {
            path: '/admin/sktm/create',
            components: {
                main: resolve => require(['./components/bantenprov/sktm/Sktm.add.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Sktm"
            }
        },
        {
            path: '/admin/sktm/:id',
            components: {
                main: resolve => require(['./components/bantenprov/sktm/Sktm.show.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Sktm"
            }
        },
        {
            path: '/admin/sktm/:id/edit',
            components: {
                main: resolve => require(['./components/bantenprov/sktm/Sktm.edit.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Sktm"
            }
        },
        //== ...
    ]
},
```
#### Edit menu `resources/assets/js/menu.js`

```javascript
{
    name: 'Dashboard',
    icon: 'fa fa-dashboard',
    childType: 'collapse',
    childItem: [
        //== ...
        {
          name: 'Sktm',
          link: '/dashboard/sktm',
          icon: 'fa fa-angle-double-right'
      }
        //== ...
    ]
},
```

```javascript
{
    name: 'Admin',
    icon: 'fa fa-lock',
    childType: 'collapse',
    childItem: [
        //== ...
        {
            name: 'Sktm',
            link: '/admin/sktm',
            icon: 'fa fa-angle-double-right'
          }
        //== ...
    ]
},
```

#### Tambahkan components `resources/assets/js/components.js` :

```javascript

//== Example Vuetable

import Sktm from './components/bantenprov/sktm/Sktm.chart.vue';
Vue.component('echarts-sktm', Sktm);

import SktmKota from './components/bantenprov/sktm/SktmKota.chart.vue';
Vue.component('echarts-dpp-bank-dinia-kota', SktmKota);

import SktmTahun from './components/bantenprov/sktm/SktmTahun.chart.vue';
Vue.component('echarts-dpp-bank-dinia-tahun', SktmTahun);

import SktmAdminShow from './components/bantenprov/sktm/SktmAdmin.show.vue';
Vue.component('admin-view-sktm-tahun', SktmAdminShow);

//== Echarts Sktm

import SktmBar01 from './components/views/bantenprov/sktm/SktmBar01.vue';
Vue.component('sktm-bar-01', SktmBar01);

import SktmBar02 from './components/views/bantenprov/sktm/SktmBar02.vue';
Vue.component('sktm-bar-02', SktmBar02);

//== mini bar charts
import SktmBar03 from './components/views/bantenprov/sktm/SktmBar03.vue';
Vue.component('sktm-bar-03', SktmBar03);

import SktmPie01 from './components/views/bantenprov/sktm/SktmPie01.vue';
Vue.component('sktm-pie-01', SktmPie01);

import SktmPie02 from './components/views/bantenprov/sktm/SktmPie02.vue';
Vue.component('sktm-pie-02', SktmPie02);

//== mini pie charts
import SktmPie03 from './components/views/bantenprov/sktm/SktmPie03.vue';
Vue.component('sktm-pie-03', SktmPie03);
