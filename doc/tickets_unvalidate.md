# Unvalidate a ticket

Unvalidate a ticket

- URL: `/tickets/unvalidate/:id` or `/tickets/unvalidate/:barcode`
- Method: `POST`
- URL Params: `None`
- Form Data Params: `None`
- Success Response:
```
{
    "message": null,
    "url": "/admin/tickets/view/919719022",
    "code": 200,
    "data": [
        {
            "id": 960,
            "barcode": 919719022,
            "type": "perm",
            "paid": false,
            "state": "pending",
            "user_code": "",
            "firstname": "Mathieu",
            "lastname": "Bour",
            "gender": "M",
            "birthdate": "1998-04-30T00:00:00+00:00",
            "email": "Mathieu.tin.bour@gmail.com",
            "address": "6 Rue de Vieilleville",
            "zip_code": "57070",
            "city": "Metz",
            "latitude": null,
            "longitude": null,
            "created": "2016-12-10T12:30:38+00:00",
            "validated": null # <- Check validation here ->
        }
    ],
}
```