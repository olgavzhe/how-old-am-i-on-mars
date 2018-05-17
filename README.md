# How Old Am I On Mars
API service for calculating an age in Mars days and years based on date of birth on Earth.

## Installation
### Configuration Files
Create configuration files for Docker and Laravel.
```bash
$ cp .env.example .env
$ cp docker-compose.yml.example docker-compose.yml
```
#### Configuration variable checklist

<table>
    <thead>
        <tr>
            <th>File</th>
            <th>Variable</th>
            <th>Notes</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td rowspan=4><strong>.env</strong></td>
            <td><code>FACEBOOK_APP_ID</code></td>
            <td>
            Facebook Application Id. Go to h<a href="https://developers.facebook.com">Facebook Dashboard</a> and get your application id.
            </td>
        </tr>
        <tr>
            <td></td>
            <td><code>FACEBOOK_APP_SECRET</code></td>
            <td>
            Facebook Application Secret. Go to <a href="https://developers.facebook.com">Facebook Dashboard</a> <strong>Settings</strong> > <strong>Basic</strong> > <strong>App Secret</strong>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><code>FACEBOOK_CALLBACK_URL</code></td>
            <td>
            A callback URL, it should be the same as in <a href="https://developers.facebook.com">Facebook Dashboard</a> <strong>Facebook Login</strong> > <strong>Settings</strong> > <strong>Valid OAuth Redirect URIs</strong>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><code>FACEBOOK_GRAPH_VERSION</code></td>
            <td>
            Facebook Graph API version. By default, v2.10.
            </td>
        </tr>
        <tr>
            <td></td>
            <td><code>USER_PASSWORD_SECRET</code></td>
            <td>
            A secret string to generate a new user password.
            </td>
        </tr>
    </tbody>
</table>

Make changes according to your environment.
### Install Dependencies
```bash
$ composer install
```
### Run Docker
```bash
$ docker-compose up
```
### Application Key
```bash
$ docker-compose exec app php artisan key:generate
```

## Run
### API
Make API call:
* `http://0.0.0.0:8080/mymarsage/date-of-birth` - to get your age on Mars, where `date-of-birth` is a date in YYYYMMDD format
* `http://0.0.0.0:8080/amIAllowedToDrinkAlcoholOnMars/date-of-birth` - to get to know if you are allowed to drink alcohol on Mars, where `date-of-birth` is a date in YYYYMMDD format

## Good to know
### General Artisan
```bash
$ docker-compose exec app php artisan some:command
```
### Unit Tests
```bash
$ docker-compose exec app php vendor/bin/phpunit
```