# classified-ads
This is  RESTful JSON API for classified ads

## Requirements
Pleased make sure you have [Docker](https://www.docker.com/) and docker-compose installed

## Setup
To set this up, please follow the instructions below

```console
$ git clone https://github.com/sidibos2/classified-ads.git
$ cd classified-ads
$ docker-compose up -d
```

### Database setup
Run the Database migration command as follow
```console
php artisan migrate
```
Then run the command to do the seeding

```console
$ php artisan db:seed --class=UsersTableSeeder
```

## Testing the API
You could use postman to try the api endpoints as follow

### Create an Ad

```console
// The API endpoint is

$ http://localhost:8080/api/ad

// the method is POST

// The request header should be structured as follow

'Content-Type' => 'application/json'
'Authorization' => 'TkpJe8qr9hjbqPwCHi0n' // the token value

// The body should be structured as follow

{
	"title": "Test title 7",
	"description": "Test description",
	"price": 7.89
}
``` 

### Update an Ad

```console
// The API endpoint is

$ http://localhost:8080/api/ad/{id}

// the method is PUT

// The request header should be structured as follow

'Content-Type' => 'application/json'
'Authorization' => 'TkpJe8qr9hjbqPwCHi0n' // the token value

{
	"title": "Test title 7",
	"description": "Test description",
	"price": 7.89
}
```

### Get all Ads

```console
// The API endpoint is

$ http://localhost:8080/api/list-ad

// the method is GET

// The response will be a JSON array of all the ads
```

## Running the test
Run the following command from your project root 

```console
$ ./vendor/bin/phpunit tests 
```



