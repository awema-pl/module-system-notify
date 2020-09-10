# SystemNotify

[![Composer Ready](https://www.awema.pl/awema-pl/module-system-notify/status.svg)](https://www.awema.pl/)
[![Downloads](https://www.awema.pl/awema-pl/module-system-notify/downloads.svg)](https://www.awema.pl/)
[![Last version](https://www.awema.pl/awema-pl/module-system-notify/version.svg)](https://www.awema.pl/) 


This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Documentation

[Russian](./docs/index.md)

## NPM scripts

Development mode `npm run watch` or simply `npm start`
Development mode for IE `npm run watch:legacy`
Production build `npm run build`

## Installation

Via Composer

``` bash
$ composer require awema-pl/module-system-notify
```

The package will automatically register itself.

## Usage

Create a container to display notifications in:

```php
@notify(['name' => 'container', 'stack' => false, 'config' => "{theme: 'inline', timeout: 0}"])
```

[More info about custom containers](./docs/system-notify-container.md)

```php
// notify in different styles to specific container
Notify::info('title', 'message')->to('container');
Notify::error('title', 'message')->to('container');
Notify::warning('title', 'message')->to('container');
Notify::success('title', 'message')->to('container');

// add button to notification
Notify::notify('title', 'message', 'success')
    ->withButton([
        'text' => 'Install now', // button cta text, required
        'url' => '/path', // required
        'data' => [ 'param' => 'some param' ], // payload, if needed
        'method' => 'patch'// if needed, POST by default
    ])->to('container');
```

[More info about notification options](./docs/system-notify.md)

### Helper function also available:

```php
alert('title', 'message', 'info')->to('container');
```

### Messages allowed to include basic HTML:

```php
alert('title', '<a href="/path">message</a>', 'info')->to('container');
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.

## Credits

- [:author_name][link-author]
- [All Contributors][link-contributors]

## License

GNU General Public License v3.0. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/awema-pl/module-system-notify.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/awema-pl/module-system-notify.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/awema-pl/module-system-notify/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/awema-pl/module-system-notify
[link-downloads]: https://packagist.org/packages/awema-pl/module-system-notify
[link-travis]: https://travis-ci.org/awema-pl/module-system-notify
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/awema-pl
[link-contributors]: ../../contributors]
