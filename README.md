## About it

<a href="https://packagist.org/packages/gocanto/attributes"><img src="https://img.shields.io/packagist/dt/gocanto/attributes.svg?style=flat-square" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/gocanto/attributes"><img src="https://img.shields.io/github/v/release/gocanto/attributes.svg?style=flat-square" alt="Latest Stable Version"></a>
<a href="https://travis-ci.org/gocanto/attributes"><img src="https://img.shields.io/travis/gocanto/attributes/master.svg?style=flat-square" alt="Build status"></a>

Attributes is a data holder bag that allows you to `validate` your application data `integrity` before performing 
any important task, such as `API integrations` request, storing data in your `database`, `HTTP` request data validation
and so on. 

Attributes `does not` target any specific stack within your application; in fact, you will be able to new up any object
that extends from its `base clase` and have a trusted data bag to work with.

## Installation

This library uses [Composer](https://getcomposer.org) to manage its dependencies. So, before using it, make sure you
have it installed in your machine.

Once you have done this, you will be able to pull this library in by typing the following command in your terminal.

```bash
composer require gocanto/attributes
```

## The reason behind it

There are many use cases when you need to perform a `HTTP request`, persist some data in your `application database` or
just process some request to return some `responses`. To do so, you need to be sure that the data you are working with
is type safe because there are many process in your application that depend on valid inputs. 

For instance, if you are integrating with a `payment gateway` and your are required to pass the amount as `string`, you
need to make sure the related input abides by this `rule`, otherwise, your request will fail. 

Another example might be `persisting some payment transaction` in your database; for this, you need to trust that the
data your are saving abides by the `database constraints`. So in case there was any failure, you can return early to 
the applicatoion and prompt valida messages errors to your users.

Lastly, imagine you are working on a `SDK` to integrate with any given `3rd party API` and you need to comunicate to
your `consumers` what data you required along with `their type`. Here, this package come handy since you can build your
object by extending the `Attribuets class` and have this functionality out the box.

## How does it work?

The way how this package work is very simple, you just need to create a plain object and make it extends the 
[abstract attributes](https://github.com/gocanto/attributes/blob/master/src/Attributes.php) class shipped with this 
code base. Like so: 

```php
use Gocanto\Attributes\Attributes;

class MyValueObject extends Attributes
{
    ///
}
```

After you have created your class, you will be able to use it up as shown bellow.

```php
$value = new MyValueObject([
    'name' => 'Gustavo',
    'last_name' => 'Ocanto',
]);
```

Here, the provided data will be guarded by any rules you might want to constraint your value object data with since
these data validations happen on the constructor level.

## Composing rules

To validate your value objects data, you will have to overwrite the Attributes method
[getValidationRules](https://github.com/gocanto/attributes/blob/master/src/Attributes.php#L89) to expose the 
contraints you need to kick in for each key within the provided data array. Like so

```php
use Gocanto\Attributes\Attributes;
use Gocanto\Attributes\Rules\Validators\Required;

class MyValueObject extends Attributes
{
    public function getValidationRules(): array
    {
        return [
            'name' => [new Required],
            'last_name' => [new Required],
        ];
    }
}
```

Once you have this in place, you will need to provide a valid input for the `name & last name` key. Otherwise, an 
[attributes](https://github.com/gocanto/attributes/blob/master/src/AttributesException.php) exception will be thrown.

```php
//good
$value = new MyValueObject([
    'name' => 'Gustavo',
    'last_name' => 'Ocanto',
]);

//bad
$value = new MyValueObject([
    'name' => '',
    'last_name' => null,
]);
```

## Custome rules

Creating custom validation rules is an easy task using this package. The only thing you have to do to accomplish such a 
task is to implement the [constraint interface](https://github.com/gocanto/attributes/blob/master/src/Rules/Constraint.php) 
on the object you are holding the validation rule. After you have done that, 
you can new up this new validation rule to validate your data against it.

You can see an example of objects implementing this interface in [here](https://github.com/gocanto/attributes/tree/master/src/Rules/Validators).
Also, you might want to take a look at these consumers [examples](https://github.com/gocanto/attributes/blob/master/tests/AttributesTest.php)
for you to understand how to validate your inputs.

## Contributing

Please feel free to fork this package and contribute by submitting a pull request to enhance its functionality.

## License

The MIT License (MIT). Please see [License File](https://github.com/gocanto/attributes/blob/master/LICENSE.md) for 
more information.

## How can I thank you?
Why not star the github repo and share the link for this repository on Twitter?

Don't forget to [follow me on twitter](https://twitter.com/gocanto)!

Thanks!

Gustavo Ocanto.




