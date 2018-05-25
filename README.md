# Pickr API

This API was built for the [Second Tighten Dev Battle](https://battle.tighten.co). You can read more about the battle on our blog [here](https://tighten.co/blog/tighten-dev-battle-2-native).

## Installation

This API is built using [Laravel 5.6](https://laravel.com/docs/5.6). If you would like to install it locally, you can follow the instructions within the Laravel documentation. [Valet](https://laravel.com/docs/5.6/valet) is recommended for OSX and [Homestead](https://laravel.com/docs/5.6/homestead) for Windows/Linux. 

You will also need PHP 7.1, [Composer](https://getcomposer.org/), and either MySQL or MariaDB.

To install:

- Clone this repo into your projects directory via `$ git clone git@github.com:tightenco/pickr-api.git`.
- Navigate to the directory using `$ cd pickr-api`
- Create a database via MySQL or MariaDB (recommended name is `pickr`)
- Copy the `.env.example` file to `.env` and update the `APP_URL` and database variables based on your environment setup
- Run `$ composer install` to install all dependencies
- Run `$ php artisan key:generate` to generate the `APP_KEY` in your `.env` file
- Run `$ php artisan migrate`
- Run `$ php artisan passport:install` to create the [Laravel Passport](https://laravel.com/docs/5.6/passport) encryption keys needed for authentication

## Using the API

You can find all routes listed in the `routes/api.php` file. All endpoints are also tested in the `tests/Feature` directory.

We recommend you use a tool like [Postman](https://www.getpostman.com/) to interact with the API.

If you would like to use the API locally without authentication, you can switch to the `no-auth` branch. You will, however, still need to create a user, since a `user_id` of 1 is hard-coded at various places in the code on that branch:

**Example:**
```
POST http://pickr-api.test/api/users

HEADERS: {
  Content-Type: application/json,
  Accept: application/json
}

BODY: {
  email: samantha@tighten.co,
  name: Samantha Geitz,
  password: password
}

RESPONSE: {
    "name": "Samantha Geitz",
    "email": "samantha@tighten.co",
    "updated_at": "2018-05-25 14:09:51",
    "created_at": "2018-05-25 14:09:51",
    "id": 1
}

```

If you are using authentication, you will need to make an OAuth password grant request. Using the user created as an example, here is how you would get an access token:


**Example:**
```
POST http://pickr-api.test/oauth/token

HEADERS: {
  Content-Type: application/json,
  Accept: application/json
}

BODY: {
  username: samantha@tighten.co,
  password: password,
  grant_type: password,
  client_id: 2, // found in oauth_clients table via "Pickr Password Grant Client" 'id' field
  client_secret: Q5Hp9z3L9l44SHc2PNTvp01bXn6fWBw0IJLC10Rp // found in oauth_clients table via "Pickr Password Grant Client" 'secret' field
}

RESPONSE: {
    "token_type": "Bearer",
    "expires_in": 31536000,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ijk4YzRlNmU2YWQ3MmVkYzViYWIzODQyMzgzYjFkZTBlYTNlNzVlNmQxNjA5NjY3ZjcwNDE4NGY4NDA4NGI1YTUwZGNkNjA0YThjZDM0ZTc2In0.eyJhdWQiOiIyIiwianRpIjoiOThjNGU2ZTZhZDcyZWRjNWJhYjM4NDIzODNiMWRlMGVhM2U3NWU2ZDE2MDk2NjdmNzA0MTg0Zjg0MDg0YjVhNTBkY2Q2MDRhOGNkMzRlNzYiLCJpYXQiOjE1MjcyNTc2ODYsIm5iZiI6MTUyNzI1NzY4NiwiZXhwIjoxNTU4NzkzNjg2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.R1WK4jBxvK1SJ_916VEMwrc6F1k43j51Cq2Y5AWvAHWvqcQYg44q5GVvZxFlYIDWRLx9fv3wOXt4tfNLIK4X6Niab_bkMaZ42RVtIfOzpv49hI3t5CYilYpMs5heiE-kL4HSXeyKyJ5ewpI3FdFdsccprMQZkRQGEPPsRgFRjoSKPErVw-MBGCruC2OP__0LpBROiCXrMsB6IAHEO3_H2hGOgjWf8xakiI0lTwFfJn1WBbSrDNCHNyxCHfPn-HlIatNnLfOpmVwY6Rkf4WQhRTBcKgLASlf-fGguMpgcnnCbTzIemoEKkTwP2INdppi9T7Qhkcn5KyHLoPGezORzoL6BTMC798_APXbKv6ZEWkeJeiUxCxl1qFkNGqQfBA6f61eX_b2EQ_Yrn5eLhJPkmVIyZF59Ne4_UnPj0gg6Gmw4F1-jLu1AJBS-P_FZBT2xPjaP0nyAYd-pDwWpzd49Q9weTYBKhD7hzJBCy0t2ngjXSLpOTyAAAG_kMh5PbWhv-WbCO0GJKVXXPlainkBI67lQiHVl40SVOqKO3943Y1jZ6nxefCXQ1GX7o0fzuJ6FfUdchxwSgg6efl5OCvY2ov8mhiRwf_zUiLFZtu-2Ds2Zj4Y7Zy1hMIPVB9MOuD4_Zp9ygPO6MT8-J7FJMYhiLf1uhUA_V12S4O9iJ31LXZU",
    "refresh_token": "def50200729cce267124b0e19630c6a6d7cd3ab1615d4355bdf757870b06cc65cf9b484b819efde44a4d827f5683b60c26f9e6c8e131a66c74df2ecb529cd2f9d1ebe0fc0d2b78d4b45cc594d174a1e01ee13e2311d9e77d4cefc51e867ac425306ac6abe952dfbe73ef982749d48ebd93e32c7516f722b3025873e4bfe9ad1f0f1cf582cea30e770f4d7c279619a87860658ff23ffb0cf7119704c9aa761e59ce4d405a9c874207e0147337bb58aa2ff6103d86008d87e6cd26be4d4db505eeb4477d004dd7d616e2aeead6cf94e94960165ffdc308fef8f1e47fc2ccf5b51b6ac3e5d7d5efe5edab4f15d09064fe83f12cb26783901d9f33d7972ad76bbc37968e6a4227072501ea4e192c89b56fd944bef06eb9bd2c12bb2f184cc8a0f0114a85f802a41d97ab67b47d9ee99e998f12133cfebbbdc8a893adc98e3d6ccb0d2fcf46b7e6329c6719de6166fe53f33107c967f07280e6909ff04809443f3f9164"
}

```

Then, you would use the `access_token` returned above to make API calls to the protected endpoints via an `Authorization: Bearer <access_token>` header value:

**Example:**
```
POST http://pickr-api.test/api/categories

HEADERS: {
  Content-Type: application/x-www-form-urlencoded,
  Accept: application/json,
  Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ijk4YzRlNmU2YWQ3MmVkYzViYWIzODQyMzgzYjFkZTBlYTNlNzVlNmQxNjA5NjY3ZjcwNDE4NGY4NDA4NGI1YTUwZGNkNjA0YThjZDM0ZTc2In0.eyJhdWQiOiIyIiwianRpIjoiOThjNGU2ZTZhZDcyZWRjNWJhYjM4NDIzODNiMWRlMGVhM2U3NWU2ZDE2MDk2NjdmNzA0MTg0Zjg0MDg0YjVhNTBkY2Q2MDRhOGNkMzRlNzYiLCJpYXQiOjE1MjcyNTc2ODYsIm5iZiI6MTUyNzI1NzY4NiwiZXhwIjoxNTU4NzkzNjg2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.R1WK4jBxvK1SJ_916VEMwrc6F1k43j51Cq2Y5AWvAHWvqcQYg44q5GVvZxFlYIDWRLx9fv3wOXt4tfNLIK4X6Niab_bkMaZ42RVtIfOzpv49hI3t5CYilYpMs5heiE-kL4HSXeyKyJ5ewpI3FdFdsccprMQZkRQGEPPsRgFRjoSKPErVw-MBGCruC2OP__0LpBROiCXrMsB6IAHEO3_H2hGOgjWf8xakiI0lTwFfJn1WBbSrDNCHNyxCHfPn-HlIatNnLfOpmVwY6Rkf4WQhRTBcKgLASlf-fGguMpgcnnCbTzIemoEKkTwP2INdppi9T7Qhkcn5KyHLoPGezORzoL6BTMC798_APXbKv6ZEWkeJeiUxCxl1qFkNGqQfBA6f61eX_b2EQ_Yrn5eLhJPkmVIyZF59Ne4_UnPj0gg6Gmw4F1-jLu1AJBS-P_FZBT2xPjaP0nyAYd-pDwWpzd49Q9weTYBKhD7hzJBCy0t2ngjXSLpOTyAAAG_kMh5PbWhv-WbCO0GJKVXXPlainkBI67lQiHVl40SVOqKO3943Y1jZ6nxefCXQ1GX7o0fzuJ6FfUdchxwSgg6efl5OCvY2ov8mhiRwf_zUiLFZtu-2Ds2Zj4Y7Zy1hMIPVB9MOuD4_Zp9ygPO6MT8-J7FJMYhiLf1uhUA_V12S4O9iJ31LXZU
}

BODY: {
  name: Test Category 
}

 RESPONSE: {
    "name": "Test Category",
    "user_id": 1,
    "updated_at": "2018-05-25 14:19:18",
    "created_at": "2018-05-25 14:19:18",
    "id": 1
}

```
