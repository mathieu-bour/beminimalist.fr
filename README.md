# beminimalist.fr

Official Minimalist website.

Written by Mathieu Bour, based on CakePHP.

## REST API

NB: All request are supposed prefixed by `https://beminimalist.fr/admin`

Methods :

-  [/login](doc/users_login.md)
-  [/tickets/view](doc/tickets_view.md)
-  [/tickets/validate](doc/tickets_validate.md)
-  [/tickets/unvalidate](doc/tickets_unvalidate.md)

Remarks

- All requests require:
    - to be logged with an administrator account
    - to use the following HTTP Header: `Accept: application/json` (otherwise the server willl return the HTML page)
    - the cookie `CAKEPHP` returned on `login`
