# Login

Login into the API

- URL: `/login`
- Method: `POST`
- URL Params: `None`
- Form Data Params
    - Required: `email=[string]` & `password=[string]`
- Success Response:
```
{
    "message": "Connexion établie",
    "url": "/admin/login",
    "code": 200,
    "data": null
}
```
- Error Response
```
{
    "message": "Identifiants incorrects",
    "url": "/admin/login",
    "code": 401,
    "data": null
}
```