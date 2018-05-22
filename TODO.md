1. Pecah menu SKM menjadi du bagian, satu untuk admin sekolah satu lagi untuk administrator

-- Menu admin sekolah

```javascript
{
    name: 'Admin Sekolah',
    icon: 'fa fa-lock',
    childType: 'collapse',
    childItem: [
        //...
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
-- Menu administratot

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
        //...
    ]
},
``` 