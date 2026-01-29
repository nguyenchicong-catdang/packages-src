# composer.json
```composer.json
{
    "name": "vendor-path/package-src",
    "description": "Một package siêu cấp SRC",
    "autoload": {
        "psr-4": {
            "Vendorpath\\Src\\": "src/",
            "Vendorpath\\Wp\\": "wp/"
        }
    }
}
```
## trong du an chinh
```composer.json
{
    "repositories": [
        {
            "type": "path",
            "url": "../packages-src",
            "options": {
                "symlink": true
            }
        }
    ],
    "require": {
        "vendor-path/package-src": "dev-main"
    }
}
```
## run
> composer update vendor-path/package-src

> composer dump-autoload

## use
> use Vendorpath\Src

> use Vendorpath\Wp