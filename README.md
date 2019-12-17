## About it

Attributes is a based bag data holder that allows you to `validate` your application data `integrity` before performing 
any important task, such as `API integrations` request, storing data in your `database`, `HTTP` request data validation
and so on. 

Attributes `does not` target any specific stack within your application; in fact, you will be able to new up any object
that extends from its `base clase` and have a trusted data to work with.

## Installation

This library uses [Composer](https://getcomposer.org) to manage its dependencies. So, before using it, make sure you
have it installed in your machine.

Once you have done this, you will be able to pull this library in by typing the following command in your terminal.

```bash
composer require gocanto/attributes
```

## The reason behind it

There are many cases when you need to perform a `HTTP request`, persist some data in your `application databases` or
just process some request to return some `responses`. To do so, you need to be sure that the data you are working with
is valid and type safe because there are process in your application that depend on valid inputs. 

For instance, if you are integrating with a `payment gateway` and your are required to pass the amount as `string`, you
need to make sure the related input abides by this `rule`, otherwise, your request will fail. 

Another example might be `persisting some payment transaction` in your database; for this, you need to trust that the
data your are saving abides by the `database constraints`, otherwise, you can return early to the applicatoion and
prompt valida messages errors to your users.

Lastly, imagine you are working on a `SDK` to integrate with any given `3rd party API` and you need to comunicate to
your `consumers` what data you required along with `their type`. Here, this package come handy since you can build your
object by extending the `Attribuets class` and have this functionality out the box.
